<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\chats;
use App\Models\GroupChat;
use App\Models\group;
use App\Events\MessageEvent;
use App\Events\GroupMessageEvent;
use App\Events\sendNotification;

class UserController extends Controller
{
    public function loadDashboard()
    {
        $users = User::whereNotIn("id", [auth()->user()->id])->get();
        return view('dashboard', compact('users'));
    }

    public function saveChat(Request $request)
    {


        try {

            $chat =  chats::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message
            ]);
            event(new MessageEvent($chat));

            return response()->json(['Success' => true, 'data' => $chat]);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function loadchats(Request $request)
    {


        try {

            $chats = chats::where(function ($query) use ($request) {
                $query->where('sender_id', '=', $request->sender_id)
                    ->orwhere('sender_id', '=', $request->receiver_id);
            })->where(function ($query) use ($request) {
                $query->where('receiver_id', '=', $request->sender_id)
                    ->orwhere('receiver_id', '=', $request->receiver_id);
            })->get();



            return response()->json(['Success' => true, 'data' => $chats]);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function loadGroups()
    {
        $groups =  Group::where('creator_id', auth()->user()->id)->get();

        return view('groups', compact('groups'));
    }



    public function createGroup(Request $request)
    {

        try {

            $imageName = "";

            if ($request->image) {

                $imageName = time() . '.' . $request->image->extension();

                $request->image->move(public_path('images'), $imageName);

                $imageName = 'images/' . $imageName;
            }


            Group::insert([

                'creator_id' => auth()->user()->id,
                'name' => $request->name,
                'image' => $imageName,
                'join_limit' => $request->limit
            ]);

            return response()->json(['Success' => true, 'msg' => $request->name . 'Group created successfully']);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function getMembers(Request $request)
    {

        try {
            $users =  User::with(['groupUser' => function ($query) use ($request) {
                $query->where('group_id', $request->group_id);
            }])


                ->whereNotIn('id', [auth()->user()->id])->get();
            return response()->json(['Success' => true, 'data' => $users]);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function addMembers(Request $request)
    {
        try {
            if (empty($request->members)) {
                return response()->json(['Success' => false, 'msg' => 'please add members']);
            } else if (count($request->members) > (int)$request->limit) {
                return response()->json(['Success' => false, 'msg' => 'limit exceeded']);
            } else {

                Member::where('group_id', $request->group_id)->delete();
                $data = [];
                $x = 0;
                foreach ($request->members as $user) {

                    $data[$x] = ['group_id' => $request->group_id, 'user_id' => $user];
                    $x++;
                }
                Member::insert($data);


                return response()->json(['Success' => true, 'msg' => "Members added succesfully"]);
            }
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function deleteGroup(Request $request)
    {

        try {
            Group::where('id', $request->id)
                ->delete();
            Member::where('group_id', $request->id)
                ->delete();
            return response()->json(['Success' => true]);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function shareGroup($id)
    {

        $groupData = Group::where('id', $id)->first();


        if ($groupData) {

            $totalMembers = Member::where('group_id', $id)->count();


            $available = $groupData->join_limit - $totalMembers;


            $isOwner = $groupData->creator_id == auth()->user()->id;


            $isJoined = Member::where(
                [
                    [
                        'group_id', '=', $id
                    ],
                    [
                        'user_id', '=', auth()->user()->id
                    ],
                ]
            )

                ->exists();


            return view('shareGroup', compact('groupData', 'totalMembers', 'available', 'isOwner', 'isJoined'));
        } else {

            return view('404');
        }
    }


    public function joinGroup(Request $request)
    {

        try {

            Member::insert([
                'group_id' => $request->group_id,
                'user_id' => auth()->user()->id,


            ]);



            return response()->json(['success' => true, 'msg' => 'congratulations, you have joined']);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function groupchats()
    {
        $groups = Group::where('creator_id', auth()->user()->id)->get();
        $joinedGroups = Member::with('getGroup')->where('user_id', auth()->user()->id)->get();
        return view('group-chats', compact(['groups', 'joinedGroups']));
    }


    public function saveGroupChat(Request $request)
    {
        try {
            $chat = GroupChat::create([
                'sender_id' => $request->sender_id,
                'group_id' => $request->group_id,
                'message' => $request->message
            ]);

            $chat = GroupChat::with('userData')->where('id', $chat->id)->first();
            event(new GroupMessageEvent($chat));
            return response()->json(['Success' => true, 'data' => $chat]);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }


    public function loadGroupChats(Request $request)
    {
        try {
            $chats = GroupChat::with('userData')->where('group_id', $request->group_id)->get();
            return response()->json(['Success' => true, 'chats' => $chats]);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'msg' => $e->getMessage()]);
        }
    }



    public function sendPusher(){

        event(new sendNotification('hello world','my-channel','my-event'));
    }
}

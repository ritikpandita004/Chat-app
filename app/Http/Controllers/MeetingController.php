<?php

namespace App\Http\Controllers;

use App\Models\UserMeeting;
use App\Models\MeetingEntry;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function meetingUser()
    {
        return view('createMeeting');
    }

    public function createMeeting()
    {

        $meeting = Auth::user()->getUserMeetingInfo()
            ->first();

        if (!isset($meeting->id)) {
            $name = 'agora' . rand(1111, 9999);
            $meetingData = createAgoraProject($name);
            if (isset($meetingData->project->id)) {

                $meeting = new UserMeeting();
                $meeting->user_id = Auth::User()->id;
                $meeting->app_id = $meetingData->project->vendor_key;
                $meeting->appCertificate = $meetingData->project->sign_key;
                $meeting->channel = $meetingData->project->name;
                $meeting->uid = rand(1111, 9999);
                $meeting->save();
            } else {
                echo "project not created";
            }
        }

        $meeting = Auth::user()
            ->getUserMeetingInfo()
            ->first();
        $token = createToken($meeting->app_id,
        $meeting->appCertificate,
        $meeting->channel);
        $meeting->token = $token;
        $meeting->url = generateRandomString();
        $meeting->save();

        if (Auth::user()->id == $meeting->user_id) {
            Session::put('meeting', $meeting->url);
        }
        return redirect('joinMeeting/' . $meeting->url);
    }


    public function joinMeeting($url = "")
    {
        $meeting =  UserMeeting::where('url', $url)->first();
        if (isset($meeting->id)) {
            $meeting->app_id         = trim($meeting->app_id);

            $meeting->appCertificate = trim($meeting->appCertificate);

            $meeting->channel        = trim($meeting->channel);

            $meeting->token          = trim($meeting->token);

            if(Auth::user()->id == $meeting->user_id){


            }
            else{
                if(!Auth::user()){
                    $random_user = rand(111111,999999);
                    $this->createEntry($meeting->$user_id, $random_user, $meeting->$url);
                }


                else{
                    $this->createEntry($meeting->$user_id, Auth::user()->id, $meeting->$url);
                }
            }

            return view('joinUser', get_defined_vars());

        }
        else {

        }
    }

    public function createEntry($user_id, $random_user, $url)
    {
        $entry              = new MeetingEntry();
        $entry->user_id     = $user_id;
        $entry->random_user = $random_user;
        $entry->url         = $url;
        $entry->status      = 0;
        $entry->save();
    }

}


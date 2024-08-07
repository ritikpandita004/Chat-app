<?php

use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pusher', function () {
    return view('pusher');
});
Route::get('/pusher2', function () {
    return view('pusher2');
});

Route::get('/dashboard', [UserController::class, 'loadDashboard'])->middleware(['auth'])->name('dashboard');

Route::get('/sendPusher', [UserController::class, 'sendPusher'])->middleware(['auth'])->name('sendPusher');

require __DIR__.'/auth.php';

Route::post('/save-chats', [UserController::class, 'saveChat']);

Route::post('/load-chats', [UserController::class, 'loadchats']);


Route::get('/groups', [UserController::class, 'loadGroups'])->middleware(['auth'])->name('groups');

Route::post('/create-group', [UserController::class, 'createGroup'])->middleware(['auth'])->name('createGroup');

Route::post('/get-members', [UserController::class, 'getMembers'])->middleware(['auth'])->name('getMembers');
Route::post('/add-member', [UserController::class, 'addMembers'])->middleware(['auth'])->name('addMembers');

Route::post('/delete-group', [UserController::class, 'deleteGroup'])->middleware(['auth'])->name('deleteGroup');

Route::get('/share-group/{id}', [UserController::class, 'shareGroup'])->middleware(['auth'])->name('shareGroup');


Route::post('/join-group', [UserController::class, 'joinGroup'])->middleware(['auth'])->name('joinGroup');

Route::get('/group-chats', [UserController::class, 'groupChats'])->middleware(['auth'])->name('groupChats');


Route::post('/save-group-chat', [UserController::class, 'saveGroupChat'])->middleware(['auth'])->name('saveGroupChat');

Route::post('/load-group-chats', [UserController::class, 'loadGroupChats'])->middleware(['auth'])->name('saveGroupChat');

Route::get('/meeting', [MeetingController::class, 'meetingUser'])->middleware(['auth'])->name('meetingUser');


Route::get('/createMeeting', [MeetingController::class, 'createMeeting'])->middleware(['auth'])->name('createMeeting');

Route::get('/joinMeeting/{url}', [MeetingController::class, 'joinMeeting'])->middleware(['auth'])->name('joinMeeting');


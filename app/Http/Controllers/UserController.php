<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use App\Message;
use App\Post;
use Illuminate\Support\Facades\DB;
use Mail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $keyword;
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user) {
            echo $user->name . '<br>';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (!$this->checkRight($request->id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        User::create($request->all());

        return "Utilisateur créé !";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $nbrPosts = Post::where('user_id', '=', $user->id)->count();
        $user->nbrPosts = $nbrPosts;
        return view('Users.show', compact('user'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('Users.editUsers', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$this->checkRight($user->id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user->update($data);
        return view('Users.show', compact('user'));
    }

    public function getMessages(Request $request)
    {
        $this->keyword = $request->get('search');
        if (!empty($this->keyword)) {
            $receivedMessage = Message::where('receiver_id', "=", Auth::id())
                ->where(function ($query) {
                    $query->where('title', 'LIKE', "%$this->keyword%")
                        ->orWhere('content', 'LIKE', "%$this->keyword%");
                })->latest()->paginate();
            $sentMessage = Message::where('sender_id', "=", Auth::id())
                ->where(function ($query) {
                    $query->where('title', 'LIKE', "%$this->keyword%")
                        ->orWhere('content', 'LIKE', "%$this->keyword%");
                })->latest()->paginate();
        } else {
            $receivedMessage = Message::where('receiver_id', "=", Auth::id())->latest()->paginate();
            $sentMessage = Message::where('sender_id', "=", Auth::id())->latest()->paginate();
        }
        foreach ($receivedMessage as $message) {
            $message->sender = User::findOrFail($message->sender_id);
            $message->receiver = User::findOrFail($message->receiver_id);
        }
        foreach ($sentMessage as $message) {
            $message->sender = User::findOrFail($message->sender_id);
            $message->receiver = User::findOrFail($message->receiver_id);
        }
        $messages = ['sent' => $sentMessage, 'received' => $receivedMessage];
        return view('Users.messagesUsers', compact('messages'));
    }



//    /**
//     * Send an e-mail reminder to the user.
//     *
//     * @param  Request  $request
//     * @param  int  $id
//     * @return Response
//     */
//    public function sendEmailReminder(Request $request, $id)
//    {
//        $user = User::findOrFail($id);
//
//        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
//            $m->from('hello@app.com', 'Your Application');
//
//            $m->to($user->email, $user->name)->subject('Your Reminder!');
//        });
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!$this->checkRight($user->id)) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        $user->delete();
        Auth::logout();
        return redirect('login');
    }

    public function destroyForm(User $user)
    {
        return view('Users.destroyUsers', compact('user'));
    }
}

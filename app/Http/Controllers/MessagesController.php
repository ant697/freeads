<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Message;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    /**
     * MessagesController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $messages = Message::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $messages = Message::latest()->paginate($perPage);
        }
        foreach ($messages as $message) {
            $sender = User::findOrFail($message->sender_id);
            $receiver = User::findOrFail($message->receiver_id);
            $post = Post::findOrFail($message->post_id);
//                $data = ['user' => $user, 'post' => $post];
            $message->sender = $sender;
            $message->receiver = $receiver;
            $message->post = $post;
        }
        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($post_id, $sender_id, $receiver_id)
    {
        $data = ['post_id' => $post_id, 'sender_id' => $sender_id, 'receiver_id' => $receiver_id];
        return view('messages.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
//        var_dump('<pre>', '<h3>(Auth::id() === $id || Auth::user()->role === \'admin\')(Auth::id() === $id || Auth::user()->role === \'admin\')</h3>', (Auth::id() === $request->sender_id || Auth::user()->role === 'admin'), '</pre>');
//        die(var_dump('<pre>', '<h3>sender</h3>',$request->sender_id,$this->checkRight($request->sender_id), Auth::id(),
//            $this->getRefererPerm(), '</pre>'));
        if (!$this->checkRight($request->sender_id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        $this->validate($request, [
        'title' => 'required',
        'content' => 'required'
        ]);
        $requestData = $request->all();
//        $requestData['sender_id'] = Auth::id();
//        die(var_dump('<pre>', '<h3>$request</h3>', $request,'<h2>tada</h2>', '</pre>'));
        Message::create($requestData);

        return redirect('users/' . Auth::id() . '/messages')->with('flash_message', 'Message added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {

        $message = Message::findOrFail($id);
        if ((!$this->checkRight($message->sender_id) && !$this->checkRight($message->receiver_id)) ||
            $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        $sender = User::findOrFail($message->sender_id);
        $receiver = User::findOrFail($message->receiver_id);
        $post = Post::findOrFail($message->post_id);
        $data = ['sender' => $sender, 'post' => $post, 'receiver' => $receiver];
        if (!$message->viewed) {
            DB::table('messages')
                ->where('id', $id)
                ->update(['viewed' => true]);
        }
        return view('messages.show', compact('message'), compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        $message = Message::findOrFail($id);

        return view('messages.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        if (!$this->checkRight($request->sender_id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        $this->validate($request, [
        'title' => 'required',
        'content' => 'required'
        ]);
        $requestData = $request->all();
        
        $message = Message::findOrFail($id);
        $message->update($requestData);

        return redirect('messages')->with('flash_message', 'Message updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $msg = Message::findOrFail($id);
        if (!$this->checkRight($msg->sender_id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        Message::destroy($id);
        return redirect('users/' . Auth::id() . '/messages')->with('flash_message', 'Message deleted!');
    }
}

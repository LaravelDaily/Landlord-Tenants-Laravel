<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\MessengerTopic;
use App\Http\Controllers\Controller;

class MessengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Auth::user()->topics()->with('receiver', 'sender')->orderBy('sent_at', 'desc')->get();
        $title  = 'Messages';

        return view('admin.messenger.index', compact('topics', 'title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = [];
        if (! auth()->user()->property_id) {
            $users = User::whereIn('property_id',
                Property::where('user_id', auth()->user()->id)->pluck('id'))->pluck('name', 'id');
        } else {
            $users = User::where('id', auth()->user()->property->user_id)->pluck('name', 'id');
        }

        return view('admin.messenger.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMessageRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        $sender = Auth::user()->id;

        MessengerTopic::create([
            'subject'     => $request->input('subject'),
            'sender_id'   => $sender,
            'receiver_id' => $request->input('receiver'),
            'sent_at'     => Carbon::now(),
        ])->read()
            ->messages()->create([
                'sender_id' => $sender,
                'content'   => $request->input('content'),
            ]);

        return redirect()->route('admin.messenger.index');
    }

    /**
     * Display the specified resource.
     *
     * @param MessengerTopic $topic
     * @return \Illuminate\Http\Response
     * @internal param MessengerTopic $topic
     * @internal param int $id
     */
    public function show(MessengerTopic $topic)
    {

        $user = Auth::user();
        if ($topic->receiver->id != $user->id && $topic->sender->id != $user->id) {
            return abort(401);
        }

        $topic->load('receiver', 'sender', 'messages');
        $unreadMessages = [];
        foreach ($topic->messages as $message) {
            if ($message->unread($topic)) {
                $unreadMessages[] = $message->id;
            }
        }
        $topic->read();

        return view('admin.messenger.show', compact('topic', 'unreadMessages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param MessengerTopic $topic
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(MessengerTopic $topic)
    {
        $user = Auth::user();
        if ($topic->receiver->id != $user->id && $topic->sender->id != $user->id) {
            return abort(401);
        }
        $topic->load('receiver', 'sender');
        $user = $topic->otherPerson()->name;

        return view('admin.messenger.reply', compact('topic', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateMessageRequest|Request $request
     * @param MessengerTopic $topic
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateMessageRequest $request, MessengerTopic $topic)
    {


        $user = Auth::user();
        if ($topic->receiver->id != $user->id && $topic->sender->id != $user->id) {
            return abort(401);
        }

        $topic->sent_at = Carbon::now();
        $topic->save();
        $topic->read();
        $topic->messages()->create([
            'sender_id' => Auth::user()->id,
            'content'   => $request->input('content'),
        ]);

        return redirect()->route('admin.messenger.show', $topic->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MessengerTopic $topic
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(MessengerTopic $topic)
    {
        $user = Auth::user();
        if ($topic->receiver->id != $user->id && $topic->sender->id != $user->id) {
            return abort(401);
        }

        $topic->delete();

        return redirect()->route('admin.messenger.index');
    }

    public function inbox()
    {
        $topics = Auth::user()->inbox()->with('receiver', 'sender')->orderBy('sent_at', 'desc')->get();
        $title  = 'Inbox';

        return view('admin.messenger.index', compact('topics', 'title'));
    }

    public function outbox()
    {
        $topics = Auth::user()->outbox()->with('receiver', 'sender')->orderBy('sent_at', 'desc')->get();
        $title  = 'Outbox';

        return view('admin.messenger.index', compact('topics', 'title'));
    }
}

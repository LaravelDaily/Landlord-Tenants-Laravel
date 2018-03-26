<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MessengerTopic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subject',
        'sender_id',
        'receiver_id',
        'sent_at'
    ];
    protected $dates = [
        'sent_at',
    ];

    public function messages()
    {
        return $this->hasMany(MessengerMessage::class, 'topic_id')->orderBy('sent_at', 'desc');
    }

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    public function otherPerson()
    {
        if ($this->receiver_id == Auth::user()->id) {
            return $this->sender;
        }

        return $this->receiver;
    }

    public static function unreadInboxCount()
        {
            $topics = Auth::user()->topics()->get();
            $count = 0;
            foreach($topics as $topic) {
                if ($topic->receiver_id == Auth::user()->id) {
                    if ($topic->unread()) {
                        $count++;
                    }
                }
            }
            return $count;
        }

        public static function countUnread()
        {
            $topics = Auth::user()->topics()->get();
            $count = 0;
            foreach ($topics as $topic) {
                if ($topic->unread()) {
                    $count++;
                }
            }
            return $count;
        }

    public function unread()
    {
        $type    = $this->userType();
        $read_at = $type . "_read_at";
        if (! $this->{$read_at}) {
            return true;
        }

        if ($this->sent_at > $this->{$read_at}) {
            return true;
        }

        return false;

    }

    public function read()
    {
        $type             = $this->userType();
        $read_at          = $type . "_read_at";
        $this->{$read_at} = Carbon::now();
        $this->save();

        return $this;
    }

    public function userType()
    {
        $user = Auth::user();
        $type = 'receiver';
        if ($this->sender_id == $user->id) {
            $type = 'sender';
        }

        return $type;
    }

}

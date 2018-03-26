<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MessengerTopic;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MessengerMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'topic_id',
        'sender_id',
        'content'
    ];
    protected $dates = [
        'sent_at'
    ];
    public $with = ['sender'];


    public function topic()
    {
        return $this->belongsTo(MessengerTopic::class);
    }

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function unread($topic)
    {
        $user = Auth::user();
        if ($this->sender->id == $user->id) {
            return false;
        }
        $read_at = $topic->userType() . "_read_at";
        $read_at = $topic->{$read_at};
        if (! $read_at) {
            return true;
        }
        if ($this->sent_at > $read_at) {
            return true;
        }

        return false;

    }
}

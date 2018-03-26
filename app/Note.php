<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Note
 *
 * @package App
 * @property string $property
 * @property string $user
 * @property text $note_text
*/
class Note extends Model
{
    use SoftDeletes;

    protected $fillable = ['note_text', 'property_id', 'user_id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPropertyIdAttribute($input)
    {
        $this->attributes['property_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }
    
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id')->withTrashed();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}

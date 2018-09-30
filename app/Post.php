<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'picture1', 'picture2', 'picture3', 'picture4', 'picture5', 'price', 'category', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}

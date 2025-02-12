<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
	protected $fillable = ['title','link','content','created_at','category','author'];
    protected $table = 'BlogPosts';
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Post extends Model { protected $fillable=['title','slug','excerpt','content','featured_image','seo_title','meta_description','status','author_id']; public function author(){return $this->belongsTo(User::class,'author_id');} }

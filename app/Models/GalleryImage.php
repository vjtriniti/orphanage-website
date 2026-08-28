<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GalleryImage extends Model { protected $fillable=['gallery_id','path','caption','published']; protected $casts=['published'=>'boolean']; public function gallery(){return $this->belongsTo(Gallery::class);} }

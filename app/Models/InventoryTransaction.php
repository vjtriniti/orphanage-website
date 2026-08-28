<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InventoryTransaction extends Model { protected $fillable=['inventory_id','type','quantity','reason','user_id']; protected $casts=['quantity'=>'decimal:2']; public function item(){return $this->belongsTo(InventoryItem::class,'inventory_id');} }

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class InventoryItem extends Model { protected $table='inventory'; protected $fillable=['inventory_category_id','name','unit','quantity','reorder_level','supplier']; protected $casts=['quantity'=>'decimal:2','reorder_level'=>'decimal:2']; public function category(){return $this->belongsTo(InventoryCategory::class,'inventory_category_id');} public function transactions(){return $this->hasMany(InventoryTransaction::class,'inventory_id');} public function getLowStockAttribute(){return (float)$this->quantity <= (float)$this->reorder_level;} }

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = ['name','price','available_quantity','category_id','slug'];
    protected $hidden = ['deleted_at'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

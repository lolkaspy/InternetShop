<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $fillable = ['id','user_id','state','total', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_lists');
    }
    public function orderLists()
    {
        return $this->hasMany(OrderList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

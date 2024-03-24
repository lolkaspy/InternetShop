<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'categories';
    protected $fillable = ['name', 'slug'];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}

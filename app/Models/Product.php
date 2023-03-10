<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    // ini untk fitur softdeletes
    use SoftDeletes;

    // name table
    protected $table = 'products';

    // fields apa saja yang boleh diisi
    // protected $fillable = [
    //     'name', 'price', 'description', 'image'
    // ];

    // fields apa saja yang tidak boleh diisi
    protected $guarded = ['id'];
}

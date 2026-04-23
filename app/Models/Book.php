<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class Book extends Model
    {
        protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'category_id',
        'image'
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function category()
{
    return $this->belongsTo(Category::class);
}
}

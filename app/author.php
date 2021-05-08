<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;

class author extends Model
{
    protected $fillable = [
        'name'
    ];

    public function books(){
        return $this->hasMany(Book::class);
    }
}

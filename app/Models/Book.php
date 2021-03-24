<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;

class Book extends Model
{
    use HasFactory;

    //rysis aprasomas laisvai pasirenkama funkcija(funkcijos vardas nieko nereiskia)
    public function bookAuthor()
    {
       return $this->belongsTo(Author::class, 'author_id', 'id');
    }

}

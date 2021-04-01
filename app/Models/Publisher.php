<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Publisher extends Model
{
    use HasFactory;

    public static function create(Request $request) 
    {
        $publisher = new self;
        $publisher->title = $request->publisher_title;
        $publisher->save();
    }

    public function publisherBooksList()
    {
        return $this->hasMany('App\Models\Book', 'publisher_id', 'id');
    }

    public function edit(Request $request)
    {
        $this->title = $request->publisher_title;
        $this->save();
    }
}

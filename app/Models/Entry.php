<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'attachment' => 'array'
    ];

    protected $table = 'entry';

    public function category_id() {
        return $this->belongsTo('App\Models\EntryCategory', 'category_id', 'id');
    }

    public function author_id() {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }
}

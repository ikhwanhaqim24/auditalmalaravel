<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCategory extends Model
{
    use HasFactory;

    protected $table = 'entry_category';
    
    public function name() {
        return $this->hasMany('App\Models\Entry');
    }
}

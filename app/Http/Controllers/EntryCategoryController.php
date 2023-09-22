<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntryCategory;

class EntryCategoryController extends Controller
{
    public function getName($id){
        $entry = EntryCategory::find($id);

        if ($entry === null) $entry = "Null";
        else $entry = $entry->name;

        return $entry;
    }

    public function getId($name){
        $entry = EntryCategory::where('name', $name)->get();

        if ($entry === null) $entry = 1;
        else $entry = $entry->id;

        return $entry;
    }
}

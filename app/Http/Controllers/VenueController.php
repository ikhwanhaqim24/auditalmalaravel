<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;

class VenueController extends Controller
{
    public function index(){
        return;
    }

    public function getByColumn($column = 'id', $searchQuery = '1', $amount = -1){
        $query = Venue::where($column, $searchQuery);

        if ($amount >= 0) {
            $query = $query->take($amount);
        }

        $query = $query->get();

        return $query;
    }

    public function getById($id) {
        $query = Venue::findOrFail($id);
        return $query;
    }

    // by name
    // by address
    // by Postcode
    // by State
    // by District
    // by reservation date
    // by creation date
}

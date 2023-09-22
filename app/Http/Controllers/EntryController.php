<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\EntryCategory;
use App\Models\User;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class EntryController extends Controller
{
    public function index(){

        //$entries = Entry::paginate(5);

        $entries = Entry::with('category_id:id,name,type')->paginate(5); // toArray()
        $categories = EntryCategory::all();
        $categorylist = $categories->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
        $authors = User::all()->sortBy('id', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');

        return view('audit.index', compact(['categories', 'entries', 'authors', 'categorylist']));
    }

    public function show($id){

        $entry = $this->getById($id);
        $categories = EntryCategory::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id');
        $author = User::findOrFail($entry->author_id);

        return view('audit.show', ['entry' => $entry, 'categories' => $categories, 'author' => $author]);
    }

    public function getByColumn($column = 'id', $searchQuery = '1', $amount = -1){
        $query = Entry::where($column, $searchQuery);

        if ($amount >= 0) {
            $query = $query->take($amount);
        }

        $query = $query->get();

        return $query;
    }

    public function getById($id) {
        $query = Entry::findOrFail($id);
        return $query;
    }

    public function showByCategory($categoryId = 1, $amount = -1) {
        $query = $this->getByColumn('category', $categoryId, $amount);

        return $query;
    }

    public function showByAmount($queryAmount = 0.00, $amount = -1){
        $query = Entry::whereBetween('amount',[($queryAmount-($queryAmount/4)), ($queryAmount+($queryAmount/4))]);
        return;
    }

    // by ID
    // by details/name
    // by amount
    // by date created
    // by category
    // by author

    public function store(){
        return;
    }
    
    public function edit($id, $request){

        $entry = $this->getById($id) ;

        $entry->details = request('details');
        $entry->amount = floatval(request('amount'));
        $entry->category_id = request('category');
        $status = $entry->isDirty();
        $entry->save();

        return $status;
    }

    public function postMethod(Request $request){
        $message = "";
        $link = "/audit";

        if (request('action') == 'Edit') {
           $status = $this->edit(request('id'), request());

           $link .= '/';
           $link .= request('id');
           
            if ($status) {
                $message = "Successfully edited!";
            } else {
                $message = "Nothing has changed";
                return redirect($link)->with('warn', $message);
            }
        }
        else if (request('action') == 'Delete') {
            return $this->destroy(request('id'));
        }

        return redirect($link)->with('msg', $message);
    }

    public function destroy($id){
        $entry = Entry::findOrFail($id);

        $entry->delete();

        return redirect('/audit')->with([
            'msg' => 'Successfully deleted entry!',
            'id' => $id
        ]);
    }

    public function restore($id){

        $entry = Entry::withTrashed()->find($id);

        if (!$entry->trashed()) {
            return redirect(route('entry.index'))->with('err', 'There is error while doing that.');
        }
        else $entry->restore();

        return redirect(route('entry.show', $id))->with('msg', 'Successfully restored this entry!');;
    }
}

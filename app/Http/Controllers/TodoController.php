<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::orderBy('completed')->get();
        return view('layouts.index')->with(['todos' => $todos]);
    }

    public function create(){
        return view('layouts.create');
    }

    public function upload(Request $request){
        $request->validate([
            'title' => 'required|max:255'
        ]);
        $todo = $request->title;
        Todo::create(['title' => $todo]);
        return redirect()->back()->with('success', "TODO is created successfully!");
    }

    public function edit($id){
        $todo = Todo::find($id);
        return view('layouts.edit')->with(['id' => $id, 'todo' => $todo]);
    }

    public function update(Request $request){
        $request->validate([
            'title' => 'required|max:255'
        ]);
        $updateTodo = Todo::find($request->id);
        $updateTodo->update(['title' => $request->title]);
        return redirect('/index')->with('success', "TODO is updated successfully!");
    }

    public function completed($id){
        $todo = Todo::find($id);
        if ($todo->completed){
            $todo->update(['completed' => false]);
            return redirect()->back()->with('success', "TODO is marked as incomplete!");
        }else {
            $todo->update(['completed' => true]);
            return redirect()->back()->with('success', "TODO is marked as complete!");
        }
    }

    public function delete($id){
        $todo = Todo::find($id);
        $todo->delete();
        return redirect()->back()->with('success', "TODO is deleted successfully!"); 
    }
}

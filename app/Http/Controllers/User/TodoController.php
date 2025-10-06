<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->query('search');
        return Inertia::render('user/todos/Index',[
            'todos' => Todo::where('user_id',auth()->user()->id)
                    ->when($searchTerm!==null,function($query) use ($searchTerm){
                        $query->where('description','like',"%{$searchTerm}%");
                    })
                    ->paginate(10)
                    ->withQueryString(),
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('user/todos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $body = $request->validate([
            'description' => ['required','min:5'],
            'status' => ['required','in:pending,in_progress,completed']
        ]);

        Todo::create([
            'description' => $body['description'],
            'status' => $body['status'],
            'user_id' => auth()->user()->id
        ]);

        return redirect('/user/todos');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        abort_if($todo->user_id !== auth()->user()->id,403);

        return Inertia::render('user/todos/Edit',[
            'todo' => $todo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        abort_if($todo->user_id !== auth()->user()->id,403);

        $body = $request->validate([
            'description' => ['required','min:5'],
            'status' => ['required','in:pending,in_progress,completed']
        ]);

        $todo->update([
            'description' => $body['description'],
            'status' => $body['status']
        ]);

        return redirect('/user/todos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        abort_if($todo->user_id !== auth()->user()->id,403);

        $todo->delete();

        return back();
    }
}

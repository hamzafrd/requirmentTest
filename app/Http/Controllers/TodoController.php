<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $todos = Todo::latest()->paginate(5);
        $todos_trashed = Todo::onlyTrashed()->get();

        return view('todo.index', compact('todos', 'todos_trashed'));
    }

    public function getTodos()
    {
        $todos = Todo::latest()->get();

        return response()->json($todos);
    }
    public function getTodosTrashed()
    {
        $todos = Todo::onlyTrashed()->latest()->get();

        return response()->json($todos);
    }

    public function test()
    {
        return response([]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required|min:5',
        ]);

        //create post
        Todo::create([
            'name'     => $request->name
        ]);

        //redirect to index
        return redirect()->route('todo.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::findOrFail($id);

        return view('todo.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::findOrFail($id);

        return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate form
        $this->validate($request, [
            'name'     => 'required|min:5',
        ]);

        $todo = Todo::findOrFail($id);

        // if ($request->is_done == 0) {
        //     $todo->update([
        //         'name'     => $request->name,
        //         'is_done' => 1,
        //     ]);
        // } else {
        //     $todo->update([
        //         'name'     => $request->name,
        //         'is_done' => 0,
        //     ]);
        // }
        $todo->update([
            'name'     => $request->name,
            'is_done' => $request->has('is_done') ? 1 : 0,
        ]);

        //redirect to index
        return redirect()->route('todo.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get post by ID
        $todo = Todo::findOrFail($id);
        //delete post
        $todo->delete();

        //redirect to index
        return redirect()->route('todo.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function recover($id)
    {
        $todo = Todo::onlyTrashed()->findOrFail($id);
        $todo->restore();
        return redirect()->route('todo.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function destroyPermanent($id)
    {
        $todo = Todo::onlyTrashed()->findOrFail($id);
        $todo->forceDelete();
        return redirect()->route('todo.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}

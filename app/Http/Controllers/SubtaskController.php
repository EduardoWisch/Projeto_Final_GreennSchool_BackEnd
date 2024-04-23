<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_task' => 'required',
            'title'=> 'required|string|max:50|unique:subtasks,title', // Corrigido
            'due_date'=> 'required|date',
            'description' => 'string'
        ], [
            'title.required' => 'O campo Título é obrigatório',
            'title.unique' => 'Este título já está sendo utilizado',
            'title.max' => 'O título deve ter no máximo 50 caracteres',
            'due_date.required' => 'O campo Data é obrigatório',
            'due_date.date' => 'O campo data deve ser uma data',
        ]);
        

        if($validation->fails()){
            return response()->json($validation->errors(), 422);
        }

        $subtask = Subtask::create([
            'id_task' => $request->input('id_task'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
        ]);

        return response()->json([
            'message' => 'Subtask criada',
            'subtask' => $subtask
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtask $subtask)
    {
        $validation = Validator::make($request->all(), [
            'title'=> 'string|max:50|unique:subtasks,title', // Corrigido
            'due_date'=> 'date',
            'description' => 'string'
        ], [
            'title.unique' => 'Este título já está sendo utilizado',
            'title.max' => 'O título deve ter no máximo 50 caracteres',
            'due_date.date' => 'O campo data deve ser uma data',
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 422);
        }

        $subtask->fill($request->input())->update();
        return response()->json([
          'message' => 'Tarefa atualizada',
          'subtask' => $subtask 
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
       /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtask $subtask)
    {
        $subtask->delete();

        return response()->json([
            'message' => 'Subtask deletada'

          ]);
    }
}

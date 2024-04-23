<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(Task::with('subtasks')->paginate($request->input('per_page') ?? 15));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title'=> 'required|string|max:50|unique:tasks,title',
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

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
        ]);

        return response()->json([
            'message' => 'Tarefa criada',
            'task' => $task,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
{
    $taskWithSubtasks = $task->load('subtasks'); 
    return response()->json($taskWithSubtasks);
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validation = Validator::make($request->all(), [
            'title'=> 'string|max:50|unique:tasks,title',
            'due_date'=> 'date',
            'description' => 'string',
            'status' => 'string|in:pending,completed'
        ], [  
            'title.unique' => 'Este título já está sendo utilizado',
            'title.max' => 'O título deve ter no máximo 50 caracteres',
            'due_date.date' => 'O campo data deve ser uma data',
            ]);

        if($validation->fails()){
            return response()->json($validation->errors(), 422);
        }

        $task->fill($request->input())->update();
        return response()->json([
          'message' => 'Tarefa atualizada',
          'task' => $task 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {

        if ($task->subtasks()->exists()) {
            // $task->subtasks()->delete();
            return response()->json([
                'message' => 'Essa tarefa possui subtarefas, exclua elas primeiro'
            ]);
        }

        $task->delete();

        return response()->json([
            'message' => 'Tarefa deletada'
          ]);
    }
}

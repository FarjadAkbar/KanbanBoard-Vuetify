<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\{
    Tasks,
    Status
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $statuses = Status::with('tasks')->orderBy('order')->get();
        $columns = [];

        foreach ($statuses as $status) {
            $column = [
                'title' => $status->title,
                'tasks' => []
            ];
        
            foreach ($status->tasks as $task) {
                $column['tasks'][] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'date' => $task->created_at->format('M d'),
                    'description' => $task->description
                ];
            }
        
            $columns[] = $column;
        }
        return Inertia::render('tasks', ['columns' => $columns]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
        ])->validate();
  
        Tasks::create($request->all());
  
        return redirect()->back()
                    ->with('message', 'task Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $tasks)
    {
        //
        Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
        ])->validate();
  
        if ($request->has('id')) {
            Tasks::find($request->input('id'))->update($request->all());
            return redirect()->back()
                    ->with('message', 'Task Updated Successfully.');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        if ($request->has('id')) {
            Tasks::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}

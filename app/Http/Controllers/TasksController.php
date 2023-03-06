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
        return Inertia::render('Tasks/Index', ['statuses' => $statuses]);
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
  
        if($request->id != ""){
            $task = Tasks::find($request->id);
        } else{
            $task = new Tasks();
        }
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status_id = $request->status_id;
        $task->order = 0;
        $task->user_id = auth()->user()->id;
        $task->save();
  
        return $task;
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
            'statuses' => ['required', 'array']
        ])->validate();
  
        foreach ($request->statuses as $status) {
            foreach ($status['tasks'] as $i => $task) {
                $order = $i + 1;
                if ($task['status_id'] !== $status['id'] || $task['order'] !== $order) {
                    Tasks::find($task['id'])
                        ->update(['status_id' => $status['id'], 'order' => $order]);
                }
            }
        }
        return $request->user()->statuses()->with('tasks')->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        // if ($request->has('id')) {
            Tasks::find($id)->delete();
            // return redirect()->back();
        // }
        return $id;
    }
}

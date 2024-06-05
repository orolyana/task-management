<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Constants\TaskConstants;

use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
         return view('task.create',[
            'priorities' => TaskConstants::getAllPriorities(),
            'projectId' => $project_id
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request, $projectId)
    {
            $validated = $request->validated();
            $task = new Task();

            if(!$task->saveValidatedData($validated ,$projectId)){
                throw new \ErrorException(__('global.something_went_wrong'));
            }
            return redirect()->route('show-project',['id' => $task->project_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($projectId, $id)
    {
        $task = Task::findOrFail($id);
        $projectId = $task->project_id;
        return view('task.update',[
            'task' => $task,
            'projectId' => $projectId,
            'priorities' => TaskConstants::getAllPriorities(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $projectId, $id)
    {
        $validated = $request->validated();
        $task = Task::findOrFail($id);

        if(!$task->saveValidatedData($validated ,$projectId)){
                throw new \ErrorException(__('global.something_went_wrong'));
        }

        return redirect()->route('show-project',['id' => $task->project_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $projectId = $task->project_id;
        $task->delete();

        return redirect()->route('show-project',['id' => $task->project_id]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Constants\TaskConstants;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.index', 
            [
                'projects' => Project::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    { 
       $validated = $request->validated();
       $project = Project::create($validated);

        return redirect()->route('show-project',['id' => $project->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('project.index', 
            [
                'projects' => [Project::findOrFail($id)],
                'selectedProjectId' => $id,
            ]);
    }

    public function reorderTasks($projectId ,Request $request){

        $newTopTask = Task::findOrFail($request->get('ids')[0]);
        $project =  Project::with(['tasks' => function ($query) {
            $query->orderBy('priority', 'asc');
        }])->findOrFail($projectId);

        $newTopTask->changeTaskPriorityToTop();
        if(!$newTopTask->saveQuietly()){
            return false;
         }
    
      return $project;
    }

    public function listProjectTasks(Request $request){
        
        $selectedProjectId = $request->get('selectedProjectId');

        $project =  Project::with(['tasks' => function ($query) {
            $query->orderBy('priority', 'asc');
        }])->findOrFail($selectedProjectId);

        $view = view('project.show', ['project' => $project ,    'priorities' => TaskConstants::getAllPriorities()]) ;
        return $view;   
            
    }
}

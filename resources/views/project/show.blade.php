@extends('Layout')

@section('content')
  <div id="">
      @include('project.list-project-tasks', ['project' => $project])
      <div class="card w-50 mx-auto m-4">
        <div class="card-header">
         {{__('project.note')}}
        </div>
          <p class="card-text p-2 project-note">{{$project->note}}</p>
        </div>
      </div>
  </div>
@endsection
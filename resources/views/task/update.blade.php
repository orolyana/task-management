@extends('Layout')

@section('content')
<div class="card p-2">
  <form method="POST" action="{{ url('project/'.$projectId.'/task/'.$task->id.'/update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">{{__('task.name')}}</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="name" value="{{$task->name}}">
            @error('name')
            <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>

        <div class="mb-3">
          <label for="priority" class="form-label">{{__('task.priority')}}</label>
          <select class="form-select" name="priority" aria-label="Default select example">
              <option selected>Select priority</option>
              @foreach($priorities as $key => $value)
                @if($task->priority == $key)
                  <option selected value="{{$key}}">{{$value}}</option>
                @else
                  <option value="{{$key}}">{{$value}}</option>
                @endif
              @endforeach
          </select>
          @error('priority')
          <p class="text-danger"> {{$message}} </p>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
  @endsection
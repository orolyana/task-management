@extends('Layout')


<div class="card p-3" >
  <form method="post" action="{{ url('project/'.$projectId.'/task/store') }}" id="create-task-form">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">{{__('task.name')}}</label>
        <input type="text" class="form-control" id="name" name="name" aria-describedby="name">
        @error('name')
        <p class="text-danger"> {{$message}} </p>
        @enderror
      </div>
      <div class="mb-3">
        <label for="priority" class="form-label">{{__('task.priority')}}</label>
      <select class="form-select" name="priority" aria-label="Default select example">
          <option value="" disabled selected>{{__('task.select_priority_placeholder')}}</option>
          @foreach($priorities as $key => $value)
          <option value="{{$key}}">{{$value}}</option>
          @endforeach
        </select>
        @error('priority')
      <p class="text-danger"> {{$message}} </p>
      @enderror
      </div>
      <button type="submit" class="btn btn-primary">{{__('global.save')}}</button>
    </form>
</div>
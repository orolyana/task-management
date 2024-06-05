  @extends('Layout')

  @section('content')
  <div class="card p-2">
    <form method="post" action="{{ url('project/store') }}">
        @csrf
        <div  class="form-group">
          <label for="name" class="form-label">{{__('project.title')}}</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
          @error('title')
          <p class="text-danger"> {{$message}} </p>
          @enderror
        </div>
        <div class="form-group">
            <label for="note">{{__('project.note')}}</label>
            <textarea class="form-control" name="note" id="note" rows="3"></textarea>
            @error('title')
             <p class="text-danger"> {{$message}} </p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-2">{{__('global.save')}}</button>
      </form>
  </div>
    @endsection
@extends('/layout')
@section('content')
<form action="/articles/{{$article->id}}" method="post">
@method('PUT')
  @csrf
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="mb-3">
    <label for="date" class="form-label">Date</label>
    <input type="date" name="date" id="date" class="form-control"
      value="{{$article->date}}">
  </div>
  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control"
    value="{{$article->name}}">
  </div>
  <div class="mb-3">
    <label for="short_desc" class="form-label">Short description</label>
    <input type="text" name="short_desc" id="short_desc" class="form-control"
    value="{{$article->short_desc}}">
  </div>
  <div class="mb-3">
    <label for="desc" class="form-label">Description</label>
    <input type="text" name="desc" class="form-control" id="desc"
    value="{{$article->desc}}">
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
@extends('/layout')
@section('content')
<form action="/comments/update/{{$comment->id}}" method="post">
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
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control"
    value="{{$comment->title}}">
  </div>
  <div class="mb-3">
    <label for="text" class="form-label">Short description</label>
    <input type="text" name="text" id="text" class="form-control"
    value="{{$comment->text}}">
  </div>
  
  <input type="hidden" name="article_id" id="article_id" class="form-control"
    value="{{$comment->article_id}}">

  <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
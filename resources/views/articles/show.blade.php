@extends('/layout')
@section('content')
<div class="container centered">
  <div class="card mb-4" style="width: calc(100% - 20px); max-width: 900px;">
    <div class="card-body">
      <h5 class="card-title">{{ $article['name'] }}</h5>
      <p class="card-text">{{ $article['short_desc']}}</p>
      <p>{{ $article['date'] }}</p>
      <p class="card-text">{{ $article['desc']}}</p>
      @can('update', $article)
      <div class="d-flex gap-2 mb-2">
        <a href="/articles/{{$article['id']}}/edit" class="btn btn-primary">Update Article</a>
        <form action="/articles/{{$article->id}}" method="post">
          @method('DELETE')
          @csrf
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
      @endcan
    </div>
  </div>
  
  <!-- Comments -->
  <div class="card text-center mb-5">
    <div class="card-header">
      <h3>Comments</h3>
      @if (isset($_GET['res']) && $_GET['res'] == 1)
      <div class="alert alert-success">
        Комментарий успешно добавлен и отправлен на модерацию.
      </div>
      @endif
    </div>
    <form action="/comments/store" method="post" class="form">
      <div class="card-body">
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
        <label for="title" class="form-label">TItle comment</label>
        <input type="text" name="title" id="" class="form-control">
          
        <label for="text" class="form-label">Text comment</label>
        <input type="text" name="text" id="" class="form-control">
        
        <input type="hidden" name="article_id" id="" value="{{ $article['id'] }}">
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
  

  @foreach ($comments as $comment)
    <div class="card mb-3" style="width: calc(100% - 40px);">
      <div class="card-body">
        <h5 class="card-title">{{ $comment['title'] }}</h5>
        <p class="card-text">{{ $comment['text']}}</p>
        <p>{{ $comment['date'] }}</p>
        @can('comment', $comment)
          <div class="d-flex gap-2">
            <a href="/comments/edit/{{$comment['id']}}" class="btn btn-primary">Update comment</a>
            <a href="/comments/delete/{{$comment['id']}}" class="btn btn-secondary">Delete comment</a>
          </div>
        @endcan
      </div>
    </div>
  @endforeach
  {{$comments->links()}}
</div>
@endsection
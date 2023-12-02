@extends('/layout')
@section('content')
<h1>Welcome</h1>
<ul class="list" style="display:flex; flex-wrap: wrap;">
  @foreach($articles as $article)
  <li>
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">{{ $article['name'] }}</h5>
        <p class="card-text">{{ $article['short_desc']}}</p>
        <p>{{ $article['date'] }}</p>
        <a href="/articles/{{$article['id']}}" class="btn btn-primary">Checkout news</a>
      </div>
    </div>
  </li>
  @endforeach
</ul>
{{ $articles->links()}}
@endsection
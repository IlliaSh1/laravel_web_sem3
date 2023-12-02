@extends('/layout')
@section('content')
<h1>Welcome</h1>
<ul class="list" style="display:flex; flex-wrap: wrap;">
  @foreach($articles as $article)
  <li>
    <div class="card" style="width: 18rem;">
      <img src="{{ '/imgs/'.$article['preview_image'] }}" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">{{ $article['name'] }}</h5>
        <p class="card-text">{{ $article['shortDesc'] ?? '' }}</p>
        <p>{{ $article['date'] }}</p>
        <a href="/galery/{{$article['full_image']}}" class="btn btn-primary">Go to gallery</a>
      </div>
    </div>
  </li>
  @endforeach
</ul>
@endsection
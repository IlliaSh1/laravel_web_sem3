@extends('/layout')
@section('content')
<div class="container centered">
    <table class="table">
        <thead>
            <tr>
                <td>Date</td>
                <td>Article name</td>
                <td>Title</td>
                <td>Text</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
            <tr>
                <th scope="row">{{$comment->created_at}}</th>
                @foreach($articles as $article)
                @if($comment->article_id == $article->id)
                <td>
                    <a href="/articles/{{$article->id}}">
                        {{$article->name}}
                    </a>
                </td>
                @endif
                @endforeach
                <td>{{$comment->title}}</td>
                <td>{{$comment->text}}</td>
                
                <td>
                    @if ($comment->accept == NULL && $comment->accept == 0)
                        <a href="/comments/accept/{{$comment->id}}" 
                            class="btn btn-primary">Accept</a>
                    @else
                        <a href="/comments/reject/{{$comment->id}}" 
                            class="btn btn-danger">Reject</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$comments->links()}}
</div>
@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminComment;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyNewComment;

use App\Models\User;

use App\Events\EventNewComment;

class CommentController extends Controller
{
    public function index() {
        $page = isset($_GET['page']) ? $_GET['page'] : 0;

        $data = Cache::rememberForever('comments: '.$page, function() {
            $comments = Comment::latest()->paginate(10);
            $articles = Article::all();

            return [
                'comments' => $comments,
                'articles' => $articles
            ];
        });


        return view('comments.index', [
            'comments' => $data['comments'], 
            'articles' => $data['articles']
        ]);
    }
    // Accepting comments.
    public function accept(int $id) {
        Gate::authorize('adminComment');
        $comment = Comment::findOrFail($id);

        $article = Article::findOrFail($comment->article_id);

        $comment->accept = true;
        $res = $comment->save();
        if ($res) {
            // Push new comment event.
            EventNewComment::dispatch($article);
            // Clear comments cache.
            $this->clearCommentsCache($comment);
        }
        return redirect()->route('comments');
    }
    public function reject(int $id) {
        Gate::authorize('adminComment');
        $comment = Comment::findOrFail($id);
        $comment->accept = false;
        $res = $comment->save();
        if ($res) {
            // Clear comments cache.
            $this->clearCommentsCache($comment);
        }
        return redirect()->route('comments');
    }
    //
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required',
        ]);

        $comment = new Comment;
        $comment->title = $request->title;
        $comment->text = $request->text;
        $comment->author_id = Auth::id();
        $comment->article_id = $request->article_id;
        
        $res = $comment->save();

        $article = Article::findOrFail($request->article_id);
        $users = User::where('id', '!=', auth()->id())->get();

        if($res) {
            Mail::to("azazin4ik123@gmail.com")
            ->send(new AdminComment(
                $article,
                $comment, 
            ));
            // $users->notify(new NotifyNewComment($article->name));
            Notification::send($users, new NotifyNewComment($article));
            // Clear comments cache.
            $this->clearCommentsCache($comment);
        }
        
        return redirect()->route('articles.show', [
            'article'=>$request->article_id,
            'res'=>$res
        ]);
    }

    public function edit($id) {
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);
        return view('comments.edit', ['comment'=>$comment]);
    }

    public function update($id, Request $request) {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'article_id' => 'required',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->title = $request->title;
        $comment->text = $request->text;
        // Fix const author_id
        $comment->author_id = Auth::id();
        $comment->article_id = $request->article_id;
        $res = $comment->save();

        $this->clearCommentsCache($comment);

        return redirect()->route('articles.show', [
            'article'=>$request->article_id
        ]);
    }

    public function delete($id) {
        $comment = Comment::findOrFail($id);
        Gate::authorize('comment', $comment);

        $article_id = $comment->article_id;
        $res = $comment->delete();

        if($res) {
            $this->clearCommentsCache($comment);
        }
        return redirect()->route('articles.show', [
            'article'=>$article_id,
        ]);
    }

    protected function clearCommentsCache($comment) {
        // Clear comments cache.
        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [
            ':key' => 'comments/'.$comment->article_id.'/*[0-9]'
        ])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }

        $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [
            ':key' => 'comments: *[0-9]'
        ])->get();
        foreach ($keys as $key) {
            Cache::forget($key->key);
        }
    }
}

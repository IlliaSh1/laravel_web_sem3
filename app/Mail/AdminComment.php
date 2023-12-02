<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Article;
use App\Models\Comment;

class AdminComment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $comment;
    protected $article;

    public function __construct(Article $article, Comment $comment)
    {
        //
        $this->article = $article;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('laravel@testingB.ru', "ExampleUser")
                    ->view('mail.comment', [
                        'article' => $this->article,
                        'comment' => $this->comment,
                    ]);
    }
}

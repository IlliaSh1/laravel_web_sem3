<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Access\Response;

use App\Models\User;
use App\Models\Comment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Article' => 'App\Policies\ArticleControllerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::before(function (User $user) {
            if ($user->role == 'moderator')
                return True;
        });

        Gate::define('adminComment', function (User $user, Comment $comment) {
            // User is author of comment
            if($user->role === 'moderator')
                return Response::allow();
            else
                return Response::deny('Отказано в доступе!');    
        });

        Gate::define('comment', function (User $user, Comment $comment) {
            // User is author of comment
            if($user->id == $comment->author_id)
                return Response::allow();
            else
                return Response::deny('Отказано в доступе!');    
        });
        //

    }
}

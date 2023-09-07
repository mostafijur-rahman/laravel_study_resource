<?php

// ==============================================================================================================================================================
// Querying Relations
// ==============================================================================================================================================================

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
 
class User extends Model
{
    /**
     * Get all of the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

// from controller
use App\Models\User;
 
$user = User::find(1);
 
$user->posts()->where('active', 1)->get();


// Chaining orWhere Clauses After Relationships ---------------------------
$user->posts()
        ->where('active', 1)
        ->orWhere('votes', '>=', 100)
        ->get();

// output query 
// select *
// from posts
// where user_id = ? and active = 1 or votes >= 100

// group where 
use Illuminate\Database\Eloquent\Builder;
 
$user->posts()
        ->where(function (Builder $query) {
            return $query->where('active', 1)
                         ->orWhere('votes', '>=', 100);
        })
        ->get();

// select *
// from posts
// where user_id = ? and (active = 1 or votes >= 100)


// ------------------------------------------------------
// Relationship Methods Vs. Dynamic Properties
// ------------------------------------------------------

use App\Models\User;
$user = User::find(1);

//  Dynamic Properties ($user->posts) perform lazy loading 
foreach ($user->posts as $post) {
    // ...
}

// Dynamic relationship properties perform "lazy loading", meaning they will only load their relationship data when you actually access them. 
// Because of this, developers often use eager loading to pre-load relationships they know will be accessed after loading the model. 
// Eager loading provides a significant reduction in SQL queries that must be executed to load a model's relations.


// Querying Relationship Existence
// -----------------------------------------------------

use App\Models\Post;
 
// Retrieve all posts that have at least one comment...
$posts = Post::has('comments')->get();

// Retrieve all posts that have three or more comments...
$posts = Post::has('comments', '>=', 3)->get();

// Retrieve posts that have at least one comment with images...
$posts = Post::has('comments.images')->get();


// advance query...
use Illuminate\Database\Eloquent\Builder;
 
// Retrieve posts with at least one comment containing words like code%...
$posts = Post::whereHas('comments', function (Builder $query) {
    $query->where('content', 'like', 'code%');
})->get();
 
// Retrieve posts with at least ten comments containing words like code%...
$posts = Post::whereHas('comments', function (Builder $query) {
    $query->where('content', 'like', 'code%');
}, '>=', 10)->get();


// Inline Relationship Existence Queries
// -----------------------------------------------------
// If you would like to query for a relationship's existence with a single, 
// simple where condition attached to the relationship query, you may find it more 
// convenient to use the whereRelation, orWhereRelation, whereMorphRelation, 
// and orWhereMorphRelation methods. For example, we may query for all posts that have unapproved comments:

use App\Models\Post;
 
$posts = Post::whereRelation('comments', 'is_approved', false)->get();

$posts = Post::whereRelation(
    'comments', 'created_at', '>=', now()->subHour()
)->get();


// Querying Relationship Absence
// -----------------------------------------------------
use App\Models\Post;
 
$posts = Post::doesntHave('comments')->get();

// advance 
use Illuminate\Database\Eloquent\Builder;
 
$posts = Post::whereDoesntHave('comments', function (Builder $query) {
    $query->where('content', 'like', 'code%');
})->get();

 
$posts = Post::whereDoesntHave('comments.author', function (Builder $query) {
    $query->where('banned', 0);
})->get();


// Querying Morph To Relationships
// -----------------------------------------------------

use App\Models\Comment;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
 
// Retrieve comments associated to posts or videos with a title like code%...
$comments = Comment::whereHasMorph(
    'commentable',
    [Post::class, Video::class],
    function (Builder $query) {
        $query->where('title', 'like', 'code%');
    }
)->get();
 
// Retrieve comments associated to posts with a title not like code%...
$comments = Comment::whereDoesntHaveMorph(
    'commentable',
    Post::class,
    function (Builder $query) {
        $query->where('title', 'like', 'code%');
    }
)->get();

// You may occasionally need to add query constraints based on the "type" of the related polymorphic model.
$comments = Comment::whereHasMorph(
    'commentable',
    [Post::class, Video::class],
    function (Builder $query, string $type) {
        $column = $type === Post::class ? 'content' : 'title';
 
        $query->where($column, 'like', 'code%');
    }
)->get();


// Querying All Related Models
// -----------------------------------------------------
use Illuminate\Database\Eloquent\Builder;
 
$comments = Comment::whereHasMorph('commentable', '*', function (Builder $query) {
    $query->where('title', 'like', 'foo%');
})->get();
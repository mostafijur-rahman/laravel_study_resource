<?php

// ==============================================================================================================================================================
// Aggregating Related Models
// ==============================================================================================================================================================

// -------------------------------------------------------
// Counting Related Models
// -------------------------------------------------------
use App\Models\Post;

$posts = Post::withCount('comments')->get();
 
foreach ($posts as $post) {
    echo $post->comments_count;
}

// another example
$posts = Post::withCount(['votes', 'comments' => function (Builder $query) {
    $query->where('content', 'like', 'code%');
}])->get();
 
echo $posts[0]->votes_count;
echo $posts[0]->comments_count;

// You may also alias the relationship count result, allowing multiple counts on the
$posts = Post::withCount([
    'comments',
    'comments as pending_comments_count' => function (Builder $query) {
        $query->where('approved', false);
    },
])->get();
 
echo $posts[0]->comments_count;
echo $posts[0]->pending_comments_count;


// Deferred Count Loading
// -------------------------------------------------------

// Using the loadCount method, you may load a relationship 
// count after the parent model has already been retrieved:

$post = Post::first();

if(true){
    // lazy eager loading
    $count = $post->loadCount('comments');

    // advance query // lazy eager constrainet loading
    $post->loadCount(['comments' => function (Builder $query) {
        $query->where('rating', 5);
    }]);
}

// Relationship Counting & Custom Select Statements
// -------------------------------------------------------
$posts = Post::select(['title', 'body'])
                ->withCount('comments')
                ->get();


// -------------------------------------------------------
// Other Aggregate Functions       
// -------------------------------------------------------

// In addition to the withCount method, Eloquent provides withMin, 
// withMax, withAvg, withSum, and withExists methods. 
// These methods will place a {relation}_{function}_{column} attribute on your resulting models:

$posts = Post::withSum('comments', 'votes')->get();
 
foreach ($posts as $post) {
    echo $post->comments_sum_votes;
}

$posts = Post::withSum('comments as total_comments', 'votes')->get();
 
foreach ($posts as $post) {
    echo $post->total_comments;
}

// another example
$post = Post::first();
$post->loadSum('comments', 'votes');

$posts = Post::select(['title', 'body'])
                ->withExists('comments')
                ->get();

// -------------------------------------------------------
// Counting Related Models On Morph To Relationships     
// -------------------------------------------------------

use Illuminate\Database\Eloquent\Relations\MorphTo;
 
$activities = ActivityFeed::with([
    'parentable' => function (MorphTo $morphTo) {
        $morphTo->morphWithCount([
            Photo::class => ['tags'],
            Post::class => ['comments'],
        ]);
    }])->get();


// Deferred Count Loading -----------------------
$activities = ActivityFeed::with('parentable')->get();
 
$activities->loadMorphCount('parentable', [
    Photo::class => ['tags'],
    Post::class => ['comments'],
]);
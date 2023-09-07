<?php

# 1
// ==============================================================================================================================================================
// Inserting & Updating Related Models
// ==============================================================================================================================================================

// The save Method ------------------------
use App\Models\Comment;
use App\Models\Post;
 
$comment = new Comment(['message' => 'A new comment.']);
$post = Post::find(1);
$post->comments()->save($comment);


// saveMany() ------------------------

$post = Post::find(1);
$post->comments()->saveMany([
    new Comment(['message' => 'A new comment.']),
    new Comment(['message' => 'Another new comment.']),
]);

// refresh() ------------------------

post->comments()->save($comment);
$post->refresh();
// All comments, including the newly saved comment...
$post->comments;


// Recursively Saving Models & Relationships ------------------------

$post = Post::find(1);
 
$post->comments[0]->message = 'Message';
$post->comments[0]->author->name = 'Author Name';
 
$post->push();

// pushQuietly() Recursively Saving Models & Relationships ------------------------

$post->pushQuietly();

// The create Method ------------------------

use App\Models\Post;
 
$post = Post::find(1);
 
$comment = $post->comments()->create([
    'message' => 'A new comment.',
]);

// The createMany Method ------------------------

$post = Post::find(1);
 
$post->comments()->createMany([
    ['message' => 'A new comment.'],
    ['message' => 'Another new comment.'],
]);

// createQuietly / createManyQuietly ------------------------

$user = User::find(1);
 
$user->posts()->createQuietly([
    'title' => 'Post title.',
]);
 
$user->posts()->createManyQuietly([
    ['title' => 'First post.'],
    ['title' => 'Second post.'],
]);

// You may also use the findOrNew, firstOrNew, firstOrCreate, and updateOrCreate methods to create and update models on relationships.


# 1
// ==============================================================================================================================================================
// Belongs To Relationships
// ==============================================================================================================================================================

use App\Models\Account;
 
$account = Account::find(10);
 
$user->account()->associate($account);

$user->save();

$user->account()->dissociate();
 
$user->save();


# 1
// ==============================================================================================================================================================
// Many To Many Relationships
// Attaching / Detaching
// ==============================================================================================================================================================

use App\Models\User;
 
$user = User::find(1);
 
$user->roles()->attach($roleId);

$user->roles()->attach($roleId, ['expires' => $expires]);

// Detach a single role from the user...
$user->roles()->detach($roleId);
 
// Detach all roles from the user...
$user->roles()->detach();

$user = User::find(1);
 
$user->roles()->detach([1, 2, 3]);
 
$user->roles()->attach([
    1 => ['expires' => $expires],
    2 => ['expires' => $expires],
]);

$user->roles()->sync([1, 2, 3]);

$user->roles()->sync([1 => ['expires' => true], 2, 3]);

$user->roles()->syncWithPivotValues([1, 2, 3], ['active' => true]);

$user->roles()->syncWithoutDetaching([1, 2, 3]);

$user->roles()->toggle([1, 2, 3]);

$user->roles()->toggle([
    1 => ['expires' => true],
    2 => ['expires' => true],
]);

$user = User::find(1);
 
$user->roles()->updateExistingPivot($roleId, [
    'active' => false,
]);



# 2
// ==============================================================================================================================================================
// Touching Parent Timestamps
// ==============================================================================================================================================================

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class Comment extends Model
{
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['post'];
 
    /**
     * Get the post that the comment belongs to.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
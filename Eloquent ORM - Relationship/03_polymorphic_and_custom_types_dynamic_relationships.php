<?php

// ==============================================================================================================================================================
// Polymorphic Relationships
// ==============================================================================================================================================================
// A polymorphic relationship allows the child model to belong to more than one type of model using a single association.
// For example, imagine you are building an application that allows users to share blog posts and videos. 
// In such an application, a Comment model might belong to both the Post and Video models.

// Polymorphic topics
// -----------------------------
// 1. One To One (Polymorphic)
// 2. One To Many (Polymorphic)
// 3. One Of Many (Polymorphic)
// 4. Many To Many (Polymorphic)


# 1
// ==============================================================================================================================================================
// One To One (Polymorphic = bohurupi)
// ==============================================================================================================================================================
// A one-to-one polymorphic relation is similar to a typical one-to-one relation; however, the child model can belong to more than one type of model using a single association. 
// For example, a blog Post and a User may share a polymorphic relation to an Image model. Using a one-to-one polymorphic relation allows you to have a single 
// table of unique images that may be associated with posts and users. First, let's examine the table structure:

// Table structure
// ----------------
posts
    id - integer
    name - string
 
users
    id - integer
    name - string
 
images
    id - integer
    url - string
    imageable_id - integer (table_id)
    imageable_type - string (table_name)

// user model structure 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
 
class User extends Model
{
    /**
     * Get the user's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

// query from controller
User::find(1)->image

// post model structure    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
 
class Post extends Model
{
    /**
     * Get the post's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

// query from controller
Post::find(1)->image

// same as it is
$post = Post::find(1);
$image = $post->image;


// images model structure    
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
 
class Image extends Model
{
    /**
     * Get the parent imageable model (user or post).
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'imageable_type', 'imageable_id');
    }
}


# 2
// ==============================================================================================================================================================
// One To Many (Polymorphic = bohurupi)
// ==============================================================================================================================================================
// A one-to-many polymorphic relation is similar to a typical one-to-many relation; however, the child model can belong to more than one type of model using a single association. 
// For example, imagine users of your application can "comment" on posts and videos. Using polymorphic relationships, you may use a single comments table to contain comments for 
// both posts and videos. First, let's examine the table structure required to build this relationship:

// Table structure
// ----------------

posts
    id - integer
    title - string
    body - text
 
videos
    id - integer
    title - string
    url - string
 
comments
    id - integer
    body - text
    commentable_id - integer
    commentable_type - string


// Model Structure
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
 
class Comment extends Model
{
    /**
     * Get the parent commentable model (post or video).
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
 
class Post extends Model
{
    /**
     * Get all of the post's comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
 
class Video extends Model
{
    /**
     * Get all of the video's comments.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}


// Retrieving The Relationship
use App\Models\Post;

$post = Post::find(1);
// lazy loading ...
foreach ($post->comments as $comment) {
    // ...
}

// another
use App\Models\Comment;

$comment = Comment::find(1);
$commentable = $comment->commentable;



# 3
// ==============================================================================================================================================================
// One of Many (Polymorphic = bohurupi)
// ==============================================================================================================================================================

public function latestImage(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable')->latestOfMany();
}


public function oldestImage(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable')->oldestOfMany();
}


public function bestImage(): MorphOne
{
    return $this->morphOne(Image::class, 'imageable')->ofMany('likes', 'max');
}


# 4
// ==============================================================================================================================================================
// Many To Many (Polymorphic = bohurupi)
// ==============================================================================================================================================================
// Many-to-many polymorphic relations are slightly more complicated than "morph one" and "morph many" relationships. For example, 
// a Post model and Video model could share a polymorphic relation to a Tag model. Using a many-to-many polymorphic relation in this 
// situation would allow your application to have a single table of unique tags that may be associated with posts or videos. 
// First, let's examine the table structure required to build this relationship:


// Table structure
// ----------------
posts (books)
    id - integer
    name - string
 
videos (products)
    id - integer
    name - string
 
tags (orders)
    id - integer
    name - string
 
taggables (orderables)
    tag_id - integer
    taggable_id - integer
    taggable_type - string


// model structure 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
 
class Post extends Model
{
    /**
     * Get all of the tags for the post.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}


// invers of the relation ship
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
 
class Tag extends Model
{
    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
 
    /**
     * Get all of the videos that are assigned this tag.
     */
    public function videos(): MorphToMany
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }
}


// from contrller
use App\Models\Post;
 
$post = Post::find(1);
 
foreach ($post->tags as $tag) {
    // ...
}

// another 
use App\Models\Tag;
 
$tag = Tag::find(1);
 
foreach ($tag->posts as $post) {
    // ...
}
 
foreach ($tag->videos as $video) {
    // ...
}


// Custom Polymorphic Types
// ----------------------------------------
// You may call the enforceMorphMap method in the boot method of your 
// App\Providers\AppServiceProvider class or create a separate service provider if you wish.

use Illuminate\Database\Eloquent\Relations\Relation;
 
Relation::enforceMorphMap([
    'post' => 'App\Models\Post',
    'video' => 'App\Models\Video',
]);


// You may determine the morph alias of a given model at runtime using the model's getMorphClass method. 
// Conversely, you may determine the fully-qualified class name associated with a 
// morph alias using the Relation::getMorphedModel method:

use Illuminate\Database\Eloquent\Relations\Relation;
 
$alias = $post->getMorphClass();
$class = Relation::getMorphedModel($alias);

// Dynamic Relationships
// ----------------------------------------

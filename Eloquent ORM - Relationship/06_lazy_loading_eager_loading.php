<?php

# 1
// ==============================================================================================================================================================
// Eager Loading
// ==============================================================================================================================================================
// When accessing Eloquent relationships as properties, the related models are "lazy loaded".
//  This means the relationship data is not actually loaded until you first access the property.


//  However, Eloquent can "eager load" relationships at the time you query the parent model. 
//  Eager loading alleviates the "N + 1" query problem. To illustrate the N + 1 query problem, consider a Book model that "belongs to" to an Author model:



// parent table is 'authors'
// --------------------------------

// child table model
// -----------------------------
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class Book extends Model
{
    /**
     * Get the author that wrote the book.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

}


// query from controller
// -----------------------------
use App\Models\Book;
 
$books = Book::all(); // supose we have 25 books in 'books' table from database
 
foreach ($books as $book) {
    echo $book->author->name;
}

// This loop will execute one query to retrieve all of the books within the database table
// then another query for each book in order to retrieve the book's author. 
// So, if we have 25 books, the code above would run 26 queries: 
// one for the original book, 
// and 25 additional queries to retrieve the author of each book.



// we can use eager loading to reduce this operation to just two queries. 
// When building a query, you may specify which relationships should be eager loaded using the 'with' method:

    $books = Book::with('author')->get();
 
    foreach ($books as $book) {
        echo $book->author->name;
    }

// For this operation, only two queries will be executed - one query to retrieve all of the books
//  and one query to retrieve all of the authors for all of the books:

// query generation
// select * from books
// select * from authors where id in (1, 2, 3, 4, 5, ...)


// Eager Loading Multiple Relationships
// -------------------------------------------------------
$books = Book::with(['author', 'publisher'])->get();

// Nested Eager Loading
// -------------------------------------------------------
$books = Book::with('author.contact')->get();


// multiple Eager Loading
// -------------------------------------------------------
$books = Book::with([
    'author' => [
        'contact',
        'address',
    ],
])->get();


// Eager Loading Specific Columns
// -------------------------------------------------------
$books = Book::with('author:id,name,book_id')->get();


// Nested Eager Loading morphTo Relationships
// -------------------------------------------------------

// one to many (plimorphic) for example 
posts
    id - integer
    name - string
 
users
    id - integer
    name - string

images
    id - integer
    url - string
    imageable_id - integer
    imageable_type - string


// --------------------------------
parent tables = calendars (parent of 'events' table), tags (parent of 'photos' table), Authors (parent of 'posts' table)

inependent tables = events, photos, posts // compare to posts and users

pivot table = activity_feeds(parentable_id, parentable_type) // compare to images



// In this example, let's assume Event, Photo, and Post models may create ActivityFeed models. 
// Additionally, let's assume that Event models belong to a Calendar model, Photo models are associated with Tag models, 
// and Post models belong to an Author model.

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
 
class ActivityFeed extends Model
{
    /**
     * Get the parent of the activity feed record.
     */
    public function parentable(): MorphTo
    {
        return $this->morphTo();
    }
}

// Using these model definitions and relationships, we may retrieve ActivityFeed model instances 
// and eager load all parentable models and their respective nested relationships:

// from controller
use Illuminate\Database\Eloquent\Relations\MorphTo;
 
$activities = ActivityFeed::query()
    ->with(['parentable' => function (MorphTo $morphTo) {
        $morphTo->morphWith([
            Event::class => ['calendar'],
            Photo::class => ['tags'],
            Post::class => ['author'],
        ]);
    }])->get();

// Eager Loading By Default
// -------------------------------------------------------
// Sometimes you might want to always load some relationships when retrieving a model. 
// To accomplish this, you may define a $with property on the model:

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 
class Book extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['author'];
 
    /**
     * Get the author that wrote the book.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
 
    /**
     * Get the genre of the book.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}

// some another operation
$books = Book::without('author')->get();
$books = Book::withOnly('genre')->get();



// Constraining Eager Loads (we can add Constraining with it)
// -------------------------------------------------------
// from controller
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
 
$users = User::with(['posts' => function (Builder $query) {
    $query->where('title', 'like', '%code%');
}])->get();

// annother
$users = User::with(['posts' => function (Builder $query) {
    $query->orderBy('created_at', 'desc');
}])->get();



// Constraining Eager Loading Of morphTo Relationships
// -------------------------------------------------------

use Illuminate\Database\Eloquent\Relations\MorphTo;
 
$comments = Comment::with(['commentable' => function (MorphTo $morphTo) {
    $morphTo->constrain([
        Post::class => function ($query) {
            $query->whereNull('hidden_at');
        },
        Video::class => function ($query) {
            $query->where('type', 'educational');
        },
    ]);
}])->get();


// Constraining Eager Loads With Relationship Existence
// -------------------------------------------------------

use App\Models\User;
 
$users = User::withWhereHas('posts', function ($query) {
    $query->where('featured', true);
})->get();


// Lazy Eager Loading
// -------------------------------------------------------
use App\Models\Book;
 
$books = Book::all();
 
if ($someCondition) {
    $books->load('author', 'publisher');
}

$author->load(['books' => function (Builder $query) {
    $query->orderBy('published_date', 'asc');
}]);


// Nested Lazy Eager Loading & morphTo
// -------------------------------------------------------

// Using these model definitions and relationships, 
// we may retrieve ActivityFeed model instances and eager load 
// all parentable models and their respective nested relationships:

$activities = ActivityFeed::with('parentable')
    ->get()
    ->loadMorph('parentable', [
        Event::class => ['calendar'],
        Photo::class => ['tags'],
        Post::class => ['author'],
    ]);
// first a get kore then load respective nested relationships ------------


// Using these model definitions and relationships, 
// we may retrieve ActivityFeed model instances and eager load 
// all parentable models and their respective nested relationships:
// $activities = ActivityFeed::query()
//     ->with(['parentable' => function (MorphTo $morphTo) {
//         $morphTo->morphWith([
//             Event::class => ['calendar'],
//             Photo::class => ['tags'],
//             Post::class => ['author'],
//         ]);
//     }])->get();
// ekbare ane maybe ------------
    

// ==============================================================================================================================================================
// Preventing Lazy Loading
// ==============================================================================================================================================================

use Illuminate\Database\Eloquent\Model;
 
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    Model::preventLazyLoading(! $this->app->isProduction());
}

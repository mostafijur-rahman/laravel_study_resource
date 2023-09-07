<?php

# 6
// ==============================================================================================================================================================
// Many To Many
// ==============================================================================================================================================================

// defination
// --------------
// Many-to-many relations are slightly more complicated than hasOne and hasMany relationships.

// situation
// --------------
// let's assume we are building a deployment platform like Laravel Vapor. A Project model might access many Deployment models through an 
// intermediate Environment model. Using this example, you could easily gather all deployments for a given project. Let's look at the 
// tables required to define this relationship:

// table structure
// ----------------
// users (parent)
//     id - integer
//     name - string
 
// roles (child)
//     id - integer
//     name - string

// role (child_table_name) _ user (parent_table_name) 
// role_user
//     user_id - integer (parent_column)
//     role_id - integer (child_column)


class User extends Model
{
    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        // varient one
        return $this->belongsToMany(Role::class);

        // varient two
        return $this->belongsToMany(Role::class, 'role_user');

        // varient three
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    // in controller
    $user = User::find(1);
    foreach ($user->roles as $role) {
        // ...
    }

}

// Inverse of the many to many relationship
// ===================================================================
class Role extends Model
{
    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}


// Retrieving Intermediate Table Columns
// ===================================================================

// from controller
use App\Models\User;
 
$user = User::find(1);
 
foreach ($user->roles as $role) {
    echo $role->pivot->created_at;
}


// from model
class User extends Model
{
    /**
     * The roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {

        // get Timestamps in pivot table
        return $this->belongsToMany(Role::class)->withPivot('active', 'created_by');

        // get Timestamps in pivot table
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}


// consider from users model
// Customizing The pivot Attribute Name
// table structure
// ----------------
users
    id - integer
    name - string
 
podcasts
    id - integer
    name - string
 
subscriptions // intermediet/pivot table
    id - integer
    user_id - integer
    podcast_id - integer

return $this->belongsToMany(Podcast::class)
            ->as('subscription')
            ->withTimestamps();

// Filtering Queries Via Intermediate Table Columns
return $this->belongsToMany(Role::class)
            ->wherePivot('approved', 1);

return $this->belongsToMany(Role::class)
            ->wherePivotIn('priority', [1, 2]);

return $this->belongsToMany(Role::class)
            ->wherePivotNotIn('priority', [1, 2]);

return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotBetween('created_at', ['2020-01-01 00:00:00', '2020-12-31 00:00:00']);

return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotNotBetween('created_at', ['2020-01-01 00:00:00', '2020-12-31 00:00:00']);

return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotNull('expired_at');

return $this->belongsToMany(Podcast::class)
            ->as('subscriptions')
            ->wherePivotNotNull('expired_at');     

// Ordering Queries Via Intermediate Table Columns
return $this->belongsToMany(Badge::class)
                ->where('rank', 'gold')
                ->orderByPivot('created_at', 'desc');


// Defining Custom Intermediate Table Models
class Role extends Model
{
    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                        ->using(RoleUser::class);
    }
}

// When defining the RoleUser model, 
// you should extend the Illuminate\Database\Eloquent\Relations\Pivot class:
namespace App\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class RoleUser extends Pivot
{
    // ...
}


// Retrieving Intermediate Table Columns
// ---------------------------------------------------------------
use App\Models\User;
 
$user = User::find(1);
 
foreach ($user->roles as $role) {
    echo $role->pivot->created_at;
}

// Customizing The pivot Attribute Name
// ---------------------------------------------------------------
return $this->belongsToMany(Podcast::class)
                ->as('subscription')
                ->withTimestamps();

$users = User::with('podcasts')->get();
 
foreach ($users->flatMap->podcasts as $podcast) {
    echo $podcast->subscription->created_at;
}

// Filtering Queries Via Intermediate Table Columns
// ---------------------------------------------------------------
return $this->belongsToMany(Role::class)
                ->wherePivot('approved', 1);
 
return $this->belongsToMany(Role::class)
                ->wherePivotIn('priority', [1, 2]);
 
return $this->belongsToMany(Role::class)
                ->wherePivotNotIn('priority', [1, 2]);
 
return $this->belongsToMany(Podcast::class)
                ->as('subscriptions')
                ->wherePivotBetween('created_at', ['2020-01-01 00:00:00', '2020-12-31 00:00:00']);
 
return $this->belongsToMany(Podcast::class)
                ->as('subscriptions')
                ->wherePivotNotBetween('created_at', ['2020-01-01 00:00:00', '2020-12-31 00:00:00']);
 
return $this->belongsToMany(Podcast::class)
                ->as('subscriptions')
                ->wherePivotNull('expired_at');
 
return $this->belongsToMany(Podcast::class)
                ->as('subscriptions')
                ->wherePivotNotNull('expired_at');


// Ordering Queries Via Intermediate Table Columns
// ---------------------------------------------------------------
return $this->belongsToMany(Badge::class)
                ->where('rank', 'gold')
                ->orderByPivot('created_at', 'desc');


// Defining Custom Intermediate Table Models
// ---------------------------------------------------------------          
class Role extends Model
{
    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }
}

// When defining the RoleUser model, you should extend the
// ---------------------------------------------------------------   
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class RoleUser extends Pivot
{
    // ...
}

// Custom Pivot Models And Incrementing IDs
// ---------------------------------------------------------------   
public $incrementing = true;
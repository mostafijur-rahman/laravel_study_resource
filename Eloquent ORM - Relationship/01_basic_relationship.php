<?php

// index
// ------

// OneToOne Variation
// =======================
// 1. One To One
// 2. One To Many
// 3. Has One Of Many
// 4. Has One Through
// 5. Has Many Through

// OneToMany Variation
// =======================
// 6. Many To Many (pivot)


// theurotical part


// use Illuminate\Database\Eloquent\Model { hasOne(), belongsTo()}

# 1
// ==============================================================================================================================================================
// One to One and Invers Relationship 
// ==============================================================================================================================================================
// a User model might be associated with one Phone model.
// hasOne (Main table, Left join)
// from user model/table
// parent to child
return $this->hasOne(Phone::class, 'foreign_key_in_phone_table', 'local_key_or_primary_key_in_user_table');

// call from controller
$phone = User::find(1)->phone; // (here is phone we will work like Eloquent's dynamic properties.)

// belongsTo (Child Table, Right join)
// from phone model/table
//  Child to parent
return $this->belongsTo(User::class, 'foreign_key_in_phone_table', 'owner_key_or_primary_key_in_phone_table');


// OneToOne Table structure
// ----------------
// users (parent table)
//     id - integer
//     name - string

// phones (child table)
//     id - integer
//     user_id - integer
//     phone - string



// OneToMany Table structure
// --------------------------
// users (parent table)
//     id - integer
//     name - string

// phones (child table)
//     id - integer
//     phone - string

// phone_user
//     user_id - 
//     phone_id -


# 2
// ==============================================================================================================================================================
// One to Many and Invers
// ==============================================================================================================================================================
// A one-to-many relationship is used to define relationships where a single model is the parent to one or more child models
// hasMany (Main table, Left join)
// from user model/table
return $this->hasMany(phone::class, 'foreign_key_in_phone_table', 'local_key_or_primary_key_in_user_table');

// belongsTo (Child Table, Right join)
// same as belongs

# 3
// ==============================================================================================================================================================
// Has One Of Many
// ==============================================================================================================================================================
// Sometimes a model may have many related models, yet you want to easily retrieve the "latest" or "oldest" related model of the relationship.

return $this->hasOne(Phone::class, 'foreign_key_in_phone_table', 'local_key_or_primary_key_in_user_table')->latestOfMany();
return $this->hasOne(Phone::class)->oldestOfMany();
return $this->hasOne(Order::class)->ofMany('price', 'max');

// Advanced Has One Of Many Relationships
// ---------------------------------------

// problem
// ------------ 
// It is possible to construct more advanced "has one of many" relationships. For example, a Product model may have many associated Price models
// that are retained in the system even after new pricing is published. In addition, new pricing data for the product may be able to be published 
// in advance to take effect at a future date via a published_at column.

// soultion
// ------------ 
// So, in summary, we need to retrieve the latest published pricing where the published date is not in the future. In addition, if two prices have the 
// same published date, we will prefer the price with the greatest ID. To accomplish this, we must pass an array to the ofMany method that contains the 
// sortable columns which determine the latest price. In addition, a closure will be provided as the second argument to the ofMany method. This closure 
// will be responsible for adding additional publish date constraints to the relationship query:


// table structure
// ----------------
products
    id - integer
    name - string
 
prices
    id - integer
    product_id - integer
    published_at - dateTime
    value - integer


// code
// ------------ 
class Product extends Model
{
    /**
     * Get the current price of a product
     */
    public function currentPricing($date)
    {
        return $this->hasOne(Price::class)->ofMany(
            function ($query) use($date) {
                $query->where('published_at', '<', $date['date']);
                $query->where('id', '<', $date['id']);
            });
    }

    public function AnotherCurrentPricing(): HasOne
    {
        return $this->hasOne(Price::class)->ofMany([
            'published_at' => 'max',
            'id' => 'max',
            ], function (Builder $query) {
            $query->where('published_at', '<', now());
        });
    }
}
Product::find(1)->currentPricing('date');

# 4
// ==============================================================================================================================================================
// Has One Through
// ==============================================================================================================================================================

// defination
// --------------
// The "has-one-through" relationship defines a one-to-one relationship with another model. However, this relationship indicates 
// that the declaring model can be matched with one instance of another model by proceeding through a third model.

// situation
// --------------
// For example, in a vehicle repair shop application, each Mechanic model may be associated with one Car model, and each Car model may be 
// associated with one Owner model. While the mechanic and the owner have no direct relationship within the database, the mechanic 
// can access the owner through the Car model. Let's look at the tables necessary to define this relationship

// table structure
// ----------------
mechanics
    id - integer
    name - string
 
cars
    id - integer
    model - string
    mechanic_id - integer
 
owners
    id - integer
    name - string
    car_id - integer

expenses
    id - integer
    car_id - integer
    expense_id - primary_key_of_setting_expense_table
    amount - decimal


// code
// ------------ 
class Mechanic extends Model
{
    /**
     * Get the car's owner.
     */
    public function carOwner()
    {
        return $this->hasOneThrough(
            Owner::class,
            Car::class,
            'mechanic_id', // Foreign key on the cars table...
            'car_id', // Foreign key on the owners table...
            'id', // Local key on the mechanics table...
            'id' // Local key on the cars table...
        );
    }
}

# 5
// ==============================================================================================================================================================
// Has Many Through
// ==============================================================================================================================================================

// defination
// --------------
// The "has-many-through" relationship provides a convenient way to access distant relations via an intermediate relation. For example,

// situation
// --------------
// let's assume we are building a deployment platform like Laravel Vapor. A Project model might access many Deployment models through an 
// intermediate Environment model. Using this example, you could easily gather all deployments for a given project. Let's look at the 
// tables required to define this relationship:

// table structure
// ----------------
projects // child table
    id - integer
    name - string
 
environments // parent table
    id - integer
    project_id - integer
    name - string
 
deployments // grand table
    id - integer
    environment_id - integer
    commit_hash - string

// code
// ------------ 
class Project extends Model
{
    public function deployments()
    {
        return $this->hasManyThrough(
            Deployment::class,
            Environment::class,
            'project_id', // Foreign key on the environments table...
            'environment_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    // just check user has phone number or not
    public function isUserHasPhone(){
        return $this->has('phone');
    }
 
    // String based syntax...
    return $this->through('environments')->has('deployments');
 
    // Dynamic syntax...
    return $this->throughEnvironments()->hasDeployments();
    
}
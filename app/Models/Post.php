<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes; // Soft deletes is a global scope that is add query constraints that apply to every query made on a specific model.

    protected $fillable = ['title', 'post', 'image', 'user_id', 'category_id'];

    public static function booted()
    {
        static::addGlobalScope(new ActiveScope); // using addGlobalScope in booted we call the scope in a model

        /*
            for simple filters we can give them in a anonymous closure with create scope
            static::addGlobalScope('isActive', function($builder){
                $builder->where('status', true); isActive is scope to be used in Queries
            });
        */
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /*
    Pending Attributes let a scope have both conditions and be a default to a new added models
    use withAttributes()
    */
    #[Scope]
    protected function draft($query)
    {
        return $query->withAttributes(['status' => 'Draft'])
            ->where('status', 'Draft'); // work both
        // If you only wanted attributes to be applied without where conditions then we can use like this

        // return $query->withAttributes(['status'=> 'Draft'], asConditions: false);

        /*
        You can call this in both create method and use in queries
        Post::draft()->get(); Filters drafts only
        Post::draft()->create([$data]); Automactically sets status = 'Draft'
        */
    }
}

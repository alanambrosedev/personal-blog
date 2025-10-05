<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ScopedBy([ActiveScope::class])] // Using ScopeBy we can call a scope to a model
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeWithEmail($query)
    {
        return $query->addSelect('email');
        // here using select replaces  all selected column in our query so if use addSelect it chains to the existing column
        /*

        In controller we can call like this
        $users = User::select('name')->withEmail()->get()'

        */
    }

    // local scope
    #[Scope] // to make a local scope add a protected method with #[Scope]
    protected function active($query)
    {
        return $query->where('status', true);

        // you can call this by User::active()->get();
        // chain multiple scopes by User::active()->verified()->get();
    }
}

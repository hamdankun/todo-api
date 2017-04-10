<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relation with todos
     * @return \Illuminate\Database\Relations\HasMany
     */
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    /**
     * Find user by api toke 
     * @param  \Illuminate\Database\Quary\Builder $query    
     * @param  string $apiToken 
     * @return  \Illuminate\Database\Quary\Builder          
     */
    public function findByApiToken($apiToken)
    {
        return $this->where('api_token', $apiToken)->first();
    }

    public function attempt($credentails)
    {
        $user = $this->where('email', $credentails['email'])->first();
        
        if ($user && app('hash')->check($credentails['password'], $user->password)) {
            $user->api_token = encrypt(str_random(16));
           $user->save();
           return $user;
        }

        return false;
    }
}

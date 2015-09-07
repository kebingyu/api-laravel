<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $connection = 'mysql';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'is_active', 'is_admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    static public function createUser(array $data)
    {
        return static::create([
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
        ]);
    }

    static public function updateUser(array $data, $key)
    {
        if ($user = static::findUserByPrimaryKey($key))
        {
            $data = array_filter($data);
            if (isset($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);
            return $user;
        }
        return false;
    }

    static public function deleteUser($key)
    {
        if ($user = static::findUserByPrimaryKey($key))
        {
            return $user->delete();
        }
        return false;
    }

    /**
     * Validate user credential.
     * 
     * @param array $data 
     * @static
     * @return bool | int
     */
    static public function validate(array $data)
    {
        if ($user = static::findUserByPrimaryKey($data['username']))
        {
            if (Hash::check($data['password'], $user->password))
            {
                return $user;
            }
        }
        return false;
    }

    static protected function findUserByPrimaryKey($key)
    {
        if (is_numeric($key))
        {
            $user = static::find($key);
        }
        else if (static::isValidEmail($key))
        {
            $user = static::where('email', $key)->first();
        }
        else
        {
            $user = static::where('username', $key)->first();
        }
        return $user;
    }

    static protected function isValidEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Build relationship with "blog" table
     * 
     * @return Collections
     */
    public function blogs()
    {
        return $this->hasMany('App\Models\Blog');
    }

    /**
     * Build relationship with "tag" table
     * 
     * @return Collections
     */
    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $connection = 'mysql';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'access_token';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'token'];

    protected $primaryKey = 'user_id';

    static protected $ttl = 60; // token TTL in second

    static public function createToken($userId)
    {
        $time = time();
        if ($row = static::find($userId))
        {
            if (static::isExpired($row, $time))
            {
                $row->update(['token' => md5($time)]);
            }
        }
        else
        {
            $row = static::create([
                'user_id' => $userId,
                'token'   => md5($time),
            ]);
        }
        return $row->token;
    }

    static public function expired(array $data)
    {
    }

    static public function logout(array $data)
    {
        if (
            ($row = static::find($data['user_id']))
            && ($row->token == $data['token'])
        )
        {
            return $row->delete();
        }
        return false;
    }

    static protected function isExpired($row, $currTime)
    {
        return $row->updated_at->timestamp + self::$ttl < $currTime;
    }
}

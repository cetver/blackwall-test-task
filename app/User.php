<?php declare(strict_types=1);

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 *
 * @see \App\Observers\UserObserver
 */
class User extends Authenticatable
{
    /**
     * @inheritDoc
     */
    protected $table = 'users';
    /**
     * @inheritDoc
     */
    protected $keyType = 'string';
    /**
     * @inheritDoc
     */
    public $incrementing = false;
    /**
     * @inheritDoc
     */
    protected array $fillable = ['id', 'username', 'password'];
    /**
     * @inheritDoc
     */
    protected $hidden = ['password'];
    /**
     * @inheritDoc
     */
    protected array $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}

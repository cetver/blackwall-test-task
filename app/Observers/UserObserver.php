<?php

namespace App\Observers;

use App\Generators\Uuid4GeneratorInterface;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;

class UserObserver
{
    /**
     * @var Uuid4GeneratorInterface
     */
    private Uuid4GeneratorInterface $uuid4Generator;
    /**
     * @var Hasher
     */
    private Hasher $hasher;

    /**
     * UserObserver constructor.
     *
     * @param Uuid4GeneratorInterface $uuid4Generator
     * @param Hasher $hasher
     */
    public function __construct(Uuid4GeneratorInterface $uuid4Generator, Hasher $hasher)
    {
        $this->uuid4Generator = $uuid4Generator;
        $this->hasher = $hasher;
    }

    /**
     * Handle the User "creating" event.
     *
     * @param User $model
     */
    public function creating(User $model)
    {
        $model->id = $this->uuid4Generator->generate();
        $model->password = $this->hasher->make($model->password);
    }
}

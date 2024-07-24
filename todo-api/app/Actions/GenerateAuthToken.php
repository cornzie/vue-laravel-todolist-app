<?php

namespace App\Actions;

use App\Models\User;
use RuntimeException;

class GenerateAuthToken extends Action
{
    public function __construct(public ?User $user)
    {
        if (is_null($user)) {
            throw new RuntimeException('A user model is required', 1);
        }

        parent::__construct($this->user);
    }

    public function execute(): string
    {
        $token = $this->user->createToken($this->user->name);

        return $token->plainTextToken;
    }
}

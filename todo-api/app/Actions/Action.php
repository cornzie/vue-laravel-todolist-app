<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Abstract class representing an action.
 */
abstract class Action
{
    /**
     * @var User|null The user associated with the action.
     */
    protected ?User $user;

    /**
     * Constructor to initialize the action with a user.
     */
    public function __construct(?User $user = null)
    {
        $this->user = $user ?? Auth::user();
    }

    /**
     * Execute the action.
     *
     * This method must be implemented by subclasses.
     */
    abstract public function execute(): mixed;
}

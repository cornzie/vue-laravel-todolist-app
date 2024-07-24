<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateNewUser extends Action
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
        parent::__construct();
    }

    public function execute(): User
    {
        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }
}

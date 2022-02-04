<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;


class PasswordService {

    public function make(string $password): string
    {
        return Hash::make($password);
    }

    public function verify(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}

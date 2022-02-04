<?php
namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserService {

    /**
     * @var PasswordService
     */
    protected $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function create(array $data): User
    {
        $data['id'] = $this->generateId();
        $data['password'] = $this->makePassword($data['password']);

        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()
        ->where('email', $email)
        ->first();
    }

    public function verifyPassword(User $user, string $password)
    {
        return $this->passwordService->verify($password, $user->password);
    }

    public function generateToken(User $user): string
    {
        $token = hash('sha256', Str::random(60));
        $user->api_token = $token;
        $user->save();

        return $token;
    }

    private function generateId(): string
    {
        return Str::orderedUuid();
    }

    private function makePassword(string $password): string
    {
        return $this->passwordService->make($password);
    }
}

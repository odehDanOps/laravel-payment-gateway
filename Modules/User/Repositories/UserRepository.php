<?php
namespace Modules\User\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserRepository
{
    /**
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId): User
    {
        return User::find($userId);
    }

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
    
}

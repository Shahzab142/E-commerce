<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class UserRegistrationService
{
    /**
     * Register a new user.
     */
    public function register(
        array $userData,
        array $detailsData = [],
        string $role = User::ROLE_USER,
        ?string $relationship = null
    ): User {

        return DB::transaction(function () use (
            $userData,
            $detailsData,
            $role,
            $relationship
        ) {

            /*
            |--------------------------------------------------------------------------
            | Validate Role
            |--------------------------------------------------------------------------
            */

            if (! in_array($role, [

                User::ROLE_ADMIN,
                User::ROLE_EMPLOYEE,
                User::ROLE_VENDOR,
                User::ROLE_USER,

            ])) {

                throw new InvalidArgumentException('Invalid user role.');

            }

            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            */

            $userData['password'] = Hash::make(
                $userData['password']
            );

            /*
            |--------------------------------------------------------------------------
            | Role
            |--------------------------------------------------------------------------
            */

            $userData['role'] = $role;

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $userData['status'] = $role === User::ROLE_ADMIN
                ? User::STATUS_ACTIVE
                : User::STATUS_PENDING;

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create($userData);

            /*
            |--------------------------------------------------------------------------
            | Create Related Details
            |--------------------------------------------------------------------------
            */

            if (

                $relationship &&

                ! empty($detailsData) &&

                method_exists($user, $relationship)

            ) {

                $user->{$relationship}()
                    ->create($detailsData);

            }

            return $user;

        });
    }
}

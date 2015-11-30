<?php namespace A3LWebInterface\Services;

use A3LWebInterface\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use A3LWebInterface\Role;

class Registrar implements RegistrarContract {

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, User::$rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'player_id' => $data['player_id'],
            'password' => bcrypt($data['password']),
        ]);
        $member = Role::where('name', 'member')->first();
        $user->attachRole($member);
        \Event::fire(new \A3LWebInterface\Events\UserCreated($user, 'new User registered'));
        return $user;
    }

}

<?php

namespace App\Repositories;

use App\Models\User;

class UserRepositories
 {


    public function create($name, $last_name, $email, $password, $personas_id, $roles_id)
    {
        $user['name'] = $name . ' ' . $last_name;
        $user['email'] = $email;
        $user['password'] = $password;
        $user['personas_id'] = $personas_id;
         $user['roles_id'] = $roles_id;

        return User::create($user);
    }
    public function update($id, $name, $last_name)
    {
        $user = $this->find($id);
        $user->name = $name . ' ' . $last_name;
        $user->save();
        return $user;
    }

    public function find($id)
    {
        return User::where('id', '=', $id)->first();
    }
}
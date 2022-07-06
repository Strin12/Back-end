<?php

namespace App\Repositories;

use App\Models\personas;
use App\Models\User;

class PersonasRepositories
{

    public function create($name, $last_name, $avatar)
    {
        $person['name'] = $name;
        $person['last_name'] = $last_name;
        $person['avatar'] = $avatar;

        return personas::create($person);
    }

    public function update($id, $name, $last_name, $avatar)
    {
        $person = $this->find($id);
        $person->name = $name;
        $person->last_name = $last_name;
        $person->avatar = $avatar;
        $person->save();
        return $person;
    }
    public function find($id)
    {
        return personas::where('id', '=', $id)->first();
    }

    function list()
    {
        $persons = User::with('personas', 'roles')->get();
        return $persons->toArray();
    }


 
}

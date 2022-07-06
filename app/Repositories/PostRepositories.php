<?php

namespace App\Repositories;

use App\Models\posts;

class PostRepositories
{

    public function create($foto, $descripcion, $activo, $personas_id)
    {
        $posts['foto'] = $foto;
        $posts['descripcion'] = $descripcion;
        $posts['activo'] = $activo;
        $posts['personas_id'] = $personas_id;

        return posts::create($posts);
    }

    public function update($id, $foto, $descripcion)
    {
        $posts = $this->find($id);
        $posts->foto = $foto;
        $posts->descripcion = $descripcion;
        $posts->save();
        return $posts;
    }
    public function activar($id, $activo)
    {
        $posts = $this->find($id);
        $posts->activo = $activo;
        $posts->save();
        return $posts;
    }
    public function find($id)
    {
        return posts::where('id', '=', $id)->first();
    }

    function list()
    {

        return posts::all();
    }
}

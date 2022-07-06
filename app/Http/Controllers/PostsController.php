<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inquiries;
use App\Models\posts;
use App\Repositories\PostRepositories;
use File;

class PostsController extends Controller
{
    protected $posts_respository;

    public function __construct(PostRepositories $repository)
    {
        $this->posts_respository = $repository;
    }

    public function create(Request $request)
    {
        try {

            $foto = $request->input('foto');
            $descripcion = $request->input('descripcion');
            $activo = posts::Inactivo;
            $personas_id = $request->input('personas_id');
            return response()->json($this->posts_respository->create($foto, $descripcion, $activo, $personas_id));
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updated(Request $request, $id)
    {
        try {
            $foto = $request->input('foto');
            $descripcion = $request->input('descripcion');
            return response()->json($this->posts_respository->update($id, $foto, $descripcion));
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function activar($id)
    {
        try {
            $activo = true;

            return response()->json($this->posts_respository->activar($id, $activo));
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    function listactivos()
    {
        $inquiries = posts::where('activo', '=', true)->get();
        $datos = [];
        foreach ($inquiries as $key => $value) {
            $datos[$key] = [
                'id' => $value['id'],
                'foto' => $value['foto'],
                'descripcion' => $value['descripcion'],
                'activo' => $value['activo'],
                'personas_id' => $value['personas_id'],
            ];
        }
        return response()->json($datos);
    }
    function listaInactivos()
    {
        $inquiries = posts::where('activo', '=', false)->get();
        $datos = [];
        foreach ($inquiries as $key => $value) {
            $datos[$key] = [
                'id' => $value['id'],
                'foto' => $value['foto'],
                'descripcion' => $value['descripcion'],
                'activo' => $value['activo'],
                'personas_id' => $value['personas_id'],
            ];
        }
        return response()->json($datos);
    }

    public function editar($id)
    {
        return response()->json($this->posts_respository->find($id));
    }
    public function upload(Request $request)
    {
        $image = $request->file('file0');

        $image_name = time() . $image->getClientOriginalName();
        \Storage::disk('posts')->put($image_name, \File::get($image));
        $data = array(
            'code' => 200,
            'imagen' => $image_name,
            'status' => 'success',
        );

        return response()->json($data, $data['code']);
    }
    public function delete($id)
    {
        try {
            $posts = posts::where('id', '=', $id)->first();
            $posts->delete();

            return response()->json('Datos eliminados');
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
}



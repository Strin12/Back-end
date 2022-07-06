<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\personas;
use App\Models\User;
use App\Repositories\PersonasRepositories;
use App\Repositories\UserRepositories;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use File;

class UsuariosController extends Controller
{
    protected $users_repository;
    protected $persons_repository;

    public function __construct(UserRepositories $_users, PersonasRepositories $_persons)
    {
        $this->users_repository = $_users;
        $this->persons_repository = $_persons;
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $users = JWTAuth::user();
        $persons = $users->personas;
        $roles = $users->roles;



        return response()->json(compact('token', 'users'));
    }


    public function registerAdmin(Request $request)
    {

        try {
            $person = $this->persons_repository->create(
                $request->get('name'),
                $request->get('last_name'),
                'default.jpg'
            );

            $user = $this->users_repository->create(
                $request->get('name'),
                $request->get('last_name'),
                $request->get('email'),
                Hash::make($request->get('password')),
                $person->id,
                User::Admin
            );

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token', 'person'), 201);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function register(Request $request)
    {

        try {
            $person = $this->persons_repository->create(
                $request->get('name'),
                $request->get('last_name'),
                'default.jpg'
            );

            $user = $this->users_repository->create(
                $request->get('name'),
                $request->get('last_name'),
                $request->get('email'),
                Hash::make($request->get('password')),
                $person->id,
                User::APP
            );

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token', 'person'), 201);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function delete($id)
    {
        try {
            $user = User::where('id', '=', $id)->first();
            $user->personas->delete();
            $user->delete();

            return response()->json('Datos eliminados');
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function updated(Request $request, $id)
    {
        try {
            $user2 = personas::where('id', '=', $id)->first();

            $person = $this->persons_repository->update(
                $user2->id,
                $request->get('name'),
                $request->get('last_name'),
                $request->get('avatar')
            );

            $user = $this->users_repository->update(
                $user2->users->id,
                $request->get('name'),
                $request->get('last_name'),
                $request->get('email'),
                Hash::make($request->get('password')),
            );


            return response()->json(compact('user', 'person'), 201);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function editar($id)
    {

        $person = personas::where('id', '=', $id)->first();
        $user = User::where('id', '=', $person->users->id)->first();

        $masvar = [
            'id' => $person['id'],
            'name' => $person['name'],
            'last_name' => $person['last_name'],
            'avatar' => $person['avatar'],
            'roles_id' => $person['roles_id'],
            'email' => $user['email'],
            'person' => $user['name'],
            'persons_id' => $user['persons_id'],
            'rol' => $user->roles['name'],

        ];

        return response()->json($masvar);
    }
    public function upload(Request $request)
    {
        $image = $request->file('file0');

        $image_name = time() . $image->getClientOriginalName();
        \Storage::disk('images')->put($image_name, \File::get($image));
        $data = array(
            'code' => 200,
            'imagen' => $image_name,
            'status' => 'success',
        );

        return response()->json($data, $data['code']);
    }
    function list()
    {
        return response()->json($this->persons_repository->list());
    }
}

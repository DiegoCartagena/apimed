<?php

namespace App\Http\Controllers;
use App\Http\Controllers\TokensController;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function __construct(TokensController $tokensController)
    {
        $this->tokensController = $tokensController;
        $this->header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
    }

    
    // Crear el payload
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $password = hash_hmac('sha256', $request->password,strval(env('SECRET_PHAR')));
        $user = UserModel::where('password',$password)->first();
        $payload = [
            'sub' => $user->id, // ID del usuario
            'name' => $user->nombre,
            'iat' => time(), // Tiempo de emisión
            'exp' => time() + 7200 // Tiempo de expiración (1 hora)
        ];
            $token = $this->tokensController->generateJwt($this->header,$payload);
            //var_dump($this->tokensController->verifyJwt($token));
            if($user->email==$request->email && $user->password==$password){
                $user->remember_token = $token;
            return response()->json([
                'codigo' => 0,
                'message' => 'Login as Succefull',
                'user' => $user,
                'token' => $token
            ]);
        }else{
            return response()->json([
                'codigo' => -1,
                'message' => 'Usuario no existe en la bd',
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
           
            $data = $request->all();

            $user = array();
            if($data && $data!=null && !empty($data)){
                $user['nombre'] =$data['nombre'] ;
                $user['rut'] = $data['rut'];
                $user['email'] = $data['email'] ;
                $user['password'] = hash_hmac('sha256', $data['password'],strval(env('SECRET_PHAR')));
                $user['aMaterno'] = $data['aMaterno'] ;
                $user['aPaterno'] = $data['aPaterno'];
                $user['created_at'] = date('Y-m-d');
                $user['estado'] = 1;
                $user['telefono'] = isset($data['telefono']) ? $data['telefono'] : null;
                $user['id_perfil'] = $data['id_perfil'];
                //$user->id_agenda = new Agenda();
                $user['estado'] = 1; 
            }
            $payload = [
                'sub' => $user['rut'], // ID del usuario
                'name' => $user['nombre'],
                'iat' => time(), // Tiempo de emisión
                'exp' => time() + 10800 // Tiempo de expiración (3 hora)
            ];
            $token = $this->tokensController->generateJwt($this->header,$payload);
            $user['remember_token']=$token;
                $creado = UserModel::create($user);
            return response()->json([
                "Estado" => "Ok",
                "Mensaje" => "Usuario creado por exito",
                "Usuario" => $user,
                "Token" =>[
                    'token'=>$token,
                    'type' => 'Bearer'
                    ] 
            ]); 

        } catch (\Exception $e) {
            die($e);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    // get all users

    public function getUsers()
    {
        $users = UserModel::all();
       
        foreach ($users as $key => $user) {
            unset($user->password);
            unset($user->id_agenda);
            unset($user->remember_token);
            unset($user->created_at);
            unset($user->update_at); 
        }
        if(count($users)>0){
            return response()->json([
                "Estado" => "Ok",
                "Cantidad" => count($users),
                "Usuarios" => $users
            ]);
        }else{
            return response()->json([
                "Estado" => "Ok",
                "Mensaje" => "No Existen usuarios registrados"
            ]);
        }
    }

    public function getProfesionales()
    {
        $profesionales = UserModel::where('id_perfil',2)->get();
        foreach ($profesionales as $key => $profesional) {
            unset($profesional->password);
            unset($profesional->id_agenda);
        }
        if(count($profesionales)>0){
            return response()->json([
                "Estado" => "Ok",
                "Cantidad" => count($profesionales),
                "Profesionales" => $profesionales
            ]);
        }else{
            return response()->json([
                "Estado" => "Ok",
                "Mensaje" => "No Existen usuarios registrados"
            ]);
        }
    }
    public function getPacientes()
    {
        try {
            $pacientes = UserModel::where('id_perfil',3)->get();
            foreach ($pacientes as $key => $paciente) {
                unset($paciente->password);
                unset($paciente->id_agenda);
            }
            if(count($pacientes)>0){
                return response()->json([
                    "Estado" => "Ok",
                    "Cantidad" => count($pacientes),
                    "Pacientes" => $pacientes
                ]);
            }else{
                return response()->json([
                    "Estado" => "Ok",
                    "Mensaje" => "No Existen usuarios registrados"
                ]);
            }
        } catch (\Exception $e) {
            //throw $th;
            die($e);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $user = UserModel::where('id',$id);
            if($user){
                return response()->json([
                    "Estado"=>"Ok",
                    "Usuario" => $user
             ]);
            }
        } catch (\Exception $e) {
            //throw $th;
            die($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            if($request->id){
                $user = UserModel::where('id',$request->id)->first();;
                $user->password = isset($request->password) ? hash_hmac('sha256', $request->password,strval(env('SECRET_PHAR'))) : $user->password;
                $user->id_perfil = isset($request->id_perfil) ?  $request->id_perfil : $user->id_perfil;
                $user->updated_at = date('Y-m-d');
                $user->email=$request->email;
                $user->estado = $request->estado;
                $user->telefono = $request->telefono;
                $payload = [
                    'sub' => $user->rut, // ID del usuario
                    'name' => $user->nombre,
                    'iat' => time(), // Tiempo de emisión
                    'exp' => time() + 10800 // Tiempo de expiración (3 hora)
                ];
                $token = $this->tokensController->generateJwt($this->header,$payload);
                $user->remember_token=$token;
                $user->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"Usuario actualizado con exito",
                   "Usuario" => $user
            ]);
            }
        } catch (\Exception $e) {
            die($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $user = UserModel::where('id',$id)->first();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"Usuario actualizado con exito",
            "Usuario" => $user
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = UserModel::find($id);
        $user->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"Usuario eliminado con exito",
            "Usuario" => $user
     ]);
    }
}

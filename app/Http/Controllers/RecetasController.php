<?php

namespace App\Http\Controllers;

use App\Models\RecetasModel;
use Illuminate\Http\Request;
use App\Models\UserModel;

class RecetasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
     
        $recetas = RecetasModel::all();
        foreach ($recetas as  $value) {
            $value->paciente = UserModel::find($value->idPaciente)->where('id',$value->idPaciente)->first();
            $value->profesional = UserModel::find($value->idProfesional)->where('id',$value->idProfesional)->first();
            unset($value->idProfesional);
            unset($value->idPaciente);
            //$value->medicamentos = json_decode($value->medicamentos);
        }
            if($recetas){
            return response()->json([
                'codigo' => 0,
                'message' => 'sinError',
                'recetas' => $recetas
            ]);
        }else{
            return response()->json([
                'codigo' => -1,
                'message' => 'no existenRecetas',
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $receta = new RecetasModel;
        $receta->nombrePaciente = $request->nombrePaciente;
        $receta->rutPaciente = $request->rutPaciente;
        $receta->fecha = date('d-m-Y h:m:i');
        $receta->retenida = $request->retenida;
        $receta->rutProfesional = $request->rutProfesional;
        $receta->nombrePofesional = $request->nombreProfesional;
        $receta->medicamentos = $request->medicamentos;
        $receta->diagnostico = $request->diagnostico;
        $receta->idPaciente = $request->idPaciente;
        $receta->idProfesional = $request->idProfesional;
        $receta->save();
        return response()->json([
            "estado" => "Ok",
            "mensaje" => "Receta guardada con exito",
            "receta"=>$receta
    ]);
        }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $receta = RecetasModel::find($id);
        return response()->json([
                "receta"=>$receta
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,string $id)
    {
        $receta = RecetasModel::find($id);
        if($request!=null){
           // $paciente= UserModel::find($request->pacienteId)->where('id_perfil',3)->first();
            //$profesional = UserModel::find($request->profesionalId)->where('id_perfil',2)->first();;
           // $receta->retenida=$request->retenida;
            $receta->nombreProfesional=$request->nombreProfesional;//$profesional->nombre.' '.$profesional->aPaterno.' '.$profesional->aMaterno;
            //$receta->nombrePaciente = $paciente->nombre.' '.$paciente->aPaterno.' '.$paciente->aMaterno;
            //$receta->rutPaciente = $request->rutPaciente;
        }
        $receta->save();
        return response()->json([
            "estado"=>'Ok',
            "receta"=>$receta
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $receta = RecetasModel::find($id);
        $receta->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje" => "receta eliminada con exito",
            "Usuario" => $receta
    ]);
    }
}

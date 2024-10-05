<?php

namespace App\Http\Controllers;

use App\Models\MedicamentosModel;
use Illuminate\Http\Request;

class MedicamentosController extends Controller
{


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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $medicamentos = MedicamentosModel::where('id',$id);
        if($medicamentos){
            return response()->json([
                "Estado"=>"Ok",
                "medicamentos" => $medicamentos
         ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
            if($request->id){
                $medicamentos = MedicamentosModel::where('id',$request->id)->first();;
                $medicamentos->password = $request->password;
                $medicamentos->id_perfil = $request->perfilId;
                $medicamentos->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"medicamentos actualizado con exito",
                   "medicamentos" => $medicamentos
            ]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $medicamentos = MedicamentosModel::whwr('id',$id)->first();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"medicamentos actualizado con exito",
            "medicamentos" => $medicamentos
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $medicamentos = MedicamentosModel::find($id);
        $medicamentos->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"medicamentos eliminado con exito",
            "medicamentos" => $medicamentos
     ]);
    }
}

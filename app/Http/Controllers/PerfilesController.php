<?php

namespace App\Http\Controllers;

use App\Models\PerfilModel;
use Illuminate\Http\Request;

class PerfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
        $Perfil = PerfilModel::where('id',$id)->first();
        if($Perfil){
            return response()->json([
                "Estado"=>"Ok",
                "Perfil" => $Perfil
         ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
            if($request->id){
                $Perfil = PerfilModel::where('id',$request->id)->first();
               
                $Perfil->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"Usuario actualizado con exito",
                   "Usuario" => $Perfil
            ]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $Perfil = PerfilModel::find($id);
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"Usuario actualizado con exito",
            "Usuario" => $Perfil
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $Perfil = PerfilModel::find($id);
        $Perfil->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"Usuario eliminado con exito",
            "Usuario" => $Perfil
     ]);
    }
}

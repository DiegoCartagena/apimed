<?php

namespace App\Http\Controllers;

use App\Models\CitasmedicasModel;
use Illuminate\Http\Request;

class OrdenesExamenController extends Controller
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
        $citaMedica = CitasmedicasModel::where('id',$id);
        if($citaMedica){
            return response()->json([
                "Estado"=>"Ok",
                "citaMedica" => $citaMedica
         ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
            if($request->id){
                $citaMedica = CitasmedicasModel::where('id',$request->id)->first();;
                $citaMedica->password = $request->password;
                $citaMedica->id_perfil = $request->perfilId;
                $citaMedica->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"citaMedica actualizado con exito",
                   "citaMedica" => $citaMedica
            ]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $citaMedica = CitasmedicasModel::whwr('id',$id)->first();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"citaMedica actualizado con exito",
            "citaMedica" => $citaMedica
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $citaMedica = CitasmedicasModel::find($id);
        $citaMedica->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"citaMedica eliminado con exito",
            "citaMedica" => $citaMedica
     ]);
    }
}

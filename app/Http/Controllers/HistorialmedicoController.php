<?php

namespace App\Http\Controllers;

use App\Models\HistorialmedicoModel;
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
        $historial = HistorialmedicoModel::where('id',$id);
        if($historial){
            return response()->json([
                "Estado"=>"Ok",
                "historial" => $historial
         ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
            if($request->id){
                $historial = HistorialmedicoModel::where('id',$request->id)->first();;
                $historial->password = $request->password;
                $historial->id_perfil = $request->perfilId;
                $historial->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"historial actualizado con exito",
                   "historial" => $historial
            ]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $historial = HistorialmedicoModel::whwr('id',$id)->first();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"historial actualizado con exito",
            "historial" => $historial
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $historial = HistorialmedicoModel::find($id);
        $historial->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"historial eliminado con exito",
            "historial" => $historial
     ]);
    }
}

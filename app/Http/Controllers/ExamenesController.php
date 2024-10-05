<?php

namespace App\Http\Controllers;

use App\Models\ExamenesModel;
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
        $examen = ExamenesModel::where('id',$id);
        if($examen){
            return response()->json([
                "Estado"=>"Ok",
                "examen" => $examen
         ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
            if($request->id){
                $examen = ExamenesModel::where('id',$request->id)->first();;
                $examen->password = $request->password;
                $examen->id_perfil = $request->perfilId;
                $examen->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"examen actualizado con exito",
                   "examen" => $examen
            ]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $examen = ExamenesModel::whwr('id',$id)->first();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"examen actualizado con exito",
            "examen" => $examen
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $examen = ExamenesModel::find($id);
        $examen->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"examen eliminado con exito",
            "examen" => $examen
     ]);
    }
}

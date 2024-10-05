<?php

namespace App\Http\Controllers;

use App\Models\OrdenExamenModel;
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
        $ordenExamen = OrdenExamenModel::where('id',$id);
        if($ordenExamen){
            return response()->json([
                "Estado"=>"Ok",
                "OrdenExamen" => $ordenExamen
         ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
            if($request->id){
                $ordenExamen = OrdenExamenModel::where('id',$request->id)->first();;
                $ordenExamen->password = $request->password;
                $ordenExamen->id_perfil = $request->perfilId;
                $ordenExamen->save();
                return response()->json([
                   "Estado"=>"Ok",
                   "Mensaje"=>"OrdenExamen actualizado con exito",
                   "OrdenExamen" => $ordenExamen
            ]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $ordenExamen = OrdenExamenModel::whwr('id',$id)->first();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"OrdenExamen actualizado con exito",
            "OrdenExamen" => $ordenExamen
     ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $ordenExamen = OrdenExamenModel::find($id);
        $ordenExamen->delete();
        return response()->json([
            "Estado"=>"Ok",
            "Mensaje"=>"OrdenExamen eliminado con exito",
            "OrdenExamen" => $ordenExamen
     ]);
    }
}

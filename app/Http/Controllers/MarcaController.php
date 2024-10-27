<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function index()
    {
        $marcas = Marca::all();
        return response()->json($marcas);
    }


    public function store(Request $request)
    {
        $rules = ['marca' => 'required|string|min:1|max:100'];
        $validator = \Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
        $marca = new Marca($request->input());
        $marca->save();
        return response()->json([
            'status' => true,
            'message' => 'Marca creada'
        ], 200);
    }

    public function show($id)
    {
        // Buscar la marca por su ID
        $marca = Marca::find($id);

        // Si no se encuentra, devolver una respuesta personalizada
        if (!$marca) {
            return response()->json([
                'status' => false,
                'message' => 'The selected id is invalid'
            ], 404);
        }

        // Si se encuentra la marca, devolver los datos de la marca
        return response()->json([
            'status' => true,
            'data' => $marca
        ]);
    }

    public function update(Request $request, Marca $marca)
    {
        $rules = ['marca' => 'required|string|min:1|max:100'];
        $validator = \Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }
        $marca->update($request->input());
        return response()->json([
            'status' => true,
            'message' => 'Marca actualizada'
        ], 200);
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();
        return response()->json([
            'status' => true,
            'message' => 'Marca borrada'
        ], 200);
    }
}

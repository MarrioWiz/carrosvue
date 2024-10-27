<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\Marca;

class AutoController extends Controller
{
    public function index()
    {
        $auto = Auto::select('autos.*', 'marcas.marca as marca')
            ->join('marcas', 'marcas.id', '=', 'autos.marca_id')
            ->paginate(10);
        
        return response()->json($auto);
    }

    public function store(Request $request)
    {
        $rules = [
            'modelo' => 'required|string|max:80',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'transmision' => 'required|string|max:50',
            'submarca' => 'required|string|max:80',
            'marca_id' => 'required|numeric',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        // Manejo de la imagen
        $imagenPath = $request->file('imagen')->store('uploads', 'public');

        // Crear nuevo registro
        $auto = new Auto($request->all());
        $auto->imagen = '/storage/' . $imagenPath;  // Guardar la ruta de la imagen
        $auto->save();

        return response()->json([
            'status' => true,
            'message' => 'Auto creado satisfactoriamente'
        ], 200);
    }

    public function show($id)
    {
        // Buscar el auto por su ID
        $auto = Auto::find($id);

        // Si no se encuentra, devolver una respuesta personalizada
        if (!$auto) {
            return response()->json([
                'status' => false,
                'message' => 'The selected auto is invalid'
            ], 404);
        }

        // Si se encuentra el auto, devolver los datos del auto
        return response()->json(['status' => true, 'data' => $auto]);
    }

    public function update(Request $request, Auto $auto)
    {
        $rules = [
            'modelo' => 'required|string|max:80',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'transmision' => 'required|string|max:50',
            'submarca' => 'required|string|max:80',
            'marca_id' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        // Si hay una imagen nueva, eliminar la anterior y guardar la nueva
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior
            if ($auto->imagen && Storage::exists('public/' . str_replace('/storage/', '', $auto->imagen))) {
                Storage::delete('public/' . str_replace('/storage/', '', $auto->imagen));
            }

            // Guardar la nueva imagen
            $imagenPath = $request->file('imagen')->store('uploads', 'public');
            $auto->imagen = '/storage/' . $imagenPath;
        }

        // Actualizar otros campos
        $auto->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Auto actualizado correctamente'
        ], 200);
    }

    public function destroy($id)
    {
        // Buscar el auto por su ID
        $auto = Auto::find($id);

        // Si no se encuentra, devolver una respuesta personalizada
        if (!$auto) {
            return response()->json([
                'status' => false,
                'message' => 'The selected auto is invalid'
            ], 404);
        }

        // Eliminar la imagen asociada si existe
        if ($auto->imagen && Storage::exists('public/' . str_replace('/storage/', '', $auto->imagen))) {
            Storage::delete('public/' . str_replace('/storage/', '', $auto->imagen));
        }

        $auto->delete();

        return response()->json([
            'status' => true,
            'message' => 'Auto eliminado correctamente'
        ], 200);
    }

    public function AutosByMarca()
    {
        $autos = Auto::select(DB::raw('count(autos.id) as count, marcas.marca'))
            ->rightJoin('marcas', 'marcas.id', '=', 'autos.marca_id')
            ->groupBy('marcas.marca')
            ->get();

        return response()->json($autos);
    }

    public function all()
    {
        $autos = Auto::select('autos.*', 'marcas.marca as marca')
            ->join('marcas', 'marcas.id', '=', 'autos.marca_id')
            ->get();

        return response()->json($autos);
    }
}

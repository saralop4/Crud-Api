<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    //metodos que van a ser accedidos o llamados desde routes/api.php

    public function Index(){
        $estudiante = Estudiante::all();

        $data = [
            'estudiantes'=> $estudiante,
            'estado'=>200
        ];
        return response()->json($data, 200);
    }

    public function Create(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:estudiantes',
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required',
        ]);

        if ($validador->fails()) {
            $data = [
                'mensaje' => 'Error de validacion de los datos',
                'errors' => $validador->errors(),
                'estado' => 400,
            ];
            return response()->json($data, 400);
        }

        try {
            $estudiante = Estudiante::create([
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'lenguaje' => $request->lenguaje,
            ]);
        } catch (\Exception $e) {
            $data = [
                'mensaje' => 'Error al guardar los datos del estudiante: ' . $e->getMessage(),
                'estado' => 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            'estudiante' => $estudiante,
            'mensaje' => 'Estudiante guardado correctamente',
            'estado' => 201,
        ];

        return response()->json($data, 201);
    }

}

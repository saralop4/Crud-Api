<?php

namespace App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    //metodos que van a ser accedidos o llamados desde routes/api.php

    public function GetAll()
    {
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

    public function GetForId($id)
    {

        $estudiante= Estudiante::find($id);

        if(!$estudiante){

            $data=[

                'mensaje'=>'Estudiante no encontrado',
                'estado'=>404
            ];

            return response()->json($data,404);
        }

        $data=[
            'estudiante'=>$estudiante,
            'estado'=>200
        ];
        return response()->json($data,200);
    }

    public function Delete($id)
    {
        $estudiante = Estudiante::find($id);

        if(!$estudiante){

            $data= [

                'mensaje'=> 'El estudiante no existe',
                "estado"=>404
            ];

            return response()->json($data,404);
        }
        $estudiante->delete();

        $data=[
            'mensaje'=> 'Estudiante eliminado correctamente',
            'estado'=>200
        ];

        return response()->json($data,200);


    }

    public function Update(Request $request,$id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {

            $data = [

                'mensaje' => 'El estudiante no existe',
                "estado" => 404
            ];

            return response()->json($data, 404);
        }

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
            $estudiante->nombre = $request->nombre;
            $estudiante->correo= $request->correo;
            $estudiante->telefono = $request->telefono;
            $estudiante->lenguaje= $request->lenguaje;

            $estudiante->save();

            $data = [
                'estudiante' => $estudiante,
                'mensaje' => 'Estudiante actualizado correctamente',
                'estado' => 200,
            ];

            return response()->json($data, 200);

        } catch (\Exception $e) {
            $data = [
                'mensaje' => 'Error al actualizar los datos del estudiante: ' . $e->getMessage(),
                'estado' => 500,
            ];
            return response()->json($data, 500);
        }


    }

    public function Patch(Request $request,$id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {

            $data = [

                'mensaje' => 'El estudiante no existe',
                "estado" => 404
            ];

            return response()->json($data, 404);
        }


        $validador = Validator::make($request->all(), [
            'nombre' => 'max:255',
            'correo' => 'email|unique:estudiantes',
            'telefono' => 'digits:10',
            'lenguaje' => '',
        ]);

        if ($validador->fails()) {
            $data = [
                'mensaje' => 'Error de validacion de los datos',
                'errors' => $validador->errors(),
                'estado' => 400,
            ];
            return response()->json($data, 400);
        }

        if($request->has('nombre')){
            $estudiante->nombre = $request->nombre;
        }

        if($request->has('correo')){
            $estudiante->correo = $request->correo;
        }

        if($request->has('telefono')){
            $estudiante->telefono = $request->telefono;
        }

        if($request->has('lenguaje')){
            $estudiante->lenguaje = $request->lenguaje;
        }

        $estudiante->save();

        $data = [
            'estudiante' => $estudiante,
            'mensaje' => 'Estudiante actualizado correctamente',
            'estado' => 200,
        ];

        return response()->json($data, 200);
    }

}

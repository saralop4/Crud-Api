<?php

namespace App\Http\Controllers;

use App\Models\Response\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class EstudianteController extends Controller
{
    //metodos que van a ser accedidos o llamados desde routes/api.php

    public function GetAll()
    {

        try{
            $estudiante = Estudiante::all();

            if (!$estudiante->isEmpty()) {
                return ApiResponse::ResponseSuccess('Listado exitoso', 200, $estudiante);
            }

            return ApiResponse::ResponseSuccess('No hay información para mostrar', 200);

          //  throw new Exception("error provocado");
        }catch(Exception $ex){

            return ApiResponse::ResponseError('Ha ocurrido un error de servidor - '.$ex->getMessage(), 500);
        }

    }

    public function Create(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|max:255',
                'correo' => 'required|email|unique:estudiantes',
                'telefono' => 'required|digits:10',
                'lenguaje' => 'required',
            ]);

            $estudiante = Estudiante::create($request->all());
            return ApiResponse::ResponseSuccess('Estudiante Guardado Exitosamente', 201, $estudiante);
        } catch (ValidationException $e) {
            $erroresValidaciones = $e->validator->errors()->toArray();
            return ApiResponse::ResponseError('Error de validación - ' . $e->getMessage(), 422, $erroresValidaciones);
        }
    }


    public function GetForId($id)
    {

        try{

            $estudiante = Estudiante::findOrFail($id);
            return ApiResponse::ResponseSuccess('Estudiante Obtenido Exitosamente', 200, $estudiante);

        }catch(ModelNotFoundException $e){
            return ApiResponse::ResponseError('Estudiante No Encontrado - '.$e->getMessage(), 404);

        }

    }

    public function Delete($id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);
            $estudiante->delete();

            return ApiResponse::ResponseSuccess('Estudiante Eliminado Exitosamente', 200);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        } catch (Exception $ex) {
            return ApiResponse::ResponseError('Hubo un error y no se pudo eliminar el registro - ' . $ex->getMessage(), 500);
        }
    }


    public function Update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        try {

            $request->validate([
                'nombre' => ['required|max:255', Rule::unique('estudiantes')->ignore($estudiante)], //esta linea permite actualizar el campo con el mismo dato que ya tiene
                'correo' => 'required|email|unique:estudiantes',
                'telefono' => 'required|digits:10',
                'lenguaje' => 'required',
            ]);

            $estudiante->update($request->all());
            return ApiResponse::ResponseSuccess('Estudiante Actualizado Exitosamente', 200, $estudiante);

        } catch (ValidationException $e) {
            $erroresValidaciones = $e->validator->errors()->toArray();

            if(isset($erroresValidaciones['nombre'])) {
                $errors['nombreEstudiante'] = $erroresValidaciones['nombre']; //con esto puedo hacer una copia del campo al que quiero cambiarle el nombre
                unset($errors['nombre']); //como se duplican dos campos, con esto eliminamos el que queremos que no aparezca
            }
            return ApiResponse::ResponseError('Errores de validacion', 422, $erroresValidaciones);
        }
        catch(ModelNotFoundException $e){
            return ApiResponse::ResponseError('Estudiante No Encontrado - '.$e->getMessage(), 404);

        }

    }

    public function Patch(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);

        try {
            $request->validate([
                'nombre' => 'nullable|max:255|unique:estudiantes,nombre,' . $estudiante->id, //decirle a laravel que ignore el hecho que ya existe el mismo nombre que quiero actulizar
                'correo' => 'nullable|email|unique:estudiantes,correo,' . $estudiante->id,
                'telefono' => 'nullable|digits:10',
                'lenguaje' => 'nullable|max:255',
            ]);

            $datosActualizar = $request->only(['nombre', 'correo', 'telefono', 'lenguaje']);
            $estudiante->update(array_filter($datosActualizar));

            return ApiResponse::ResponseSuccess('Estudiante actualizado correctamente', 200, $estudiante);
        } catch (ValidationException $e) {
            return ApiResponse::ResponseError('Errores de validación', 422, $e->errors());
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante no encontrado', 404);
        } catch (Exception $e) {
            return ApiResponse::ResponseError('Error al actualizar los datos del estudiante: ' . $e->getMessage(), 500);
        }
    }

}

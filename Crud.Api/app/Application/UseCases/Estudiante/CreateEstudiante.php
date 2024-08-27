<?php

namespace App\Application\UseCases\Estudiante;


use App\Domain\Interfaces\EstudianteInterface;
use Illuminate\Validation\ValidationException;
use App\Domain\Response\ApiResponse;



class CreateEstudiante
{
    private $estudianteInterface;

    public function __construct(EstudianteInterface $estudianteInterface)
    {
        $this->estudianteInterface = $estudianteInterface;
    }

    public function execute(array $data)
    {

        try {

            $estudiante = $this->estudianteInterface->create($data);
            return ApiResponse::ResponseSuccess('Estudiante Guardado Exitosamente', 201, $estudiante);

        } catch (ValidationException $e) {
            $erroresValidaciones = $e->validator->errors()->toArray();
            return ApiResponse::ResponseError('Error de validación - ' . $e->getMessage(), 422, $erroresValidaciones);
        } catch (\Exception $ex) {
            return ApiResponse::ResponseError('Hubo un error y no se pudo crear el registro - ' . $ex->getMessage(), 500);
        }
    }
}

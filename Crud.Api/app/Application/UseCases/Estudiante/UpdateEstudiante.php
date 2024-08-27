<?php

namespace App\Application\UseCases\Estudiante;

use App\Domain\Interfaces\EstudianteInterface;
use App\Domain\Response\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UpdateEstudiante
{
    private $estudianteInterface;

    public function __construct(EstudianteInterface $estudianteInterface)
    {
        $this->estudianteInterface = $estudianteInterface;
    }

    public function execute(array $data, $id)
    {
        try {
            $estudiante = $this->estudianteInterface->findById($id);

            $this->estudianteInterface->update($estudiante, $data);

            return ApiResponse::ResponseSuccess('Estudiante Actualizado Exitosamente', 200, $estudiante);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::ResponseError('Estudiante No Encontrado - ' . $e->getMessage(), 404);
        } catch (ValidationException $e) {
            $erroresValidaciones = $e->validator->errors()->toArray();
            return ApiResponse::ResponseError('Error de validación - ' . $e->getMessage(), 422, $erroresValidaciones);
        }
    }
}

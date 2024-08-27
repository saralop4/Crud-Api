<?php

namespace App\Application\Services;

use App\Application\UseCases\Estudiante\CreateEstudiante;
use App\Application\UseCases\Estudiante\DeleteEstudiante;
use App\Application\UseCases\Estudiante\GetAllEstudiante;
use App\Application\UseCases\Estudiante\GetEstudianteById;
use App\Application\UseCases\Estudiante\PatchEstudiante;
use App\Application\UseCases\Estudiante\UpdateEstudiante;

class EstudianteServices
{

    private $createEstudiante;
    private $getAllEstudiante;
    private $getEstudiante;
    private $deleteEstudiante;
    private $updateEstudiante;
    private $patchEstudiante;

    public function __construct(
        CreateEstudiante $createEstudiante,
        GetAllEstudiante $getAllEstudiante,
        GetEstudianteById $getEstudiante,
        DeleteEstudiante $deleteEstudiante,
        UpdateEstudiante $updateEstudiante,
        PatchEstudiante $patchEstudiante
    ) {
        $this->createEstudiante = $createEstudiante;
        $this->getAllEstudiante = $getAllEstudiante;
        $this->getEstudiante = $getEstudiante;
        $this->deleteEstudiante = $deleteEstudiante;
        $this->updateEstudiante = $updateEstudiante;
        $this->patchEstudiante = $patchEstudiante;
    }
    public function getAllEstudiantes()
    {
        return $this->getAllEstudiante->execute();
    }

    public function createEstudiante(array $data)
    {
        // Validaciones y lógica de negocio
        return $this->createEstudiante->execute($data);
    }

    public function getEstudianteById($id)
    {
        return $this->getEstudiante->execute($id);
    }

    public function deleteEstudiante($id)
    {
        return $this->deleteEstudiante->execute($id);
    }

    public function updateEstudiante($id, array $data)
    {
        return $this->updateEstudiante->execute($id, $data);
    }

    public function patchEstudiante(array $data, $id)
    {
        return $this->patchEstudiante->execute($data, $id);
    }
}

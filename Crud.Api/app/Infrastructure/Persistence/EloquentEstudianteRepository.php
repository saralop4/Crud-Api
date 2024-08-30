<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Interfaces\EstudianteInterface;
use App\Domain\Models\Estudiante;

class EloquentEstudianteRepository implements EstudianteInterface
{
    public function getAll()
    {
        return Estudiante::all();
    }

    public function findById($id)
    {
        return Estudiante::findOrFail($id);
    }

    public function create(array $data)
    {
        return Estudiante::create($data);
    }

    public function update(array $data,$id)
    {
        $id->update($data);
        return $id;
    }

    public function delete($id)
    {
        $id->delete();
    }
    public function patch(array $data, $id)
    {
        $id->update(array_filter($data));
        return $id;
    }
}

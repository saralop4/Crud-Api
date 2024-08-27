<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

  //  protected $table = 'estudiante'; se usa para especificar en caso que en base de datos este en singular

    protected $fillable = [
         'nombre',
         'correo',
         'telefono',
         'lenguaje'
    ];
}

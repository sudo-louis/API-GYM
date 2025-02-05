<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $primaryKey = 'ID';
    protected $table = 'empleados';

    protected $fillable = [
        'foto',
        'nombre',
        'apellido',
        'fecha_contratacion',
        'telefono',
        'correo',
        'rol',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    use HasFactory;

    // Agrega los campos que deseas permitir para la asignación masiva
    protected $fillable = [
        'Codigo',
        'Empresa_Cliente',
        'Correo_Electronico',
        'Estado',
        'Telefono',
        'DPI',
        'Patente',
        'RTU',
        'Tipo_Cliente',
        'Departamento',
        'Municipio',
        'Completar_Direccion',
        
    ];
}

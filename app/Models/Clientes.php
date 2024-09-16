<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    // Agrega los campos que deseas permitir para la asignación masiva
    protected $fillable = [
       'Codigo',
    'Empresa_Cliente',
    'Correo_Electronico',
    'Estado',
    'Telefono',
    'Genero',
    'NIT',
    'Numero_DPI',
    'Nombre_Representante_legal',
    'Fecha_de_Registro',
    'Tipo_Cliente',
    'Departamento',
    'Municipio',
    'Completar_Direccion',
    ];
}

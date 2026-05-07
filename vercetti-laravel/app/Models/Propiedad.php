<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table = 'propiedades';
    public $timestamps = false;

    protected $fillable = [
        'propietario_id',
        'titulo',
        'zona',
        'precio',
        'metros_cuadrados',
        'num_habitaciones',
        'fecha_construccion',
        'amueblada',
        'tipo_inmueble',
        'descripcion',
        'imagen'
    ];

    public function propietario()
    {
        return $this->belongsTo(Propietario::class, 'propietario_id');
    }
}
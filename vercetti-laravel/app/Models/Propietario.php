<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    protected $table = 'propietarios';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'telefono',
        'email'
    ];

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class, 'propietario_id');
    }
}
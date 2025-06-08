<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;
    
    protected $table = 'roles';
    
    protected $fillable = [
        'nombre',
        'descripcion'
    ];
    
    /**
     * Obtiene los usuarios que tienen este rol
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'rol_id');
    }
    
    /**
     * Obtiene los registros asociados a este rol
     */
    public function registros(): HasMany
    {
        return $this->hasMany(Registro::class, 'rol_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registro extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tipo_registro',
        'user_id',
        'rol_id',
        'celador_id',
        'observacion',
        'justificacion',
        'foto_soporte'
    ];
    
    /**
     * Obtiene el usuario al que pertenece este registro
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Obtiene el rol asociado a este registro
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
    
    /**
     * Obtiene el celador que creó este registro
     */
    public function celador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'celador_id');
    }
}

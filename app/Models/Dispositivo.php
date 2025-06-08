<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dispositivo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tipo_dispositivo',
        'marca',
        'serial',
        'foto_serial',
        'foto_dispositivo',
        'user_id',
    ];
    
    /**
     * Obtiene el usuario propietario del dispositivo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

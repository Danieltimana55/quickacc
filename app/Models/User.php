<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'email',
        'password',
        'rol_id',
        'formacion_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Obtiene el rol del usuario
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
    
    /**
     * Obtiene la formación del usuario (para aprendices)
     */
    public function formacion(): BelongsTo
    {
        return $this->belongsTo(Formacion::class, 'formacion_id');
    }
    
    /**
     * Obtiene los dispositivos del usuario
     */
    public function dispositivos(): HasMany
    {
        return $this->hasMany(Dispositivo::class, 'user_id');
    }
    
    /**
     * Obtiene los registros del usuario
     */
    public function registros(): HasMany
    {
        return $this->hasMany(Registro::class, 'user_id');
    }
    
    /**
     * Obtiene las formaciones donde este usuario es instructor
     */
    public function formacionesComoInstructor(): HasMany
    {
        return $this->hasMany(Formacion::class, 'instructor_id');
    }
    
    /**
     * Obtiene los registros donde este usuario actuó como celador
     */
    public function registrosComoCelador(): HasMany
    {
        return $this->hasMany(Registro::class, 'celador_id');
    }
    
    /**
     * Verifica si el usuario es administrador
     */
    public function esAdmin(): bool
    {
        return $this->rol && $this->rol->nombre === 'administrador';
    }
    
    /**
     * Verifica si el usuario es instructor
     */
    public function esInstructor(): bool
    {
        return $this->rol && $this->rol->nombre === 'instructor';
    }
    
    /**
     * Verifica si el usuario es aprendiz
     */
    public function esAprendiz(): bool
    {
        return $this->rol && $this->rol->nombre === 'aprendiz';
    }
    
    /**
     * Verifica si el usuario es celador
     */
    public function esCelador(): bool
    {
        return $this->rol && $this->rol->nombre === 'celador';
    }
}

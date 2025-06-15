<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstructorVerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'is_used',
        'used_by_user_id',
        'used_at',
        'expires_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Genera un nuevo código de verificación
     */
    public static function generateCode(): string
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
    }

    /**
     * Verifica si un código es válido
     */
    public static function isValid(string $code): bool
    {
        $verificationCode = self::where('code', strtoupper($code))
            ->where('is_used', false)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        return $verificationCode !== null;
    }

    /**
     * Marca el código como utilizado
     */
    public function markAsUsed(int $userId): void
    {
        $this->update([
            'is_used' => true,
            'used_by_user_id' => $userId,
            'used_at' => now(),
        ]);
    }

    /**
     * El usuario que utilizó este código
     */
    public function usedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }
} 
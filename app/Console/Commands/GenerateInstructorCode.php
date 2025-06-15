<?php

namespace App\Console\Commands;

use App\Models\InstructorVerificationCode;
use Illuminate\Console\Command;

class GenerateInstructorCode extends Command
{
    protected $signature = 'instructor:generate-code {--code= : Optional custom code} {--expires= : Optional expiration date (YYYY-MM-DD)}';
    protected $description = 'Generate a verification code for instructor registration';

    public function handle()
    {
        $customCode = $this->option('code');
        $expiresAt = $this->option('expires');

        $code = $customCode ?: InstructorVerificationCode::generateCode();

        $data = [
            'code' => strtoupper($code),
            'is_used' => false,
        ];

        if ($expiresAt) {
            $data['expires_at'] = $expiresAt;
        }

        $verificationCode = InstructorVerificationCode::create($data);

        $this->info('¡Código de verificación generado con éxito!');
        $this->table(
            ['ID', 'Código', 'Expira'],
            [[$verificationCode->id, $verificationCode->code, $verificationCode->expires_at ?: 'Nunca']]
        );

        return Command::SUCCESS;
    }
} 
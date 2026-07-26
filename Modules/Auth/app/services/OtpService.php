<?php

namespace Modules\Auth\Services;

use Modules\Auth\Models\Otp;

class OtpService
{
    public function generate(string $mobile): string
    {
        $code = random_int(100000, 999999);

        Otp::query()->create([
            'mobile' => $mobile,
            'otp' => $code,
            'expired_at' => now()->addMinutes(2),
        ]);

        return $code;
    }
}

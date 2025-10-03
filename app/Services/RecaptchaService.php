<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    protected string $secretKey;
    protected string $siteKey;

    public function __construct()
    {
        $this->secretKey = config('app.recaptcha_secret_key', env('RECAPTCHA_SECRET_KEY'));
        $this->siteKey = config('app.recaptcha_site_key', env('RECAPTCHA_SITE_KEY'));
    }

    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * Verify reCAPTCHA response
     *
     * @param string|null $response
     * @param string|null $remoteIp
     * @return bool
     */
    public function verify(?string $response, ?string $remoteIp = null): bool
    {
        if (empty($response)) {
            Log::warning('reCAPTCHA: Empty response provided');
            return false;
        }

        if (empty($this->secretKey)) {
            Log::warning('reCAPTCHA: Secret key not configured. Skipping verification.');
            return true; // Allow submission if reCAPTCHA is not configured
        }

        try {
            $data = [
                'secret' => $this->secretKey,
                'response' => $response,
            ];

            if ($remoteIp) {
                $data['remoteip'] = $remoteIp;
            }

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $data);

            $result = $response->json();

            if ($result['success']) {
                Log::info('reCAPTCHA: Verification successful', ['score' => $result['score'] ?? 'N/A']);
                return true;
            } else {
                Log::warning('reCAPTCHA: Verification failed', ['errors' => $result['error-codes'] ?? 'Unknown error']);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('reCAPTCHA: Exception during verification', ['error' => $e->getMessage()]);
            return false;
        }
    }
}

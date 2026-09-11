<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CctvRedirectController extends Controller
{
    private array $portals = [
        'new' => [
            'base'      => 'https://new.cwcnewcctv.in',
            'dashboard' => 'https://new.cwcnewcctv.in/dashboard',
            'login'     => 'https://new.cwcnewcctv.in/login',
        ],
        'analog' => [
            'base'      => 'https://analog.cwcnewcctv.in',
            'dashboard' => 'https://analog.cwcnewcctv.in/dashboard',
            'login'     => 'https://analog.cwcnewcctv.in/login',
        ],
    ];

    private string $username = 'admin';
    private string $password = 'cwc@camera';

    public function redirect(string $portal)
    {
        abort_unless(array_key_exists($portal, $this->portals), 404);
        $config = $this->portals[$portal];

        try {
            // Step 1: GET login page to extract CSRF token + session cookie
            $getResponse = Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                ->get($config['login']);

            // Extract CSRF token from HTML
            $html  = $getResponse->body();
            $token = null;
            if (preg_match('/<input[^>]+name="_token"[^>]+value="([^"]+)"/', $html, $m)) {
                $token = $m[1];
            } elseif (preg_match('/meta[^>]+name="csrf-token"[^>]+content="([^"]+)"/', $html, $m)) {
                $token = $m[1];
            }

            // Extract session cookie
            $cookies = $getResponse->cookies();
            $cookieHeader = '';
            foreach ($cookies as $cookie) {
                $cookieHeader .= $cookie->getName().'='.$cookie->getValue().'; ';
            }

            Log::info('CCTV GET login', [
                'portal'  => $portal,
                'status'  => $getResponse->status(),
                'token'   => $token,
                'cookies' => $cookieHeader,
            ]);

            if (!$token) {
                Log::warning('CCTV: no CSRF token found, falling back');
                return redirect()->away($config['login']);
            }

            // Step 2: POST login — try 'email' and 'username' fields
            foreach (['email', 'username'] as $field) {
                $postResponse = Http::timeout(10)
                    ->withoutVerifying()
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0',
                        'Cookie'     => trim($cookieHeader),
                        'Referer'    => $config['login'],
                    ])
                    ->asForm()
                    ->post($config['login'], [
                        '_token'   => $token,
                        $field     => $this->username,
                        'password' => $this->password,
                    ]);

                $body = $postResponse->body();
                $isLoginPage = str_contains($body, '<title>Login') || str_contains($body, 'Login | Admin');
                $isSuccess   = $postResponse->status() === 302
                    || (!$isLoginPage && $postResponse->status() === 200);

                Log::info('CCTV POST login', [
                    'portal'    => $portal,
                    'field'     => $field,
                    'status'    => $postResponse->status(),
                    'is_login'  => $isLoginPage,
                    'is_success'=> $isSuccess,
                    'location'  => $postResponse->header('Location'),
                ]);

                if ($isSuccess) {
                    $postCookies = $postResponse->cookies();

                    // Build redirect response to the CCTV dashboard
                    $resp = redirect()->away($config['dashboard']);

                    // Set the CCTV session cookies on the shared parent domain (.cwcnewcctv.in)
                    // so the browser sends them when visiting new.cwcnewcctv.in
                    foreach ($postCookies as $c) {
                        $resp->headers->setCookie(
                            \Symfony\Component\HttpFoundation\Cookie::create(
                                $c->getName(),
                                $c->getValue(),
                                time() + 3600,       // 1 hour
                                '/',
                                '.cwcnewcctv.in',    // parent domain — works for all subdomains
                                false,               // not secure-only (use true if HTTPS)
                                false,               // not httpOnly — portal JS needs to read it
                                false,
                                'Lax'
                            )
                        );
                    }

                    Log::info('CCTV login success', [
                        'portal'  => $portal,
                        'field'   => $field,
                        'cookies' => count($postCookies),
                    ]);

                    return $resp;
                }
            }

        } catch (\Exception $e) {
            Log::error('CCTV redirect error', ['portal' => $portal, 'error' => $e->getMessage()]);
        }

        return redirect()->away($config['login']);
    }
}

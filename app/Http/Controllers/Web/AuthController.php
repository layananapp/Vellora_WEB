<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->has('role')) {

            if (session('role') === 'seller') {

                return redirect()->route('seller.dashboard');

            }

            if (session('role') === 'admin') {

                return redirect()->route('admin.dashboard');

            }

            return redirect()->route('landing');

        }

        return view('landing.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:seller,admin'],
        ]);

        $key =
            Str::lower($request->email)
            . '|' .
            $request->ip();

        $maxAttempts = 5;

        if (
            RateLimiter::tooManyAttempts(
                $key,
                $maxAttempts
            )
        ) {

            $seconds =
                RateLimiter::availableIn($key);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terlalu banyak percobaan login'
                )
                ->with(
                    'retry_after',
                    ceil($seconds / 60)
                )
                ->with(
                    'login_attempt',
                    $maxAttempts
                );

        }

        $response = Http::post(
            "{$this->apiUrl}/api/auth/login",
            [
                'email' =>
                    $request->email,

                'password' =>
                    $request->password,
            ]
        );

        if ($response->failed()) {

            RateLimiter::hit(
                $key,
                300
            );

            $attempts =
                RateLimiter::attempts($key);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Email atau password salah'
                )
                ->with(
                    'login_attempt',
                    $attempts
                )
                ->with(
                    'remaining_attempt',
                    $maxAttempts - $attempts
                );

        }

        RateLimiter::clear($key);

        $data = $response->json();

        $user = $data['data']['user'];

        $selectedRole =
            $request->role;

        $actualRole =
            $user['role'];

        if ($actualRole === 'buyer') {

            session([

                'token' =>
                    $data['data']['token'],

                'user' =>
                    $user,

                'role' =>
                    $actualRole,

                'token_expires_at' =>
                    $data['data']['expires_at'],

            ]);

            return redirect()
                ->route('landing');

        }

        if (
            $actualRole === 'seller'
            &&
            $selectedRole === 'admin'
        ) {

            return back()
                ->withInput()
                ->with(
                    'switchRole',
                    'seller'
                )
                ->with(
                    'error',
                    'Akun ini adalah akun seller'
                );

        }

        if (
            $actualRole === 'admin'
            &&
            $selectedRole === 'seller'
        ) {

            return back()
                ->withInput()
                ->with(
                    'switchRole',
                    'admin'
                )
                ->with(
                    'error',
                    'Akun ini adalah akun admin'
                );

        }

        session([

            'token' =>
                $data['data']['token'],

            'user' =>
                $user,

            'role' =>
                $actualRole,

            'token_expires_at' =>
                $data['data']['expires_at'],

        ]);

        if ($actualRole === 'admin') {

            return redirect()
                ->route('admin.dashboard');

        }

        if ($actualRole === 'seller') {

            return redirect()
                ->route('seller.dashboard');

        }

        return redirect()
            ->route('landing');
    }

    public function logout()
    {
        session()->flush();

        return redirect()->route('landing');
    }

    public function lupaPassword()
    {
        return view('landing.auth.lupa-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $response = Http::post("{$this->apiUrl}/api/auth/forgot-password", [
            'email' => $request->email,
        ]);

        if ($response->failed()) {
            $errData = $response->json();
            $message = $errData['message'] ?? 'Email tidak terdaftar atau terjadi kesalahan.';
            return back()->withInput()->with('error', $message);
        }

        session(['reset_email' => $request->email]);

        return redirect()->route('verifikasi-kode')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function verifikasiKode()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('lupa-password')->with('error', 'Silakan masukkan email Anda terlebih dahulu.');
        }

        return view('landing.auth.verifikasi-kode');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:4'],
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('lupa-password')->with('error', 'Sesi telah habis, silakan masukkan email kembali.');
        }

        $response = Http::post("{$this->apiUrl}/api/auth/verify-otp", [
            'email' => $email,
            'otp' => $request->otp,
        ]);

        if ($response->failed()) {
            $errData = $response->json();
            $message = $errData['message'] ?? 'Kode OTP salah atau sudah kedaluwarsa.';
            return back()->with('error', $message);
        }

        session(['reset_otp' => $request->otp]);

        return redirect()->route('reset-password')->with('success', 'OTP valid, silakan buat password baru.');
    }

    public function resetPassword()
    {
        if (!session()->has('reset_email') || !session()->has('reset_otp')) {
            return redirect()->route('lupa-password')->with('error', 'Sesi tidak valid, silakan ulangi proses.');
        }

        return view('landing.auth.reset-password');
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $email = session('reset_email');
        $otp = session('reset_otp');

        if (!$email || !$otp) {
            return redirect()->route('lupa-password')->with('error', 'Sesi telah habis, silakan ulangi proses.');
        }

        $response = Http::post("{$this->apiUrl}/api/auth/reset-password", [
            'email' => $email,
            'otp' => $otp,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->failed()) {
            $errData = $response->json();
            $message = $errData['message'] ?? 'Gagal memperbarui password. Silakan coba lagi.';
            return back()->with('error', $message);
        }

        session()->forget(['reset_email', 'reset_otp']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah, silakan login.');
    }
}
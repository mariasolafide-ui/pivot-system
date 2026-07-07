<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman form request reset password.
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Kirim tautan reset password ke email admin.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.exists'   => 'Email tidak terdaftar sebagai admin.',
        ]);

        // Gunakan broker 'admins' sesuai guard admin
        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Tautan reset password telah dikirim ke email Anda.');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
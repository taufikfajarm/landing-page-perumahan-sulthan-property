<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Silent deflection untuk anti-bot honeypot
        if ($request->filled('b_hp_field')) {
            return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim.');
        }

        // 2. Normalisasi nomor WhatsApp
        $rawPhone = (string) $request->input('phone', '');
        $cleanedPhone = preg_replace('/[^0-9+]/', '', trim($rawPhone));
        if (str_starts_with($cleanedPhone, '+62')) {
            $cleanedPhone = '0' . substr($cleanedPhone, 3);
        } elseif (str_starts_with($cleanedPhone, '62')) {
            $cleanedPhone = '0' . substr($cleanedPhone, 2);
        }

        // Merge nomor yang sudah dinormalisasi kembali ke request sebelum validasi
        $request->merge(['phone' => $cleanedPhone]);

        // 3. Validasi data
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[\pL\s\.\'\-]+$/u',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^08[1-9][0-9]{7,11}$/',
                function ($attribute, $value, $fail) {
                    // Cek pola angka dummy berulang (misal: 081111111111, 089999999999)
                    $suffix = substr($value, 2);
                    if (strlen($suffix) >= 8 && count(array_unique(str_split($suffix))) <= 1) {
                        $fail('Nomor WhatsApp tidak valid (terdeteksi angka berulang/palsu).');
                    }
                },
            ],
            'message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
            'name.regex' => 'Nama lengkap hanya boleh berisi huruf dan tanda baca umum.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Format nomor WhatsApp tidak valid. Gunakan nomor seluler Indonesia aktif (contoh: 081234567890).',
            'message.max' => 'Pesan maksimal 1000 karakter.',
        ]);

        // Default pesan jika pengguna tidak mengisi textarea pesan
        if (empty(trim((string) ($validated['message'] ?? '')))) {
            $validated['message'] = 'Permintaan E-Brosur dan informasi perumahan Sulthan Property.';
        }

        $contact = Contact::create($validated);

        // Kirim notifikasi realtime ke email administrator
        try {
            $recipientEmail = config('mail.notification_recipient', env('CONTACT_NOTIFICATION_EMAIL', 'taufikfajar093@gmail.com'));
            if (! empty($recipientEmail)) {
                \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(new \App\Mail\NewContactNotificationMail($contact));
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim notifikasi email kontak baru: ' . $e->getMessage());
        }

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim.');
    }
}


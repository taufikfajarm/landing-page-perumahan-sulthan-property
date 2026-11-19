<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak Baru</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    @php
        $rawPhone = preg_replace('/[^0-9]/', '', (string)$contact->phone);
        if (str_starts_with($rawPhone, '0')) {
            $cleanWa = '62' . substr($rawPhone, 1);
        } elseif (str_starts_with($rawPhone, '62')) {
            $cleanWa = $rawPhone;
        } else {
            $cleanWa = '62' . $rawPhone;
        }
        $waUrl = 'https://wa.me/' . $cleanWa . '?text=' . urlencode('Halo ' . $contact->name . ', terima kasih telah menghubungi Sulthan Property. Mengenai pesan yang Anda sampaikan, ada yang bisa kami bantu?');
        $adminUrl = url('/dashboard/contacts');
    @endphp

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px border #e2e8f0;" cellspacing="0" cellpadding="0">
                    
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); padding: 32px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">
                                SULTHAN PROPERTY
                            </h1>
                            <p style="margin: 6px 0 0 0; color: #e0f2fe; font-size: 14px;">
                                Notifikasi Pesan Masuk Website
                            </p>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 32px 30px;">
                            <div style="display: inline-block; background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 9999px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                                ✉️ Pesan Baru Diterima
                            </div>

                            <p style="margin: 0 0 20px 0; font-size: 15px; color: #334155;">
                                Halo <strong>Taufik Fajar</strong>, ada pesan atau pertanyaan baru yang dikirimkan oleh pengunjung melalui formulir website Sulthan Property:
                            </p>

                            {{-- Data Box --}}
                            <table role="presentation" width="100%" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 25px;" cellspacing="0" cellpadding="12">
                                <tr>
                                    <td width="30%" style="font-size: 13px; color: #64748b; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Nama Pengirim</td>
                                    <td style="font-size: 14px; color: #0f172a; font-weight: 700; border-bottom: 1px solid #f1f5f9;">{{ $contact->name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px; color: #64748b; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Nomor WhatsApp</td>
                                    <td style="font-size: 14px; color: #0f172a; font-weight: 700; border-bottom: 1px solid #f1f5f9;">
                                        <a href="{{ $waUrl }}" target="_blank" style="color: #059669; text-decoration: none; font-weight: 700;">
                                            {{ $contact->phone }} (Klik Chat WA ↗)
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px; color: #64748b; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Alamat Email</td>
                                    <td style="font-size: 14px; color: #0f172a; border-bottom: 1px solid #f1f5f9;">
                                        <a href="mailto:{{ $contact->email }}" style="color: #0284c7; text-decoration: none;">
                                            {{ $contact->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px; color: #64748b; font-weight: 600;">Waktu Masuk</td>
                                    <td style="font-size: 13px; color: #475569;">
                                        {{ $contact->created_at ? $contact->created_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB
                                    </td>
                                </tr>
                            </table>

                            {{-- Isi Pesan --}}
                            <div style="margin-bottom: 28px;">
                                <span style="display: block; font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">
                                    Isi Pesan:
                                </span>
                                <div style="background-color: #ffffff; border-left: 4px solid #0284c7; border-top: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; border-radius: 0 10px 10px 0; padding: 16px; font-size: 14px; color: #1e293b; line-height: 1.6; white-space: pre-line;">
                                    {{ $contact->message }}
                                </div>
                            </div>

                            {{-- CTA Buttons --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 10px;">
                                        <a href="{{ $waUrl }}" target="_blank" style="display: inline-block; background-color: #16a34a; color: #ffffff; font-size: 14px; font-weight: 700; text-decoration: none; padding: 14px 28px; border-radius: 10px; box-shadow: 0 2px 8px rgba(22, 163, 74, 0.3);">
                                            💬 Balas via WhatsApp Langsung
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <a href="{{ $adminUrl }}" target="_blank" style="display: inline-block; color: #64748b; font-size: 13px; font-weight: 600; text-decoration: underline; padding: 6px;">
                                            Buka di Dashboard Admin
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 30px; text-align: center; font-size: 12px; color: #94a3b8;">
                            Email ini dikirim otomatis oleh sistem website <strong>Sulthan Property</strong>.<br>
                            Anda menerima notifikasi ini karena email Anda terdaftar sebagai administrator penerima pesan masuk.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

<?php

namespace Tests\Feature;

use App\Filament\Resources\Contacts\ContactResource;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactNotificationBadgeTest extends TestCase
{
    public function test_navigation_badge_shows_unread_count_and_clears_when_viewed(): void
    {
        // Bersihkan data kontak sementara untuk isolasi test
        Contact::query()->delete();

        // 1. Kondisi awal: tidak ada kontak unread -> badge harus null
        $this->assertNull(ContactResource::getNavigationBadge());

        // 2. Ada pesan baru masuk dari frontend
        $contact1 = Contact::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567891',
            'message' => 'Mohon info perumahan Almaz',
            'is_read' => false,
        ]);

        $this->assertEquals('1', ContactResource::getNavigationBadge());
        $this->assertEquals('danger', ContactResource::getNavigationBadgeColor());
        $this->assertEquals('Pesan belum dilihat', ContactResource::getNavigationBadgeTooltip());

        // 3. Ada pesan kedua masuk
        $contact2 = Contact::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@example.com',
            'phone' => '081234567892',
            'message' => 'Apakah promo BPHTB masih berlaku?',
            'is_read' => false,
        ]);

        $this->assertEquals('2', ContactResource::getNavigationBadge());

        // 4. Admin melihat pesan pertama (dilihat)
        $contact1->markAsRead();
        $this->assertEquals('1', ContactResource::getNavigationBadge());

        // 5. Admin melihat pesan kedua (semua sudah dilihat)
        $contact2->markAsRead();
        $this->assertNull(ContactResource::getNavigationBadge());
    }

    public function test_contact_form_submission_creates_unread_message(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Ahmad Dani',
            'email' => 'ahmad@example.com',
            'phone' => '081234567899',
            'message' => 'Saya tertarik dengan unit subsidi',
        ]);

        $response->assertSessionHas('success');

        $contact = Contact::where('email', 'ahmad@example.com')->first();
        $this->assertNotNull($contact);
        $this->assertFalse($contact->is_read);
    }
}


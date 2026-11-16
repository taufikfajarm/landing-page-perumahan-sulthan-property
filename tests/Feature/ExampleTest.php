<?php

test('home page returns successful response', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('housing index returns successful response', function () {
    $response = $this->get('/perumahan');
    $response->assertStatus(200);
});

test('blog index returns successful response', function () {
    $response = $this->get('/blog');
    $response->assertStatus(200);
});

test('marketing index returns successful response', function () {
    $response = $this->get('/marketing');
    $response->assertStatus(200);
});

test('about page returns successful response', function () {
    $response = $this->get('/about');
    $response->assertStatus(200);
});

test('contact form stores message and redirects', function () {
    $response = $this->post('/contact', [
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'phone' => '+62 812-3456-7890',
        'message' => 'Halo, saya tertarik dengan proyek perumahan.',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('contacts', [
        'email' => 'budi@example.com',
        'phone' => '081234567890',
    ]);
});

test('contact form rejects invalid or random phone numbers', function () {
    $invalidPhones = [
        '12345',
        'abcdefghij',
        '08012345678', // prefix 080 bukan seluler
        '081111111111', // digit berulang fake
        '0217654321', // telepon rumah Jakarta, bukan WA seluler
    ];

    foreach ($invalidPhones as $phone) {
        $response = $this->post('/contact', [
            'name' => 'User Test',
            'email' => 'usertest@example.com',
            'phone' => $phone,
            'message' => 'Test pesan',
        ]);

        $response->assertSessionHasErrors('phone');
    }
});

test('contact form honeypot silently deflects bots', function () {
    $response = $this->post('/contact', [
        'name' => 'Bot Spam',
        'email' => 'spambot@example.com',
        'phone' => '081234567890',
        'message' => 'Spam link here',
        'b_hp_field' => 'http://spam-link.com',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('contacts', [
        'email' => 'spambot@example.com',
    ]);
});

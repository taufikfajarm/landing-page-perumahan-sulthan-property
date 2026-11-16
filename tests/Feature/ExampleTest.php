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
        'phone' => '081234567890',
        'message' => 'Halo, saya tertarik dengan proyek perumahan.',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('contacts', [
        'email' => 'budi@example.com',
    ]);
});

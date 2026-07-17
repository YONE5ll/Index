<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('signup endpoint accepts a valid payload', function () {
    $response = $this->postJson('/api/signup', [
        'name' => 'Test User',
        'email' => 'tester@example.com',
        'password' => 'secret123',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('message', 'User registered successfully!');
});

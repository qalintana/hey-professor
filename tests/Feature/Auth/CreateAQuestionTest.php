<?php
use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

test('Não deve criar pergunta com mais de 255 caracteres', function () {

    // preparar
    $user = User::factory()->create();
    actingAs($user);

    // agir
    $request = post(route('question.store'), [
        'question' => str_repeat("*", 260) . '?',
    ]);

    // verificar
    $request->assertRedirect(route('dashboard'));

    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat("*", 260) . '?']);

});

test('should ckeck if ends with question mark ?', function () {
    $user = User::factory()->create();
    actingAs($user);

    // agir
    $request = post(route('question.store'), [
        'question' => str_repeat("*", 10),
    ]);

    // verificar
    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is question? It is missing the question mark in the end',
    ]);
    assertDatabaseCount('questions', 0);
});

test('should have at least 10 characters', function () {
    // preparar
    $user = User::factory()->create();
    actingAs($user);

    // agir
    $request = post(route('question.store'), [
        'question' => str_repeat("*", 8) . '?',
    ]);

    // verificar
    $request->assertSessionHasErrors([
        'question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question']),
    ]);
    assertDatabaseCount('questions', 0);

});

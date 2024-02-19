<?php
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

<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {
    // Arrange -> Criar algumas perguntas
    $user     = User::factory()->create();
    $question = Question::factory()->count(5)->create();

    actingAs($user);

    // Act -> acessar a rota
    $response = get(route('dashboard'));

    // Assert -> verificar se a lista de perguntas está sendo mostrada
    /** @var Question $q */
    foreach ($question as $q) {
        $response->assertSee($q->question);
    }
});

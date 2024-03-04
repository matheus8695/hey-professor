<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

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

it('should paginate the result', function () {
    $user = User::factory()->create();
    Question::factory()->count(20)->create();

    actingAs($user);

    get(route('dashboard'))
        ->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);

});

it('should order by like and unlike, most like question should be at the top, most unliked questions should be in the bottom', function () {
    $user       = User::factory()->create();
    $secondUSer = User::factory()->create();

    Question::factory()->count(5)->create();

    $mostLikedQuestion = Question::find(3);
    $user->like($mostLikedQuestion);

    $mostUnlikedQuestion = Question::find(1);
    $secondUSer->unlike($mostUnlikedQuestion);

    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {
            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(1);

            return true;
        });
});

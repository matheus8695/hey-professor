<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to open a question to edit', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))
        ->assertSuccessful();
});

it('should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $question))
        ->assertViewIs('question.edit');
});

it('should make sure that only question with status DRAFT can be edited', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $draftQuestion    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('question.edit', $questionNotDraft))->assertForbidden();
    get(route('question.edit', $draftQuestion))->assertSuccessful();
});

it('should make sure that only the person who has created the question can edit the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create([
        'draft'      => true,
        'created_by' => $rightUser->id,
    ]);

    actingAs($wrongUser);
    get(route('question.edit', $question))
        ->assertForbidden();

    actingAs($rightUser);
    get(route('question.edit', $question))
        ->assertSuccessful();
});

<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to update question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('Updated Question?');
});

it('should make sure that only question with status DRAFT can be updated', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $draftQuestion    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $questionNotDraft))->assertForbidden();
    put(route('question.update', $draftQuestion), ['question' => 'new Question'])->assertRedirect();
});

it('should make sure that only the person who has created the question can update the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create([
        'draft'      => true,
        'created_by' => $rightUser->id,
    ]);

    actingAs($wrongUser);
    put(route('question.update', $question))
        ->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), ['question' => 'new Question'])
        ->assertRedirect();
});

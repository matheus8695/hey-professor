<?php

use App\Models\Question;

use function Pest\Laravel\{artisan, assertDatabaseMissing, assertSoftDeleted};

it('should prune records deleted more than 1 month', function () {
    $question = Question::factory()->create(['deleted_at' => now()->subMonths(2)]);
    assertSoftDeleted('questions', ['id' => $question->id]);

    artisan('model:prune');

    assertDatabaseMissing('questions', ['id' => $question->id]);
});

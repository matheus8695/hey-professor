<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('question.index', [
            'questions' => user()->questions,
        ]);
    }
    public function store(): RedirectResponse
    {
        request()->validate([
            "question" => [
                "required",
                "min:10",
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value[strlen($value) - 1] != "?") {
                        $fail("Are you sure that is a question? It is missing the question mark in the end.");
                    }
                },
            ],
        ]);

        user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return back();
    }
}

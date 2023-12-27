<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Request};

class UnlikeController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        user()->unlike($question);

        return back();
    }
}

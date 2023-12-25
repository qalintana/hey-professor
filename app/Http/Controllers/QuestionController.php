<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        Question::query()->create(
            request()->validate(
                ['question' => 'required']
            )
        );

        return to_route('dashboard');
    }
}

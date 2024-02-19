<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        $attributes = request()->validate(
            ['question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if ($value[strlen($value) - 1] != "?") {
                        $fail('Are you sure that is question? It is missing the question mark in the end');
                    }
                },
            ]]
        );

        Question::query()->create(
            $attributes
        );

        return to_route('dashboard');
    }
}

<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use App\UseCases\AcceptFeedbackData;
use App\UseCases\FeedbackUseCases;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    public function store(FeedbackStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $feedback = app(FeedbackUseCases::class)->acceptFeedback(new AcceptFeedbackData(
            title: $data['title'],
            description: $data['description'],
        ));

        return response()->json([
            'title' => $feedback->title,
            'description' => $feedback->description
        ], 201);
    }
}

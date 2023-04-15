<?php


namespace App\UseCases;


use App\Models\Feedback;

class FeedbackUseCases
{
    public function acceptFeedback(AcceptFeedbackData $data): Feedback
    {
        $feedback = Feedback::make();
        $feedback->title = $data->title;
        $feedback->description = $data->description;
        $feedback->save();
        $feedback->refresh();

        return $feedback;
    }
}

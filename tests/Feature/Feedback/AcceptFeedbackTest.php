<?php

namespace Tests\Feature\Feedback;

use App\UseCases\AcceptFeedbackData;
use App\UseCases\FeedbackUseCases;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AcceptFeedbackTest extends TestCase
{
    use DatabaseTransactions;

    public function test_accept()
    {
        $feedback = app(FeedbackUseCases::class)->acceptFeedback(new AcceptFeedbackData(
            title: 'Test title',
            description: 'Test description',
        ));

        $this->assertEquals('Test title', $feedback->title);
        $this->assertEquals('Test description', $feedback->description);
    }

    public function test_accept_fromApi()
    {
        $response = $this->postJson(route('api.feedback.store'), [
            'title' => 'Test title',
            'description' => 'Test description',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'title' => 'Test title',
            'description' => 'Test description',
        ]);
    }
}

<?php


namespace App\UseCases;


class AcceptFeedbackData
{
    public function __construct(
        public string $title,
        public string $description,
    ) {}
}

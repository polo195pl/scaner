<?php

namespace App\Service;

use App\Entity\User;
use App\Rabbit\MessagingProducer;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageService
{
    private $messagingProducer;

    public function __construct(MessagingProducer $messagingProducer)
    {
        $this->messagingProducer = $messagingProducer;
    }

    public function createMessage(User $user): JsonResponse
    {
        $this->messagingProducer->publish($user);

        return new JsonResponse(['msg' => 'Success.']);
    }
}
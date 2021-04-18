<?php

namespace App\Rabbit;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use OldSound\RabbitMqBundle\RabbitMq\Producer;

class MessagingProducer extends Producer
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function publish($msgBody, $routingKey = '', $additionalProperties = array(), ?array $headers = null)
    {
        $this->em->persist($msgBody);
        $this->em->flush();
    }
}
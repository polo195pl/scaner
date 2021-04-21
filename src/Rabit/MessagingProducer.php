<?php
namespace App\Rabbit;

use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class MessagingProducer extends \OldSound\RabbitMqBundle\RabbitMq\Producer
{
    public function publish($msgBody, $routingKey = '', $additionalProperties = array(), ?array $headers = null)
    {
        $em = new EntityManagerInterface;
        $em->persist($msgBody);
        $em->flush();
    }
}
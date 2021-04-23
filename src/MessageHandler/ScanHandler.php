<?php

namespace App\MessageHandler;

use App\Entity\Scan as EntityScan;
use App\Message\Scan;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ScanHandler implements MessageHandlerInterface
{
    public function __invoke(Scan $message)
    {
        $scan = new EntityScan;
        $scan->setCreatedAt($message->getCreatedAt());
        $scan->setCode($message->getCode());
        $em = new EntityManagerInterface;
        $user = $em->getRepository(User::class)->findOneBy(['id' => $message->getUserId()]);

        $image_parts = explode(";base64,", $message->getPhoto());
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = 'public/uploads/' . uniqid() . '.jpg';
        file_put_contents($file, $image_base64);

        $scan->setUserId($user);
        $scan->setPhoto($file);
        $em->persist($scan);
        $em->flush();
    }
}

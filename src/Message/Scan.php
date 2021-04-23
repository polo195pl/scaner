<?php

namespace App\Message;

use DateTimeInterface;

final class Scan
{
    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */

    private $userId;
    private $createdAt;
    private $code;
    private $photo;

    public function __construct(DateTimeInterface $createdAt, string $code, int $userId, string $photo)
    {
        $this->userId = $userId;
        $this->createdAt = $createdAt;
        $this->code = $code;
        $this->photo = $photo;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }
    
    public function getUserId(): int
    {
        return $this->userId;
    }
}

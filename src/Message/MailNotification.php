<?php

namespace App\Message;

/**
 * Model avec juste des getters
 * Class MailNotification
 * @package App\Message
 */
class MailNotification
{
    private string $description;
    private int $id;
    private string $from;
    
    /**
     * MailNotification constructor.
     * @param string $description
     * @param int $id
     * @param string $from
     */
    public function __construct(string $description, int $id, string $from)
    {
        $this->description = $description;
        $this->id = $id;
        $this->from = $from;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }
    
    
    
}
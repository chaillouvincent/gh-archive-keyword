<?php

declare(strict_types=1);

namespace App\Project\Application\DTO;

/**
 * GithubEventDTO
 */
class GithubEventDTO
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var integer
     */
    public int $githubEventId;

    /**
     * @var string
     */
    public string $eventType;

    /**
     * @var \DateTime
     */
    public \DateTime $createdAt;

    /**
     * @var array
     */
    public array $payload;

    /**
     * @var string
     */
    public string $comment;

    /**
     * Get the id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setting the id
     * @param int $id
     * @return GithubEventDTO
     */
    public function setId(int $id): GithubEventDTO
    {
        $this->id = $id;

        return $this;
    }
}

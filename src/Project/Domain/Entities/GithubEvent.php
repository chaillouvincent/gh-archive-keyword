<?php

declare(strict_types=1);


namespace App\Project\Domain\Entities;

/**
 * GithubEvent
 */
class GithubEvent
{
    public static $allowedEventTypes = array('PullRequestEvent', 'CommitCommentEvent', 'IssueCommentEvent', 'PullRequestReviewCommentEvent');

    public static $typePullRequest = 'PullRequestEvent';
    public static $typeCommitComment = 'CommitCommentEvent';
    public static $typeIssueComment = 'IssueCommentEvent';
    public static $typePullRequestReviewComment = 'PullRequestReviewCommentEvent';

    /**
     * @var integer
     */
    private int $id;

    /**
     * @var integer
     */
    private int $gitubEventId;

    /**
     * @var string
     */
    private string $eventType;

    /**
     * @var \DateTime
     */
    private \DateTime $createdAt;

    /**
     * @var array
     */
    private array $payload;

    /**
     * @var string
     */
    private string $comment;


    /**
     * Get the value of id
     *
     * @return  integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of githubEventId
     *
     * @return  integer
     */
    public function getGitubEventId(): int
    {
        return $this->gitubEventId;
    }

    /**
     * Set the value of gitubEvenId
     *
     * @param  integer  $gitubEvenId
     *
     * @return  self
     */
    public function setGitubEventId($gitubEventId): GithubEvent
    {
        $this->gitubEventId = $gitubEventId;

        return $this;
    }

    /**
     * Get the value of eventType
     *
     * @return  string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * Set the value of eventType
     *
     * @param  string  $eventType
     *
     * @return  self
     */
    public function setType(string $eventType): GithubEvent
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime  $createdAt
     *
     * @return  self
     */
    public function setCreatedAt(\DateTime $createdAt): GithubEvent
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of payload
     *
     * @return  []
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * Set the value of payload
     *
     * @param  array  $payload
     *
     * @return  self
     */
    public function setPayload(array $payload): GithubEvent
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get the value of comment
     *
     * @return  string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @param  string  $comment
     *
     * @return  self
     */
    public function setComment(string $comment): GithubEvent
    {
        $this->comment = $comment;

        return $this;
    }
}

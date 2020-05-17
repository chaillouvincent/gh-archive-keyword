<?php

declare(strict_types=1);


namespace App\Project\Application\DTO;

/**
 * GithubEventsStatsDTO
 */
class GithubEventsStatsDTO
{
    /**
     * @var integer
     */
    public int $numberOfCommitEvents;

    /**
     * @var integer
     */
    public int $numberOfPullRequestEvents;

    /**
     * @var integer
     */
    public int $numberOfIssueEvents;

    /**
     * @var integer
     */
    public int $numberOfComments;

    /**
     * @var \IteratorAggregate
     */
    public \IteratorAggregate $eventList;

    public function setEventList(\IteratorAggregate $eventList): GithubEventsStatsDTO
    {
        $this->eventList = $eventList;

        return $this;
    }
}

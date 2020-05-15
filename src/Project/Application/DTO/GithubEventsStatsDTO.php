<?php

declare(strict_types=1);


namespace App\Project\Application\DTO;

/**
 * GithubEvent
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
     * @var \Collection
     */
    public \Collection $eventList;

    public function setEventList(\Collection $eventList): GithubEventsStatsDTO
    {
        $this->eventList = $eventList;

        return $this;
    }
}

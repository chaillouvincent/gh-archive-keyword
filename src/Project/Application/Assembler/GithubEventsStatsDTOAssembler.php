<?php

declare(strict_types=1);

namespace App\Project\Application\Assembler;

use App\Project\Application\DTO\GithubEventsStatsDTO;


class GithubEventsStatsDTOAssembler
{
    /**
     * Function used to build a GithubEventsStatsDTO object
     *
     * @param array $data
     */
    public function toDTO(array $data): GithubEventsStatsDTO
    {
        $githubEventsStatsDTO = new GithubEventsStatsDTO();
        $githubEventsStatsDTO->numberOfCommitEvents = $data['numberOfCommitEvents'];
        $githubEventsStatsDTO->numberOfPullRequestEvents = $data['numberOfPullRequestEvents'];
        $githubEventsStatsDTO->numberOfIssueEvents = $data['numberOfIssueEvents'];
        $githubEventsStatsDTO->numberOfComments = $data['numberOfComments'];
        $githubEventsStatsDTO->eventList = $data['eventList'];

        return $githubEventsStatsDTO;
    }
}

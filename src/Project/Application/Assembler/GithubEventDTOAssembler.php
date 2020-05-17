<?php

declare(strict_types=1);

namespace App\Project\Application\Assembler;

use App\Project\Application\DTO\GithubEventDTO;
use App\Project\Domain\Entities\GithubEvent;


class GithubEventDTOAssembler
{
    /**
     * Function used to build a GithubEventDTO object
     *
     * @param GithubEvent $githubEvent
     */
    public function toDTO(GithubEvent $githubEvent): GithubEventDTO
    {
        $githubEventDTO = new GithubEventDTO();
        $githubEventDTO->setId($githubEvent->getId());
        $githubEventDTO->githubEventId = $githubEvent->getGitubEventId();
        $githubEventDTO->eventType = $githubEvent->getEventType();
        $githubEventDTO->createdAt = $githubEvent->getCreatedAt();
        $githubEventDTO->payload = $githubEvent->getPayload();
        $githubEventDTO->comment = $githubEvent->getComment();

        return $githubEventDTO;
    }


}

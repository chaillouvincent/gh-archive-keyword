<?php

declare(strict_types=1);

namespace App\Project\Application\Service;
use App\Project\Application\DTO\GithubEventDTO;
use App\Project\Application\Assembler\GithubEventDTOAssembler;
use App\Project\Infrastructure\Persistence\Doctrine\Repositories\GithubEventRepository;


class GithubEventService
{
    private $repo;
    private $assembler;

    public function __construct(GithubEventRepository $repo, GithubEventDTOAssembler $assembler)
    {
        $this->repo = $repo;
        $this->assembler = $assembler;
    }

    /**
     * Function use to call the creation of githubEventDTO objet buildt by the assembler
     *
     * @param int $eventId
     * @return GithubEventDTO
     */
    public function getGithubEventDTO(int $eventId): GithubEventDTO
    {
        $githubEvent = $this->repo->getEventDetails($eventId);

        return $this->assembler->toDTO($githubEvent);
    }
}

<?php

declare(strict_types=1);

namespace App\Project\Application\Service;
use \App\Project\Application\DTO\GithubEventsStatsDTO;
use \App\Project\Application\Assembler\GithubEventsStatsDTOAssembler;
use \App\Project\Infrastructure\Persistence\Doctrine\Repositories\GithubEventRepository;


class GithubEventsStatsService
{
    private $repo;
    private $assembler;

    public function __construct(GithubEventRepository $repo, GithubEventsStatsDTOAssembler $assembler)
    {
        $this->repo = $repo;
        $this->assembler = $assembler;
    }

    /**
     * Function use to call the creation of GithubEventsStatsDTO objet buildt by the assembler
     *
     * @param string $keyword
     * @param \DateTime $date
     * @param int $currentPage
     * @param int $elementsPerPage
     * @return GithubEventsStatsDTO
     */
    public function getGihubEventsStatsDTO(string $keyword, \DateTime $date, int $currentPage, $elementsPerPage): GithubEventsStatsDTO
    {
        if (empty($keyword) || empty($date)) {

            throw new \InvalidArgumentException('keyword and date parameters must be defined');
        }

        $numberOfCommitEvents = $this->repo->countCommitsByKeywordAndDate($keyword, $date);
        $numberOfPullRequestEvents = $this->repo->countPullRequestsByKeywordAndDate($keyword, $date);
        $numberOfIssueEvents = $this->repo->countIssuesByKeywordAndDate($keyword, $date);
        $numberOfComments = $this->repo->countCommentsByKeywordAndDate($keyword, $date);
        $eventList = $this->repo->findEventsByKeywordAndDate($keyword, $date, $currentPage, $elementsPerPage);

        $params = [
            numberOfCommitEvents => $numberOfCommitEvents,
            numberOfPullRequestEvents => $numberOfPullRequestEvents,
            numberOfIssueEvents => $numberOfIssueEvents,
            numberOfComments => $numberOfComments,
            eventList => $eventList
        ];

        return $this->assembler->toDTO($params);
    }
}

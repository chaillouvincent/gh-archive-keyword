<?php
declare(strict_types=1);

namespace  App\Project\Domain\Repositories;
use App\Project\Domain\Entities\GithubEvent;

interface GithubEventRepositoryInterface
{
    /**
     * @param int $id
     * @throws App\Project\Domain\Exceptions\GithubEventNotFoundException
     *
     * @return \App\Project\Domain\Entities\GithubEvent
     */
    public function getEventDetails(int $id): GithubEvent;

    /**
     * Persist a new githubEvent in database
     *
     * @param GithubEvent $gitubEvent
     * @return void
     */
    public function add(GithubEvent $gitubEvent): void;

    /**
     * Get all event which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @param int $currentPage
     * @param int $elementsPerPage
     * @return \IteratorAggregate
     */
    public function findEventsByKeywordAndDate(string $keyword, \DateTime $date, int $currentPage, int $elementsPerPage): \IteratorAggregate;

    /**
     * Count all commit events type which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countCommitsByKeywordAndDate(string $keyword, \DateTime $date): int;

    /**
     * Count all pullrequest events type which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countPullRequestsByKeywordAndDate(string $keyword, \DateTime $date): int;

    /**
     * Count all issuecomment events type which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countIssuesByKeywordAndDate(string $keyword, \DateTime $date): int;

    /**
     * Count all comments from event which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countCommentsByKeywordAndDate(string $keyword, \DateTime $date): int;
}

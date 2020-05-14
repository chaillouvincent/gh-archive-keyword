<?php
declare(strict_types=1);

namespace  App\Project\Domain\Repositories;
use App\Project\Domain\Entities\GithubEvent;

interface GithubEventRepositoryInterface
{
    /**
     * @param int $id
     * @return \App\Project\Domain\Entities\GithubEvent
     */
    public function getEventDetails(int $id): GithubEvent;

    public function add(GithubEvent $gitubEvent): void;
}
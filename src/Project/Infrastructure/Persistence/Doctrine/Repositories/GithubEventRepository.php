<?php
declare(strict_types=1);

namespace  App\Project\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use App\Project\Domain\Repositories\GithubEventRepositoryInterface;
use App\Project\Domain\Entities\GithubEvent;

final class GithubEventRepository implements GithubEventRepositoryInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return \App\Project\Domain\Entities\GithubEvent
     */
    public function getEventDetails(int $id): GithubEvent
    {
        $qb = $this->em->createQueryBuilder()
            ->select('e')
            ->from("ProjectDomainEntities:GithubEvent", 'e')
            ->where('e.id = :id');

        $qb->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param GithubEvent $gitubEvent
     * @return void
     */
    public function add(GithubEvent $gitubEvent): void
    {
        $this->em->persist($trip);
        $this->em->flush();
    }
} 
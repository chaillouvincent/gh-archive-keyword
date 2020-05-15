<?php
declare(strict_types=1);

namespace  App\Project\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Project\Domain\Repositories\GithubEventRepositoryInterface;
use App\Project\Domain\Entities\GithubEvent;
use App\Project\Domain\Exceptions\GithubEventNotFoundException;

final class GithubEventRepository implements GithubEventRepositoryInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @throws App\Project\Domain\Exceptions\GithubEventNotFoundException
     *
     * @return \App\Project\Domain\Entities\GithubEvent
     */
    public function getEventDetails(int $id): GithubEvent
    {
        $qb = $this->em->createQueryBuilder()
            ->select('e')
            ->from("ProjectDomainEntities:GithubEvent", 'e')
            ->where('e.id = :id');

        $qb->setParameter('id', $id);

        $result =  $qb->getQuery()->getOneOrNullResult();

        if (is_null($result)) {

           throw new GithubEventNotFoundException();
        }

        return $result;
    }

    /**
     * Persist a new githubEvent in database
     *
     * @param GithubEvent $gitubEvent
     * @return void
     */
    public function add(GithubEvent $gitubEvent): void
    {
        $this->em->persist($trip);
        $this->em->flush();
    }

    /**
     * Get all event which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @param int $currentPage
     * @param int $elementsPerPage
     *
     * @return \IteratorAggregate
     */
    public function findEventsByKeywordAndDate(string $keyword, \DateTime $date, int $currentPage, int $elementsPerPage): \IteratorAggregate
    {
        if ($currentPage < 1) {
            throw new \InvalidArgumentException('The asked page does not exists.');
        }

        $qb = $this->em->createQueryBuilder()
            ->select('e')
            ->from("ProjectDomainEntities:GithubEvent", 'e')
            ->where('e.createdAt = :createdAt')
            ->andWhere('e.comment LIKE :keyword')
            ->orderBy('e.createdAt', 'ASC');

        $qb->setParameter('createdAt', $date);
        $qb->setParameter('keyword', '%' . $keyword . '%');

        $query = $qb->getQuery();

        $firstResult = ($currentPage - 1) * $elementsPerPage;
        $query->setFirstResult($firstResult)->setMaxResults($elementsPerPage);
        $paginator = new Paginator($query);

        if (($paginator->count() <= $firstResult) && $currentPage != 1) {

            throw new \InvalidArgumentException('The asked page does not exists.');
        }

        return $paginator;
    }

    /**
     * Count all commit events type which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countCommitsByKeywordAndDate(string $keyword, \DateTime $date): int
    {
        $qb = $this->em->createQueryBuilder('e')
            ->select('count(e.id)')
            ->where('e.createdAt = :createdAt')
            ->andWhere('e.comment LIKE :keyword')
            ->andWhere('e.type = :type');

        $qb->setParameter('createdAt', $date);
        $qb->setParameter('keyword', '%' . $keyword . '%');
        $qb->setParameter('type', GithubEvent::$typeCommitComment);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Count all pullrequest events type which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countPullRequestsByKeywordAndDate(string $keyword, \DateTime $date): int
    {
        $qb = $this->em->createQueryBuilder('e')
            ->select('count(e.id)')
            ->where('e.createdAt = :createdAt')
            ->andWhere('e.comment LIKE :keyword')
            ->andWhere('e.type = :type');

        $qb->setParameter('createdAt', $date);
        $qb->setParameter('keyword', '%' . $keyword . '%');
        $qb->setParameter('type', GithubEvent::$typePullRequest);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Count all issuecomment events type which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countIssuesByKeywordAndDate(string $keyword, \DateTime $date): int
    {
        $qb = $this->em->createQueryBuilder('e')
            ->select('count(e.id)')
            ->where('e.createdAt = :createdAt')
            ->andWhere('e.comment LIKE :keyword')
            ->andWhere('e.type = :type');

        $qb->setParameter('createdAt', $date);
        $qb->setParameter('keyword', '%' . $keyword . '%');
        $qb->setParameter('type', GithubEvent::$typeIssueComment);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Count all comments from event which are created at the given date
     * and containing the keyword in their comment
     *
     * @param string $keyword
     * @param \DateTime $date
     * @return int
     */
    public function countCommentsByKeywordAndDate(string $keyword, \DateTime $date): int
    {
        $qb = $this->em->createQueryBuilder('e')
            ->select('count(e.id)')
            ->where('e.createdAt = :createdAt')
            ->andWhere('e.comment LIKE :keyword');

        $qb->setParameter('createdAt', $date);
        $qb->setParameter('keyword', '%' . $keyword . '%');

        return $qb->getQuery()->getSingleScalarResult();
    }
}

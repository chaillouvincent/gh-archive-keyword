<?php
declare(strict_types=1);


namespace App\Project\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Project\Domain\Exception\GithubEventNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Project\Application\Service\GithubEventsStatsService;
use App\Project\Application\Service\GithubEventService;
use App\Project\Application\Assembler\GithubEventsStatsDTOAssembler;
use App\Project\Application\Assembler\GithubEventDTOAssembler;
use App\Project\Infrastructure\Persistence\Doctrine\Repositories\GithubEventRepository;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ApiGitHubDataController extends AbstractController
{
    /**
     * Return a json object containing a dto object with github events statistics and an events list
     *
     * @param string $keyword
     * @param string $date
     * @param int $currentPage
     * @param int $elementsPerPage
     *
     * @return JsonResponse
     */
    public function getEvents(string $keyword, string $date, int $currentPage, int $elementsPerPage): JsonResponse
    {
        $repo = new GithubEventRepository($this->getDoctrine()->getManager());
        $assembler = new GithubEventsStatsDTOAssembler();
        $githubEventStatsService = new GithubEventsStatsService($repo, $assembler);

        $dtoGithubEventsStats = $githubEventStatsService->getGihubEventsStatsDTO(
            $keyword,
            \DateTime::createFromFormat('Y-m-d', $date),
            $currentPage,
            $elementsPerPage
        );

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return new JsonResponse($serializer->serialize($dtoGithubEventsStats, 'json'));
    }

    public function getEventDetails(int $id): JsonResponse
    {
        try {

            $repo = new GithubEventRepository($this->getDoctrine()->getManager());
            $assembler = new GithubEventDTOAssembler();
            $githubEventService = new GithubEventService($repo, $assembler);

            $dtoGithubEvent = $githubEventService->getGithubEventDTO($id);

            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            return new JsonResponse($serializer->serialize($dtoGithubEvent, 'json'));

        } catch (GithubEventNotFoundException $e) {

            throw new NotFoundHttpException();
        }
    }
}

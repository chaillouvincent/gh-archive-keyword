<?php
declare(strict_types=1);


namespace App\Project\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Project\Domain\Exception\GithubEventNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiGitHubDataController extends AbstractController
{
    public function getEvents(string $keyword, string $date): JsonResponse
    {

        return new JsonResponse();
    }

    public function getEventDetails($id): JsonResponse
    {
        try {
            $sprint = $this->get('service.sprint')->get($id);

            // return $this->render(
            //     'AppBundle:Sprint:show.html.twig',
            //     array('sprint' => new SprintViewAdapter($sprint))
            // );

            return new JsonResponse();

        } catch (GithubEventNotFoundException $e) {

            throw new NotFoundHttpException();
        }
    }
}

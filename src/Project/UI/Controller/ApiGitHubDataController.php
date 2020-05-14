<?php
declare(strict_types=1);


namespace App\Project\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiGitHubDataController extends AbstractController
{
    public function getEventsCount(string $keyword, string $date, string $eventType = 'all')
    {

        return new JsonResponse();
    }

    public function getEventsList(string $keyword, string $date, string $eventType = 'all')
    {

        return new JsonResponse();
    }

    public function getEventDetails($id)
    {

        return new JsonResponse();
    }

}
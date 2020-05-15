<?php
declare(strict_types=1);


namespace App\Project\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class DashboardController extends AbstractController
{
    public function index(): Response
    {

        return new Response('OK');
    }
}

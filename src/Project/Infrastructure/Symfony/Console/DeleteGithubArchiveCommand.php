<?php

declare(strict_types=1);

namespace App\Project\Infrastructure\Symfony\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;


class DeleteGithubArchiveCommand extends Command
{
    protected static $defaultName = 'app:delete-github-archives';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setDescription('Truncate all github archives data from database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            $connection = $this->em->getConnection();
            $platform   = $connection->getDatabasePlatform();

            $connection->executeUpdate($platform->getTruncateTableSQL('github_event_comment_keyword', true));

        } catch (\Exception $e) {

            $output->writeln('Error when truncating table.');
        }
    }
}

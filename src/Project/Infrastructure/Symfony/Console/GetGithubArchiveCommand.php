<?php

declare(strict_types=1);

namespace App\Project\Infrastructure\Symfony\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Project\Domain\Entities\GithubEvent;
use App\Project\Domain\Entities\GithubEventCommentKeyword;

class GetGithubArchiveCommand extends Command
{
    protected static $defaultName = 'app:get-github-archives';

    private $em;
    private $bulkBatchSize = 500;
    private $currentRowSavedCount = 0;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setDescription('Download data from githubarchive and save it to database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $this->downloadDataFiles();

        $this->em->flush(); //Persist objects that did not make up an entire batch
        $this->em->clear();

        $output->writeln('Data was imported succefully !');
    }

    /**
     * Download all gzip files relative to github archives for last week
     *
     */
    private function downloadDataFiles()
    {
        $current = strtotime("last week monday");
        $last = strtotime("last week sunday");

        // each days of last week
        while($current <= $last) {

            $date = date('Y-m-d', $current);

            // iterate on each hour file of the day
            for ($i = 0; $i < 24; $i++) {

                $handle = gzopen("https://data.gharchive.org/{$date}-{$i}.json.gz", "r");

                if (!$handle) {
                    throw new \Exception('Could not open gzip file');
                }

                while(!gzeof($handle)) {

                    // data filtering
                    $data = $this->filterData(trim(fgets($handle)));

                    if (!empty($data)) {
                        // data saving with bulk strategy
                        $this->saveData($data);
                    }
                }

                fclose($handle);
            }

            $current = strtotime('+1 day', $current);
        }
    }


    /**
     * Function use to filter data to keep only usefull event
     *
     * @param string dataRow
     * @return array
     */
    private function filterData(string $dataRow): array
    {
        $data = \json_decode($dataRow, true);

        if (!isset($data['id']) || !isset($data['created_at']) || !isset($data['type']) || !isset($data['payload'])) {

            return [];
        }

        $allowedType = ['PullRequestEvent', 'CommitCommentEvent', 'IssueCommentEvent', 'PullRequestReviewCommentEvent'];

        if (in_array($data['type'], $allowedType)) {

            return $data;
        }

        return [];
    }

    /**
     * Function used to save current data row
     * by using doctrine bulk strategy
     *
     * @param array $data
     * @return void
     */
    private function saveData(array $data): void
    {
        $githubEvent = new GithubEvent();
        $githubEvent->setGitubEventId((int)$data['id']);
        $githubEvent->setType($data['type']);

        $date = strtotime($data['created_at']);

        $createdAt = \DateTime::createFromFormat('Y-m-d', substr($data['created_at'], 0, 10));
        $githubEvent->setCreatedAt($createdAt);
        $githubEvent->setPayload($data['payload']);

        switch($data['type']) {

            case 'CommitCommentEvent':
            case 'IssueCommentEvent':
            case 'PullRequestReviewCommentEvent':
                $comment = $data['payload']['comment']['body'];
            break;

            case 'PullRequestEvent':
                $comment = $data['payload']['pull_request']['body'];
            break;
        }

        $githubEvent->setComment($comment ?? 'no comment');

        $this->em->persist($githubEvent);

        // Save data using bulk strategy
        if (($this->currentRowSavedCount % $this->bulkBatchSize) === 0) {
            $this->em->flush();
            $this->em->clear(); // Detaches all objects from Doctrine
        }

        $this->currentRowSavedCount++;
    }
}

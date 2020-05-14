<?php
namespace App\Project\Infrastructure\Symfony\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetGithubArchiveCommand extends Command
{
    protected static $defaultName = 'app:get-github-archives';

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // We will open a gzip file for each hour of each days of the given range

       // $file_name = 'https://data.gharchive.org/2020-05-11-{0..23}.json.gz';



        $this->downloadDataFiles();
   

        



        $output->writeln('Data was imported succefully !');
    }

    /**
     * Download all gzip files relative to github archives for last week
     *
     */
    private function downloadDataFiles()
    {
        // $last_week_monday = date("Y-m-d", strtotime("last week monday"));
        // $last_week_sunday = date("Y-m-d", strtotime("last week sunday"));

        $current = strtotime("last week monday");
        //$last = strtotime("last week sunday");
        $last = strtotime("last week tuesday");

        while($current <= $last) {

            echo date('Y-m-d', $current);

            // Open all gzip file for the current day
            

            $current = strtotime('+1 day', $current);
            
        }


        // echo $last_week_monday;
        // echo $last_week_sunday;

    }

    /**
     * This function is used to read a gzip file by using generator
     * it seem's to be more efficient bu reducing memory cost
     * 
     */
    private function readGzipFile(string $filePath)
    {
        $handle = fopen($path, "r");

        while(!feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }


/*     private function downloadData()
    {
        

            // Saving data in database
    } */


}
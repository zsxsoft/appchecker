<?php
namespace AppChecker;

use AppChecker\Log;
use AppChecker\MainFunc;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends Command
{

    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Run the checker')
            ->addArgument(
                'appid',
                InputArgument::REQUIRED,
                'AppID'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        Log::setOutputInterface($output);
        MainFunc::testApp($input->getArgument("appid"));
    }
}

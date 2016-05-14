<?php
namespace AppChecker;
use AppChecker\MainFunc;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends Command {
	protected function configure() {
		$this
			->setName('install')
			->setDescription('To install a zba then run checker')
			->addArgument(
				'zbapath',
				InputArgument::REQUIRED,
				'The Path of ZBA File'
			)
			->addOption(
				'bloghost',
				null,
				InputOption::VALUE_OPTIONAL,
				"Your Z-BlogPHP Url that can use webbrowser to access."
			)
		;

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		Log::SetOutputInterface($output);
		MainFunc::installApp($input->getArgument("zbapath"), $input->getOption("bloghost"));
	}
}
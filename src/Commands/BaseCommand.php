<?php

namespace Bka\ARCleaner\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Class: BaseCommand
 *
 * @see Command
 */
class BaseCommand extends Command
{
    /**
     * @var \Bka\ARCleaner\Client
     */
    protected $client = null;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * configure
     */
    protected function configure()
    {
        $this->addOption(
            'accountName',
            'name',
            InputOption::VALUE_REQUIRED,
            'accountName',
            false
        );
        $this->addOption(
            'accountKey',
            'key',
            InputOption::VALUE_REQUIRED,
            'accountKey',
            false
        );
        $this->addOption(
            'repository',
            'repo',
            InputOption::VALUE_REQUIRED,
            'repository',
            false
        );
    }

    /**
     * execute
     * @codeCoverageIgnore
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $accountName = $input->getOption('accountName');
        $accountKey = $input->getOption('accountKey');
        $repository = $input->getOption('repository');

        if ($accountName || $accountKey || $repository) {
            $context = new \Bka\ARCleaner\Context(
                $accountName,
                $accountKey,
                $repository
            );
            $this->client = new \Bka\ARCleaner\Client($context);
        }
    }

    public function getClient()
    {
        if (!$this->client) {
            $this->output->writeln('<error>please specify login credentials</error>');
            die();
        }
        return $this->client;
    }
}

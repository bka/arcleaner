<?php

namespace Bka\ARCleaner\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class: ListImages
 *
 * @see Command
 */
class ListImages extends BaseCommand
{
    /**
     * configure
     */
    protected function configure()
    {
        parent::configure();
        $this->setName("list-images");
        $this->setDescription("list images");
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
        parent::execute($input, $output);
        $client = $this->getClient();
        $images = $client->getImages();
        foreach ($images as $image) {
            $output->writeln($image->getName() . ":" . $image->getTag());
        }
    }
}

<?php

namespace Bka\ARCleaner\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class: DeleteImage
 *
 * @see Command
 */
class DeleteImage extends BaseCommand
{
    /**
     * configure
     */
    protected function configure()
    {
        parent::configure();
        $this->setName("delete-image");
        $this->setDescription("delete image");
        $this->addArgument('name', InputArgument::REQUIRED, 'name of image');
        $this->addArgument('tag', InputArgument::REQUIRED, 'name of image');
        $this->addOption(
            'dry',
            'dry',
            InputOption::VALUE_NONE,
            'simulate deletion'
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
        parent::execute($input, $output);
        $client = $this->getClient();
        $name = $input->getArgument("name");
        $tag = $input->getArgument("tag");
        $dry = $input->getOption("dry");

        $images = $client->getImages();

        $imageToDelete = $this->findImageToDelete($images, $name . ":" . $tag);
        if (!$imageToDelete) {
            $this->output->writeln('<error>requested image was not found</error>');
            return;
        }

        $layers = $imageToDelete->getLayerHashes();
        $layerBlobNames = [];
        foreach ($layers as $layer) {
            if ($this->countLayerUsage($layer, $images) == 1) {
                $layerData = $imageToDelete->getLayer($layer);
                $layerBlobNames[] = $client->convertHashToBlobPath($layerData->getHash());
            }
        }
        $metaBlobNames = $client->getBlobsToDeleteForImage($name, $tag);
        $blobs = array_merge($layerBlobNames, $metaBlobNames);

        foreach ($blobs as $blob) {
            if ($dry) {
                $output->writeln("deleting " . $blob);
                continue;
            }
        }
    }

    protected function findImageToDelete($images, $name)
    {
        foreach ($images as $image) {
            if ($image->getFullName() == $name) {
                return $image;
            }
        }
        return null;
    }

    /**
     * countLayerUsage
     *
     * @param string $hash
     * @param array $images
     */
    protected function countLayerUsage($hash, $images)
    {
        $cnt = 0;
        foreach ($images as $image) {
            if ($image->hasLayer($hash)) {
                $cnt++;
            }

        }
        return $cnt;
    }
}

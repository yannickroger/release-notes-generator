<?php

namespace RNGeneratorBundle\Command;

use RNGenerator\PackageDiffer;
use RNGenerator\ReleaseNoteRenderer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateReleaseNote extends Command
{
    protected function configure()
    {
        $this
            ->setName('releasenote:generate')
            ->setDescription('Generate the release note')
            ->setHelp('This command generates the release note using 2 composer.lock files as parameters')
            ->addArgument(
                'fromFilePath',
                InputArgument::REQUIRED,
                'Path of the composer.lock file of the previous version'
            )
            ->addArgument(
            'toFilePath',
            InputArgument::REQUIRED,
            'Path of the composer.lock file of the new version'
            )
            ->addArgument(
                'templateName',
                InputArgument::OPTIONAL,
                'Name of the template to be used: "standard" (default) or "ez"'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fromFilePath = $input->getArgument('fromFilePath');
        $toFilePath = $input->getArgument('toFilePath');

        $packageDiffer = new PackageDiffer(
            $fromFilePath,
            $toFilePath
        );

        $templateName = null;

        if ('ez' == $input->getArgument('templateName')) {
            $templateName = 'ez.md.twig';
        }

        $renderer = new ReleaseNoteRenderer($templateName);

        $output->writeln($renderer->render($packageDiffer));
    }
}

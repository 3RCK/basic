<?php

declare(strict_types=1);

namespace Codeception\Command;

use Codeception\Configuration;
use Codeception\Lib\Generator\Group as GroupGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function ucfirst;

/**
 * Creates empty GroupObject - extension which handles all group events.
 *
 * * `codecept g:group Admin`
 */
#[AsCommand(
    name: 'generate:groupobject',
    description: 'Generates Group subscriber'
)]
class GenerateGroup extends Command
{
    use Shared\FileSystemTrait;
    use Shared\ConfigTrait;

    protected function configure(): void
    {
        $this->addArgument('group', InputArgument::REQUIRED, 'Group class name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = $this->getGlobalConfig();
        $groupInputArgument = (string)$input->getArgument('group');

        $class = ucfirst($groupInputArgument);
        $path = $this->createDirectoryFor(Configuration::supportDir() . 'Group' . DIRECTORY_SEPARATOR, $class);

        $filename = $path . $class . '.php';

        $group = new GroupGenerator($config, $groupInputArgument);
        $res = $this->createFile($filename, $group->produce());

        if (!$res) {
            $output->writeln("<error>Group {$filename} already exists</error>");
            return Command::FAILURE;
        }

        $output->writeln("<info>Group extension was created in {$filename}</info>");
        $output->writeln(
            'To use this group extension, include it to "extensions" option of global Codeception config.'
        );
        return Command::SUCCESS;
    }
}

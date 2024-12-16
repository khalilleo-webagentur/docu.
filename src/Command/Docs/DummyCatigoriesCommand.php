<?php

declare(strict_types=1);

namespace App\Command\Docs;

use App\Entity\Docu\DocuCatigory;
use App\Service\Docs\CatigoryService;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// $ php bin/console app:dummy-catigories

#[AsCommand(
    name: 'app:dummy-catigories',
    description: 'Add demo dummy-catigories for demonstration purposes.',
    hidden: false
)]
class DummyCatigoriesCommand extends Command
{
    public const FAILURE = 0;
    public const SUCCESS = 1;

    public function __construct(
        private readonly CatigoryService $catigoryService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('running ...');

        $faker = Factory::create();

        $i = 0;

        while ($i <= 5) {

            $catigory = new DocuCatigory();

            $this->catigoryService->save(
                $catigory
                    ->setName($faker->jobTitle())
                    ->setDescription($faker->sentence(20))
            );

            $i++;
        }

        $output->writeln('DONE!');

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        //
    }
}

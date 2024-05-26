<?php

declare(strict_types=1);

namespace App\Command\Docs;

use App\Entity\Docu\DocuItem;
use App\Service\Docs\CatigoryService;
use App\Service\Docs\ItemService;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// $ php bin/console app:dummy-items

#[AsCommand(
    name: 'app:dummy-items',
    description: 'Add demo dummy-items for demostration purposes.',
    hidden: false
)]
class DummyItemsCommand extends Command
{
    public const FAILURE = 0;
    public const SUCCESS = 1;

    public function __construct(
        private readonly CatigoryService $catigoryService,
        private readonly ItemService $itemService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('running ...');

        $faker = Factory::create();

        foreach ($this->catigoryService->getAll() as $catigory) {

            $i = 0;

            while ($i <= 4) {

                $item = new DocuItem();

                $this->itemService->save(
                    $item
                        ->setCatigory($catigory)
                        ->setSlug($faker->jobTitle())
                        ->setContent($faker->sentence(500))
                );

                $i++;
            }
        }

        $output->writeln('DONE!');

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        //
    }
}

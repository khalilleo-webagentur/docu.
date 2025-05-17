<?php

declare(strict_types=1);

namespace App\Command\Docs;

use App\Entity\Doc\Item;
use App\Service\Doc\CategoryService;
use App\Service\Doc\ItemService;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// $ php bin/console app:dummy-items

#[AsCommand(
    name: 'app:dummy-items',
    description: 'Add demo dummy-items for demonstration purposes.',
    hidden: false
)]
class DummyItemsCommand extends Command
{
    public const FAILURE = 0;
    public const SUCCESS = 1;

    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ItemService     $itemService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('running ...');

        $faker = Factory::create();

        foreach ($this->categoryService->getAll() as $category) {

            $i = 0;

            while ($i <= 3) {

                $item = new Item();

                $this->itemService->save(
                    $item
                        ->setCategory($category)
                        ->setSlug($faker->jobTitle())
                        ->setContent($faker->sentence(500))
                        ->setReadTime($faker->numberBetween(1,12) . ' min.')
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

<?php

declare(strict_types=1);

namespace App\Command\Docs;

use App\Entity\Doc\Category;
use App\Service\Doc\CategoryService;
use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// $ php bin/console app:dummy-categories

#[AsCommand(
    name: 'app:dummy-categories',
    description: 'Add demo dummy-categories for demonstration purposes.',
    hidden: false
)]
class DummyCategoriesCommand extends Command
{
    public const FAILURE = 0;
    public const SUCCESS = 1;

    public function __construct(
        private readonly CategoryService $categoryService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('running ...');

        $faker = Factory::create();

        $i = 0;

        while ($i <= 5) {

            $category = new Category();

            $this->categoryService->save(
                $category
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

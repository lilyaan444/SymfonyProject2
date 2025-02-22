<?php

namespace App\Command;

use App\Entity\ProductEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import-products',
    description: 'Import products from CSV file'
)]
class ImportProductsCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'CSV file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('file');

        if (!file_exists($filePath)) {
            $io->error('File not found: ' . $filePath);
            return Command::FAILURE;
        }

        if (($handle = fopen($filePath, "r")) !== false) {
            // Skip header row
            fgetcsv($handle);
            
            $count = 0;
            while (($data = fgetcsv($handle)) !== false) {
                $product = new ProductEntity();
                $product->setName($data[0]);
                $product->setDescription($data[1]);
                $product->setPrice((float)$data[2]);

                $this->entityManager->persist($product);
                $count++;
            }
            
            $this->entityManager->flush();
            fclose($handle);

            $io->success(sprintf('Successfully imported %d products', $count));
            return Command::SUCCESS;
        }

        $io->error('Could not open file');
        return Command::FAILURE;
    }
}
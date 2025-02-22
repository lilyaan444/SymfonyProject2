<?php

namespace App\Command;

use App\Entity\ProductEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-products',
    description: 'Importer des produits depuis un fichier CSV',
)]
class ImportProductsCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('filename', InputArgument::REQUIRED, 'Fichier CSV à importer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filename = $input->getArgument('filename');
        $filepath = 'public/' . $filename;

        if (!file_exists($filepath)) {
            $output->writeln('<error>Fichier non trouvé</error>');
            return Command::FAILURE;
        }

        $handle = fopen($filepath, 'r');
        $headers = fgetcsv($handle); // Skip headers

        while (($data = fgetcsv($handle)) !== false) {
            $product = new ProductEntity();
            $product->setName($data[0]);
            $product->setDescription($data[1]);
            $product->setPrice(floatval($data[2]));

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();
        fclose($handle);

        $output->writeln('<info>Produits importés avec succès</info>');
        return Command::SUCCESS;
    }
}
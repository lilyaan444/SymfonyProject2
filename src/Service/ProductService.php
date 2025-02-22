<?php

namespace App\Service;

use App\Repository\ProductEntityRepository;

class ProductService
{
    public function __construct(
        private ProductEntityRepository $productRepository
    ) {}

    public function exportToCsv(): string
    {
        $products = $this->productRepository->findAllSortedByPrice();

        $handle = fopen('php://temp', 'r+');

        // En-têtes CSV
        fputcsv($handle, ['Nom', 'Description', 'Prix']);

        // Données des produits
        foreach ($products as $product) {
            fputcsv($handle, [
                $product->getName(),
                $product->getDescription(),
                $product->getPrice()
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }
}
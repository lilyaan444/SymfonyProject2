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
        $csvContent = "name,description,price\n";

        foreach ($products as $product) {
            $csvContent .= sprintf(
                "%s,%s,%.2f\n",
                $this->escapeCsv($product->getName()),
                $this->escapeCsv($product->getDescription()),
                $product->getPrice()
            );
        }

        return $csvContent;
    }

    private function escapeCsv(string $string): string
    {
        return '"' . str_replace('"', '""', $string) . '"';
    }
}
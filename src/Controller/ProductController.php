<?php

namespace App\Controller;

use App\Entity\ProductEntity;
use App\Form\ProductType;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\HeaderUtils;

#[Route('/products')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_products_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(ProductEntity::class)->findAllSortedByPrice();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/new', name: 'app_products_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = new ProductEntity();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_products_index');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit', name: 'app_products_edit')]
    public function edit(Request $request, ProductEntity $product, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_products_index');
        }

        return $this->render('product/edit.html.twig', [
            'form' => $form,
            'product' => $product
        ]);
    }

    #[Route('/{id}/delete', name: 'app_products_delete', methods: ['POST'])]
    public function delete(Request $request, ProductEntity $product, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);

        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_products_index');
    }

    #[Route('/export', name: 'app_products_export')]
    public function export(ProductService $productService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $csvContent = $productService->exportToCsv();

        $response = new Response($csvContent);
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'products.csv'
        );

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
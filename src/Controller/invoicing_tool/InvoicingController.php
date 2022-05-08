<?php

namespace App\Controller\invoicing_tool;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoicingController extends AbstractController
{
    #[Route('/invoicing', name: 'app_invoicing')]
    public function index(): Response
    {
        return $this->render('invoicing/index.html.twig', [
            'controller_name' => 'InvoicingController',
        ]);
    }
}

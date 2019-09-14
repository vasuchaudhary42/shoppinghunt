<?php
namespace App\Controller\ShoppingControllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AppController extends BaseController
{
    public function appAction(Request $request)
    {
        return $this->render('base.html.twig', []);
    }
}

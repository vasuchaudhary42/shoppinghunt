<?php


namespace App\Controller\ShoppingControllers;


class DashboardController extends BaseController
{
    public function dashboardActionAction()
    {
        return $this->render('base.html.twig');
    }
}
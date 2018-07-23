<?php
namespace Recruitment\Controller;

use Framework\Mvc\HttpController;
use Scraper\DependencyInjection\Configuration;
use Scraper\Service\Scraper\Adapters\CareerCenter;

class HomeController extends HttpController
{
    /**
     * Homepage
     */
    public function indexAction()
    {
        $this->viewModel->render('index.twig');
    }
}
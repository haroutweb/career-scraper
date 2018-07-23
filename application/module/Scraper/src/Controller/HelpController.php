<?php
namespace Scraper\Controller;

use Framework\Mvc\ConsoleController;

class HelpController extends ConsoleController
{
    /**
     * Example command ('php application/console help')
     */
    public function infoAction()
    {
        echo " --- Console Helper ---
\e[0;32mphp application/console scraper:action:serviceName:[int limit]\e[0m
- \e[0;34maction\e[0m is method short name for scrapper controller
- \e[0;34mserviceName\e[0m is scraper resource name (e.g. careercenter)
- \e[0;34mlimit\e[0m is numeric count for scarped records
        " . PHP_EOL;
    }
}
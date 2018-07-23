<?php
namespace Scraper\Controller;

use Framework\Mvc\ConsoleController;
use Scraper\Service\Scraper\ScrapeManager;

class ScraperController extends ConsoleController
{
    /**
     * Example command ('php application/console scraper:list:careercenter')
     *
     * @param $params
     */
    public function listAction($params)
    {
        try {
            $scrapeManager = new ScrapeManager($params['service'] ?? false);
            $scraper       = $scrapeManager->getService();

            $this->print('Updated ' . $scraper->executeList() . ' items');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Example command ('php application/console scraper:records:careercenter:50')
     *
     * @param $params
     */
    public function recordsAction($params)
    {
        try {
            $scrapeManager = new ScrapeManager($params['service'] ?? false);
            $scraper       = $scrapeManager->getService();
            $scraper->getConfig()->limit = $params['limit'] ?? 50;

            $this->print('Updated ' . $scraper->executeRecords() . ' items');
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
<?php
namespace Recruitment\Controller;

use Framework\Mvc\HttpController;
use Scraper\Service\Scraper\ScrapeManager;

class JobController extends HttpController
{
    /**
     * List records
     *
     * @return string
     */
    public function listAction()
    {
        try {
            $scrapeManager = new ScrapeManager('careercenter');

            $data = [
                'error' => 0,
                'data'  => $scrapeManager->getService()->getList()
            ];
        } catch (\Throwable $e) {
            $data = [
                'error'   => 1,
                'message' => $e->getMessage()
            ];
        }

        return $this->renderJson($data);
    }

    /**
     * View record
     *
     * @param $params
     * @return string
     */
    public function viewAction($params)
    {
        try {
            $scrapeManager = new ScrapeManager('careercenter');

            if (!isset($params['id'])) {
                throw new \Exception('Id not defined');
            }

            $data = [
                'error' => 0,
                'data'  => $scrapeManager->getService()->getRecord($params['id'])
            ];
        } catch (\Throwable $e) {
            $data = [
                'error'   => 1,
                'message' => $e->getMessage()
            ];
        }

        return $this->renderJson($data);
    }
}
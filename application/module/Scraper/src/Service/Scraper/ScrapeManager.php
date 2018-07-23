<?php
namespace Scraper\Service\Scraper;

use Scraper\Service\Scraper\DependencyInjection\Configuration;
use Scraper\Service\Scraper\Exception\InvalidScraperServiceException;
use Scraper\Service\Scraper\Inheritance\BaseService;

class ScrapeManager
{
    /**
     * @var BaseService
     */
    private $service;

    /**
     * @throws InvalidScraperServiceException
     * @throws \Exception
     * @param $serviceName
     */
    public function __construct($serviceName)
    {
        $config = dirname(__DIR__) . DS . '..' . DS . '..' . DS . 'config' . DS . 'service.config.php';

        if (!file_exists($config)) {
            throw new \Exception('Config file not defined');
        }

        $config   = include $config;
        $scrapers = $config['scrapers'] ?? [];

        if (!isset($scrapers[$serviceName]['service'])) {
            throw new InvalidScraperServiceException($serviceName . ' is invalid scraper service');
        }

        $params = $scrapers[$serviceName]['params'] ?? [];

        $configuration = new Configuration($params);
        $configuration->setStorage($config['storage'] ?? []);

        $this->service = new $scrapers[$serviceName]['service']($configuration);

        if (!$this->service instanceof BaseService) {
            throw new InvalidScraperServiceException('Scraper service must inherit BaseService');
        }
    }

    /**
     * @return BaseService
     */
    public function getService(): BaseService
    {
        return $this->service;
    }
}
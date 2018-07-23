<?php
namespace Scraper\Service\Scraper\Inheritance;

use Goutte\Client;
use Scraper\Service\Scraper\FileManager;
use Scraper\Service\Scraper\DependencyInjection\Configuration;

abstract class BaseService
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var Client
     */
    private $client;

    /**
     * @return mixed
     */
    abstract public function executeList();

    /**
     * @return mixed
     */
    abstract public function executeRecords();

    /**
     * @return array
     */
    abstract public function getList();

    /**
     * @param $id
     * @return array
     */
    abstract public function getRecord($id);

    /**
     * BaseService constructor.
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * @return FileManager
     */
    public function getFileManager(): FileManager
    {
        if (!$this->fileManager instanceof FileManager) {
            $this->fileManager = new FileManager($this->config->getStoragePath());
        }

        return $this->fileManager;
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        if (!$this->client instanceof Client) {
            $this->client = new Client();
        }

        return $this->client;
    }
}
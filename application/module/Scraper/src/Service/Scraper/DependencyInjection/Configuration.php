<?php
namespace Scraper\Service\Scraper\DependencyInjection;

use Scraper\Service\Scraper\Exception\InvalidScraperParameterException;

class Configuration
{
    /**
     * @var array
     */
    private $storage = [];

    /**
     * @var array
     */
    private $params = [];

    /**
     * Configuration constructor.
     * @param $params
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * @throws InvalidScraperParameterException
     */
    public function getStoragePath()
    {
        if (!isset($this->storage['path'])) {
            throw new InvalidScraperParameterException('Storage path not defined');
        }

        if (isset($this->params['path'])) {
            $path = $this->storage['path'] . DS . $this->params['path'];
        } else {
            $path = $this->storage['path'];
        }

        return $path;
    }

    /**
     * @param $storage
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param $name
     * @return bool|mixed
     * @throws InvalidScraperParameterException
     */
    public function __get($name)
    {
        if (!isset($this->params[$name])) {
            throw new InvalidScraperParameterException($name . ' parameter not defined');
        }

        return $this->params[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }
}
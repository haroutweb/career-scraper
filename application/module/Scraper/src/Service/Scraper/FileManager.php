<?php
namespace Scraper\Service\Scraper;

class FileManager
{
    /**
     * @var int
     */
    private $mask = '%018d';

    /**
     * @var int
     */
    private $pathDelimiterLength = 3;

    /**
     * @var string
     */
    private $folder = '';

    /**
     * FileManager constructor.
     * @throws \Exception
     * @param $path
     */
    public function __construct(string $path)
    {
        if (!$path) {
            throw new \Exception('Storage folder is not defined');
        }

        if (!is_writable($path)) {
            throw new \Exception($path . ' is not writable');
        }

        $this->folder = $path;
    }

    /**
     * @param $id
     * @param $content
     * @param string $type
     * @throws \Exception
     */
    public function save($id, $content, $type = 'file')
    {
        if (!is_array($content)) {
            throw new \Exception('Scraped file content should be array');
        }

        $content = json_encode($content, 1);
        $file    = $this->getPath($id, $type);

        $filePaths = explode(DS, $file);
        array_pop($filePaths);

        $dir = '';
        foreach ($filePaths as $path) {
            $dir .= DS . $path;

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        }

        file_put_contents($file, $content);
    }

    /**
     * @param $id
     * @param string $type
     * @return bool
     */
    public function isExist($id, $type = 'file'): bool
    {
        if (file_exists($this->getPath($id, $type))) {
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @param string $type
     * @return mixed
     * @throws \Exception
     */
    public function get($id, $type = 'file')
    {
        $file = $this->getPath($id, $type);

        if (!file_exists($file)) {
            throw new \Exception('File with identifier ' . $id . ' not found');
        }

        return json_decode(file_get_contents($file), true);
    }

    /**
     * @param  int $id
     * @param  string $type
     * @return string
     */
    private function getPath($id, $type = 'file')
    {
        return DS . $this->generatePath($id, $type);
    }

    /**
     * Generate path
     *
     * @param $id
     * @param $type
     * @param string $extension
     * @return string
     */
    private function generatePath($id, $type, $extension = 'json')
    {
        $maskId = sprintf($this->mask, $id);

        return sprintf('%s/%s/%s.%s', trim($this->folder, '/'), implode('/', str_split($maskId, $this->pathDelimiterLength)), $type, $extension);
    }
}
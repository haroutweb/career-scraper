<?php
namespace Scraper\Service\CareerCenter;

use Scraper\Service\Scraper\Inheritance\BaseService;
use Symfony\Component\DomCrawler\Crawler;

class Scraper extends BaseService
{
    /**
     * @var int
     */
    private $listingId = 0;

    /**
     * @return bool|int
     * @throws \Exception
     */
    public function executeList()
    {
        $crawler = $this->getClient()->request('GET', $this->config->listUrl);
        $config  = $this->config;

        $nodeValues = $crawler->filter('a')->each(function (Crawler $node, $i) use ($config) {
            $link     = $node->attr('href');
            $title    = $node->text();
            $position = strpos($link, $config->haystack);

            if ($position === false) {
                return false;
            }

            return [
                'id'        => substr($link, $position + strlen($config->haystack)),
                'url'       => $config->mainUrl . $link,
                'title'     => $title,
                'isLocated' => 0
            ];
        });

        return $this->locateListing($nodeValues);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function executeRecords()
    {
        $records = $this->getFileManager()->get($this->listingId);

        $list  = [];
        $limit = (int) $this->config->limit;

        foreach ($records as $row) {
            if ($row['isLocated']) {
                continue;
            }

            if ($limit > 0 && $limit == count($list)) {
                break;
            }

            $list[$row['id']] = $row;
        }

        if (empty($list)) {
            return 0;
        }

        foreach ($list as $row) {
            $crawler = $this->getClient()->request('GET', $row['url']);
            $info    = $crawler->filter('body')->each(function (Crawler $node, $i) {
                if ($node->filter('table')->count()) {
                    $companyName = $node->filter('table td font')->text();
                    $title       = $node->filter('table')->first()->html();
                } else {
                    $companyName = $node->filter('p')->first()->text();
                    $title       = $node->filter('p')->first()->html();
                }

                $count = $node->filter('p')->count();

                // remove company title
                $content = str_replace($title, '', $node->html());

                // remove copyrights
                $content = str_replace($node->filter('p')->eq($count-2)->html(), '', $content);
                $content = str_replace($node->filter('p')->eq($count-1)->html(), '', $content);

                return [
                    'company' => $companyName,
                    'content' => $content
                ];
            });

            if (empty($info)) {
                continue;
            }

            $records[$row['id']]['isLocated'] = 1;

            $data = [
                'id'      => $row['id'],
                'title'   => $row['title'],
                'company' => $info[0]['company'],
                'url'     => $row['url'],
                'date'    => date('Y-m-d h:i:s'),
                'content' => $info[0]['content']
            ];

            $this->getFileManager()->save($row['id'], $data);
        }
        
        return $this->locateListing($records, true);
    }

    /**
     * @param $data
     * @param bool $locate
     * @return int
     * @throws \Exception
     */
    private function locateListing($data, $locate = false)
    {
        if (empty($data)) {
            throw new \Exception($this->config->name . ' service not working or see our activity :))');
        }

        $oldData = [];
        $diff    = 0;

        if ($this->getFileManager()->isExist($this->listingId)) {
            $oldData = $this->getFileManager()->get($this->listingId);
        }

        foreach ($data as $row) {
            if (!is_array($row) ||
                ($locate && $oldData[$row['id']]['isLocated'] == $row['isLocated']) ||
                (!$locate && isset($oldData[$row['id']]))
            ) {
                continue;
            }

            $diff++;
            $oldData[$row['id']] = $row;
        }

        if ($diff > 0) {
            ksort($oldData);
            $jsonData = $oldData;
            $this->getFileManager()->save($this->listingId, $jsonData);
        }

        return $diff;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getList()
    {
        $data = $this->getFileManager()->get($this->listingId);
        krsort($data);

        return array_values($data);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getRecord($id)
    {
        return $this->getFileManager()->get($id);
    }
}
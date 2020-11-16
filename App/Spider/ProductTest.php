<?php

namespace App\Spider;

use EasySwoole\HttpClient\HttpClient;
use EasySwoole\Spider\Config\ProductConfig;
use EasySwoole\Spider\Hole\ProductAbstract;
use EasySwoole\Spider\ProductResult;
use QL\QueryList;
use EasySwoole\FastCache\Cache;

/**
 * Description:
 * Class ProductTest
 * @package App\Spider
 */
class ProductTest extends ProductAbstract
{
    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/10/13
     * Time: 4:16 下午
     * @return ProductResult
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function product(): ProductResult
    {
        // TODO: Implement product() method.
        // 请求地址数据
        $httpClient = new HttpClient($this->productConfig->getUrl());
        $httpClient->setHeader('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.116 Safari/537.36');
        $body = $httpClient->get()->getBody();

        // 先将每个搜索结果的a标签内容拿到
        $rules = [
            'search_result' => ['.c-container .t', 'text', 'a']
        ];
        $searchResult = QueryList::rules($rules)->html($body)->query()->getData();

        $data = [];
        foreach ($searchResult as $result) {
            $item = [
                'href' => QueryList::html($result['search_result'])->find('a')->attr('href'),
                'text' => QueryList::html($result['search_result'])->find('a')->text()
            ];
            $data[] = $item;
        }

        $productJobOtherInfo = $this->productConfig->getOtherInfo();
        // 下一批任务
        $productJobConfigs = [];
        if ($productJobOtherInfo['page'] === 1) {
            for($i=1;$i<5;$i++) {
                $pn = $i*10;
                $productJobConfig = [
                    'url' => "https://www.baidu.com/s?wd={$productJobOtherInfo['word']}&pn={$pn}",
                    'otherInfo' => [
                        'word' => $productJobOtherInfo['word'],
                        'page' => $i+1
                    ]
                ];
                $productJobConfigs[] = $productJobConfig;
            }

            $word = Cache::getInstance()->deQueue(self::SEARCH_WORDS);
            if (!empty($word)) {
                $productJobConfigs[] = [
                    'url' => "https://www.baidu.com/s?wd={$word}&pn=0",
                    'otherInfo' => [
                        'word' => $word,
                        'page' => 1
                    ]
                ];
            }

        }

        $result = new ProductResult();
        $result->setProductJobConfigs($productJobConfigs)->setConsumeData($data);
        return $result;
    }
}
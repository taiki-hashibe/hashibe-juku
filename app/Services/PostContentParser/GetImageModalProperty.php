<?php

namespace App\Services\PostContentParser;

use DOMDocument;
use DOMElement;
use DOMXPath;

class GetImageModalProperty
{
    public string $alpineData = "";
    /**
     * @var array<int,array<string, string>>
     */
    public array $modalImages = [];
    /**
     * @param string $alpineData
     * @param array<int,array<string, string>> $modalImages
     */
    public function __construct(string $alpineData = "", array $modalImages = [])
    {
        $this->alpineData = $alpineData;
        $this->modalImages = $modalImages;
    }

    public static function get(string $content): self
    {
        /** @var array<int,array<string, string>> $modalImages */
        $modalImages = [];
        $alpineData = "";
        $dom = new DOMDocument(); // UTF-8エンコーディングを指定
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(false);
        // DOMXPathを使用してXPathクエリを実行
        $xpath = new DOMXPath($dom);
        $imgNodes = $xpath->query('//img[contains(@class, "post-content-modal-image")]');

        if (!$imgNodes) {
            throw new \Exception('imgNodes is false');
        }
        for ($i = 0; $i < $imgNodes->length; $i++) {
            $imgId = 'ModalImage' . $i;
            $imgNode = $imgNodes->item($i);
            /** @var DOMElement $imgNode */
            $srcValue = $imgNode->getAttribute('src');
            $modalImages[] = [
                'id' => $imgId,
                'src' => $srcValue,
            ];
        }
        $alpineData = 'x-data="{';
        foreach ($modalImages as $modalImage) {
            $alpineData .= 'open' . $modalImage['id'] . ': false,';
        }
        $alpineData .= '}"';
        return new self($alpineData, $modalImages);
    }
}

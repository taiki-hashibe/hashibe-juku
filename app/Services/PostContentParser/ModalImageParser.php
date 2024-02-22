<?php

namespace App\Services\PostContentParser;

use DOMDocument;
use DOMElement;
use DOMXPath;

class ModalImageParser implements Parser
{
    public static function parse(string $content): string
    {
        $dom = new DOMDocument(); // UTF-8エンコーディングを指定
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(false);
        // DOMXPathを使用してXPathクエリを実行
        $xpath = new DOMXPath($dom);

        // aの子要素ではないimg要素を抽出
        $imgNodes = $xpath->query('//img[not(parent::a)]');
        if (!$imgNodes) {
            throw new \Exception('imgNodes is false');
        }
        for ($i = 0; $i < $imgNodes->length; $i++) {
            $imgId = 'ModalImage' . $i;
            $imgNode = $imgNodes->item($i);
            /** @var DOMElement $imgNode */
            $srcValue = $imgNode->getAttribute('src');

            // a要素を作成してimg要素を置き換え
            $aElement = $dom->createElement('a');
            $aElement->setAttribute('class', 'cursor-pointer');
            $aElement->setAttribute('x-on:click', 'open' . $imgId . ' = true');

            // 新しいimg要素の作成とエンコーディング設定
            $newImgNode = $dom->createElement('img');
            $newImgNode->setAttribute('src', $srcValue);
            $newImgNode->setAttribute('alt', ''); // alt属性も設定すると良い
            $newImgNode->setAttribute('class', 'post-content-modal-image');
            $aElement->appendChild($newImgNode);

            if (!$imgNode->parentNode) throw new \Exception('imgNode parentNode is false');
            $imgNode->parentNode->replaceChild($aElement, $imgNode);
        }

        // エンコーディング指定のためのヘッダーを取り除く
        $html = $dom->saveHTML();
        if (!$html) throw new \Exception('html is null');
        $content = preg_replace('/^<!DOCTYPE.+?>/i', '', $html);
        if (!$content) throw new \Exception('content is null');
        return $content;
    }
}

<?php

namespace App\Services\PostContentParser;

interface Parser
{
    public static function parse(string $content): string;
}

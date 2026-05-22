<?php

namespace App\Helpers;

class SeoHelper
{
    public static function smartTruncate(?string $text, int $maxLength): string
    {
        if (! $text) {
            return '';
        }

        $text = html_entity_decode(strip_tags($text));

        if (strlen($text) <= $maxLength) {
            return $text;
        }

        $truncated = substr($text, 0, $maxLength);
        $lastSpace = strrpos($truncated, ' ');

        if ($lastSpace !== false) {
            $truncated = substr($truncated, 0, $lastSpace);
        }

        return rtrim($truncated, '.,;:!?') . '...';
    }
}

<?php

namespace App\Helpers;

class SEOValidator
{
    /**
     * Validate meta description length (optimal: 150-160 characters)
     */
    public static function validateDescription(string $description): array
    {
        $length = mb_strlen($description);
        $min = 120;
        $optimalMin = 150;
        $optimalMax = 160;
        $max = 165;

        return [
            'length' => $length,
            'is_valid' => $length >= $min && $length <= $max,
            'is_optimal' => $length >= $optimalMin && $length <= $optimalMax,
            'message' => self::getDescriptionMessage($length, $min, $optimalMin, $optimalMax, $max)
        ];
    }

    /**
     * Validate title length (optimal: 50-60 characters)
     */
    public static function validateTitle(string $title): array
    {
        $length = mb_strlen($title);
        $min = 30;
        $optimalMin = 50;
        $optimalMax = 60;
        $max = 70;

        return [
            'length' => $length,
            'is_valid' => $length >= $min && $length <= $max,
            'is_optimal' => $length >= $optimalMin && $length <= $optimalMax,
            'message' => self::getTitleMessage($length, $min, $optimalMin, $optimalMax, $max)
        ];
    }

    /**
     * Calculate readability score (Flesch Reading Ease)
     */
    public static function calculateReadability(string $content): array
    {
        $text = strip_tags($content);
        $sentences = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $words = str_word_count($text);
        $syllables = 0;

        foreach (explode(' ', $text) as $word) {
            $syllables += self::countSyllables($word);
        }

        if ($sentences > 0 && $words > 0) {
            $score = 206.835 - (1.015 * ($words / count($sentences))) - (84.6 * ($syllables / $words));
            $score = max(0, min(100, $score));
        } else {
            $score = 0;
        }

        return [
            'score' => round($score, 2),
            'level' => self::getReadabilityLevel($score),
            'word_count' => $words,
            'sentence_count' => count($sentences),
            'syllable_count' => $syllables
        ];
    }

    /**
     * Check content length (minimum 300 words recommended)
     */
    public static function validateContentLength(string $content): array
    {
        $wordCount = str_word_count(strip_tags($content));
        $minRecommended = 300;
        $optimal = 1000;

        return [
            'word_count' => $wordCount,
            'is_valid' => $wordCount >= $minRecommended,
            'is_optimal' => $wordCount >= $optimal,
            'message' => $wordCount < $minRecommended 
                ? "Content is too short. Recommended minimum: {$minRecommended} words. Current: {$wordCount} words."
                : ($wordCount < $optimal 
                    ? "Content length is good. For optimal SEO, consider {$optimal}+ words. Current: {$wordCount} words."
                    : "Content length is optimal. Current: {$wordCount} words.")
        ];
    }

    /**
     * Calculate keyword density
     */
    public static function calculateKeywordDensity(string $content, string $keyword): array
    {
        $text = strtolower(strip_tags($content));
        $keyword = strtolower($keyword);
        $words = str_word_count($text);
        $keywordCount = substr_count($text, $keyword);
        
        $density = $words > 0 ? ($keywordCount / $words) * 100 : 0;
        $optimalMin = 1;
        $optimalMax = 2.5;

        return [
            'keyword' => $keyword,
            'count' => $keywordCount,
            'density' => round($density, 2),
            'is_optimal' => $density >= $optimalMin && $density <= $optimalMax,
            'message' => $density < $optimalMin
                ? "Keyword density is too low. Recommended: {$optimalMin}-{$optimalMax}%. Current: {$density}%."
                : ($density > $optimalMax
                    ? "Keyword density is too high (keyword stuffing). Recommended: {$optimalMin}-{$optimalMax}%. Current: {$density}%."
                    : "Keyword density is optimal. Current: {$density}%.")
        ];
    }

    private static function getDescriptionMessage(int $length, int $min, int $optimalMin, int $optimalMax, int $max): string
    {
        if ($length < $min) {
            return "Description is too short. Recommended: {$optimalMin}-{$optimalMax} characters. Current: {$length} characters.";
        } elseif ($length > $max) {
            return "Description is too long and may be truncated. Recommended: {$optimalMin}-{$optimalMax} characters. Current: {$length} characters.";
        } elseif ($length < $optimalMin || $length > $optimalMax) {
            return "Description length is acceptable but not optimal. Recommended: {$optimalMin}-{$optimalMax} characters. Current: {$length} characters.";
        } else {
            return "Description length is optimal. Current: {$length} characters.";
        }
    }

    private static function getTitleMessage(int $length, int $min, int $optimalMin, int $optimalMax, int $max): string
    {
        if ($length < $min) {
            return "Title is too short. Recommended: {$optimalMin}-{$optimalMax} characters. Current: {$length} characters.";
        } elseif ($length > $max) {
            return "Title is too long and may be truncated. Recommended: {$optimalMin}-{$optimalMax} characters. Current: {$length} characters.";
        } elseif ($length < $optimalMin || $length > $optimalMax) {
            return "Title length is acceptable but not optimal. Recommended: {$optimalMin}-{$optimalMax} characters. Current: {$length} characters.";
        } else {
            return "Title length is optimal. Current: {$length} characters.";
        }
    }

    private static function countSyllables(string $word): int
    {
        $word = strtolower($word);
        $count = 0;
        $vowels = 'aeiouy';
        $prevWasVowel = false;

        for ($i = 0; $i < strlen($word); $i++) {
            $isVowel = strpos($vowels, $word[$i]) !== false;
            if ($isVowel && !$prevWasVowel) {
                $count++;
            }
            $prevWasVowel = $isVowel;
        }

        // Adjust for silent 'e'
        if (substr($word, -1) === 'e') {
            $count--;
        }

        return max(1, $count);
    }

    private static function getReadabilityLevel(float $score): string
    {
        if ($score >= 90) return 'Very Easy';
        if ($score >= 80) return 'Easy';
        if ($score >= 70) return 'Fairly Easy';
        if ($score >= 60) return 'Standard';
        if ($score >= 50) return 'Fairly Difficult';
        if ($score >= 30) return 'Difficult';
        return 'Very Difficult';
    }
}


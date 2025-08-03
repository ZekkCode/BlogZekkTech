<?php

namespace App\Helpers;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Str as LaravelStr;

class Str extends LaravelStr
{
    /**
     * Estimate reading time for a text.
     *
     * @param  string  $text
     * @return int
     */
    public static function readingTime(string $text): int
    {
        $wordCount = str_word_count(strip_tags($text));
        $wordsPerMinute = 200;  // Average reading speed

        return max(1, ceil($wordCount / $wordsPerMinute));
    }

    /**
     * Parse markdown text to HTML with natural spacing.
     *
     * @param  string  $text
     * @return string
     */
    public static function markdownToHtml(string $text): string
    {
        // Normalize line endings
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);

        // Preserve all line breaks - jangan ubah apa-apa
        // Hanya bersihkan excessive line breaks (lebih dari 4)
        $text = preg_replace('/\n{5,}/', "\n\n\n\n", $text);

        // Menggunakan parser markdown yang lebih simple
        if (class_exists('\Parsedown')) {
            $parser = new \Parsedown();
            $parser->setBreaksEnabled(true); // Enable line breaks
            $parser->setMarkupEscaped(false); // Allow HTML
            $parser->setUrlsLinked(true); // Auto-link URLs

            $html = $parser->text($text);

            // Post-process untuk spacing yang lebih natural
            // Convert double line breaks ke proper paragraph spacing
            $html = str_replace("\n\n", "</p>\n<p>", $html);

            return $html;
        }

        // Fallback ke League CommonMark
        $environment = new \League\CommonMark\Environment\Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);

        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension());

        $converter = new \League\CommonMark\MarkdownConverter($environment);
        return $converter->convert($text)->getContent();
    }
}

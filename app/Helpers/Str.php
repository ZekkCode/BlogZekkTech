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
     * Parse markdown text to HTML.
     *
     * @param  string  $text
     * @return string
     */
    public static function markdownToHtml(string $text): string
    {
        // Menggunakan League CommonMark langsung untuk parse markdown
        $environment = new \League\CommonMark\Environment\Environment([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ]);

        // Menambahkan ekstensi-ekstensi umum
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension());
        $environment->addExtension(new \League\CommonMark\Extension\Table\TableExtension());
        $environment->addExtension(new \League\CommonMark\Extension\Autolink\AutolinkExtension());

        // Membuat parser dan merender HTML
        $converter = new \League\CommonMark\MarkdownConverter($environment);

        return $converter->convert($text)->getContent();
    }
}

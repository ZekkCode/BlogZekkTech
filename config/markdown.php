<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Renderer
    |--------------------------------------------------------------------------
    |
    | This option controls the default renderer that will be used by the
    | markdown parser.
    |
    | Supported: "commonmark", "commonmark_advanced"
    |
    */

    'renderer' => 'commonmark',

    /*
    |--------------------------------------------------------------------------
    | Markdown Extensions
    |--------------------------------------------------------------------------
    |
    | This option specifies what extensions will be automatically enabled.
    | Simply provide your extension class names here.
    |
    | Default extensions are: 
    | League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension,
    | League\CommonMark\Extension\Table\TableExtension
    |
    */

    'extensions' => [
        League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension::class,
        League\CommonMark\Extension\Table\TableExtension::class,
        League\CommonMark\Extension\Autolink\AutolinkExtension::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Commonmark Configuration
    |--------------------------------------------------------------------------
    |
    | This option specifies the configuration options that should be passed to
    | the commonmark parser.
    |
    | @see https://commonmark.thephpleague.com/2.4/configuration/
    |
    */

    'commonmark' => [
        'html_input' => 'allow',
        'allow_unsafe_links' => false,
        'max_nesting_level' => PHP_INT_MAX,
    ],
];

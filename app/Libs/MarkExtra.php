<?php
namespace App\Libs;

class MarkExtra
{
    public static function parse($text)
    {
        $text = addslashes(htmlentities($text));
        $text = \Markdown::parse($text);
        $text = self::transformTwemoji($text);
        return $text;
    }

    protected static function transformTwemoji($text)
    {
        $pattern = '/:(?<type>[0-9abcdef]*):/mi';
        $text = preg_replace_callback($pattern, function($hits) {
            return Twemoji::create($hits['type']);
        }, $text);
        return $text;
    }
}
<?php
namespace App\Libs;

use App\User;
use Michelf\MarkdownExtra;

class MarkExtra extends MarkdownExtra
{
    public static function defaultTransform($text)
    {
        $text = parent::defaultTransform($text);
        $text = self::transformChangelog($text);
        $text = self::transformTwemoji($text);
        $text = self::transformUserlinks($text);
        return $text;
    }

    protected static function transformChangelog($text)
    {
        $pattern = '/^(<p>|)\[(?<type>[a-z]+)\] (?<str>[\s\d\w\.\-_,!?\(\);:&öäüßÖÄÜ]+)(<\/p>|)$/mi';
        $text = preg_replace_callback($pattern, function($hits) {
            $type = trim(strtolower($hits['type']));
            switch($type) {
                case 'bug':
                    $class = 'fa-bug text-warning';
                    break;
                case 'bugfix':
                    $class = 'fa-bug text-warning';
                    break;
                case 'fix':
                    $class = 'fa-bug text-warning';
                    break;
                case 'update':
                    $class = 'fa-level-up text-success';
                    break;
                case 'upgrade':
                    $class = 'fa-level-up text-success';
                    break;
                case 'add':
                    $class = 'fa-plus text-success';
                    break;
                case 'plus':
                    $class = 'fa-plus text-success';
                    break;
                case 'remove':
                    $class = 'fa-minus text-danger';
                    break;
                case 'minus':
                    $class = 'fa-minus text-danger';
                    break;
            }
            $result = '';
            $result .= str_replace('<p>', '<ul class="list-icons">', $hits[1]);
            $result .= '<li>';
            $result .= '<i class=" icon '.$class.'"></i>';
            $result .= $hits['str'];
            $result .= '</li>';
            $result .= str_replace('</p>', '</ul>', $hits[4]);

            return $result;
        }, $text);
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

    protected static function transformUserlinks($text)
    {
        $users = User::all();

        $pattern = '/@(?<slug>[0-9a-z\-]*)/mi';
        $text = preg_replace_callback($pattern, function($hits) use($users) {
            if(in_array($hits['slug'], $users->pluck('slug')->toArray())) {
                $user = $users->where('slug', $hits['slug'])->first();
                return '<a href="'.url('app/profile/show/'.$user->id).'">@'.$hits['slug'].'</a>';
            } else {
                return '@'.$hits['slug'];
            }
        }, $text);
        return $text;
    }
}
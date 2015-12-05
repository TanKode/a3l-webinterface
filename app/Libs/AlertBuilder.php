<?php
namespace App\Libs;

use Collective\Html\HtmlBuilder;

class AlertBuilder
{
    protected $html;

    public function __construct(HtmlBuilder $html)
    {
        $this->html = $html;
    }

    public function info($text, array $options = [])
    {
        return $this->alert('info', $text, $options);
    }

    public function success($text, array $options = [])
    {
        return $this->alert('success', $text, $options);
    }

    public function warning($text, array $options = [])
    {
        return $this->alert('warning', $text, $options);
    }

    public function danger($text, array $options = [])
    {
        return $this->alert('danger', $text, $options);
    }

    public function alert($type, $text, array $options = [])
    {
        $options['dismiss'] = array_get($options, 'dismiss', false);
        $options['dark'] = array_get($options, 'dark', true);

        $classes = [
            'alert',
            'alert-'.strtolower($type),
            $this->getOption($options, 'class'),
            $this->getOption($options, 'dismiss', null, 'alert-dismiss'),
            $this->getOption($options, 'icon', null, 'alert-icon'),
            $this->getOption($options, 'dark', null, 'dark'),
        ];
        $options['class'] = implode(' ', array_filter($classes));

        if(is_array($text)) {
            $text = implode('</p><p>', $text);
        }

        return '<div'.$this->html->attributes($options).'>'.$this->getDismiss($options).$this->getIcon($options).$this->getTitle($options).'<p>'.$text.'</p></div>';
    }

    private function getDismiss(array $options)
    {
        return $options['dismiss'] ? '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>' : '';
    }

    private function getIcon(array $options)
    {
        return isset($options['icon']) ? '<i class="icon '.$options['icon'].'"></i>' : '';
    }

    private function getTitle(array $options)
    {
        return isset($options['title']) ? '<h4>'.$options['title'].'</h4>' : '';
    }

    private function getOption(array $options, $key, $default = null, $value = null)
    {
        if(is_null($value)) {
            return array_get($options, $key, $default);
        } else {
            return isset($options[$key]) && $options[$key] ? $value : $default;
        }
    }
}
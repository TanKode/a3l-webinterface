<?php
namespace App\Libs;

use Collective\Html\FormBuilder as IlluminateFormBuilder;

class FormBuilder extends IlluminateFormBuilder
{
    public function input($type, $name, $value = null, $options = [])
    {
        $options['class'] = array_get($options, 'class', '') . ' form-control';
        $options['id'] = array_get($options, 'id', ($type != 'hidden' ? $this->id($type, $name) : null));

        return $this->constructHTML(parent::input($type, $name, $value, $this->clearOptions($options)), $options);
    }

    public function hidden($name, $value = null, $options = [])
    {
        return parent::input('hidden', $name, $value, $options);
    }

    public function search($name, $value = null, $options)
    {
        $options['container'] = false;
        $options['id'] = array_get($options, 'id', $this->id('search', $name));

        $before = '<div class="input-search"><i class="input-search-icon fa-search"></i>';
        $label = isset($options['label']) ? $this->label($options['id'], $options['label']) : '';
        unset($options['label']);
        $input = $this->input('search', $name, $value, $options);
        $after = '<button type="button" class="input-search-close input-reset icon fa-trash-o" data-reset="#'.$options['id'].'"></button></div>';
        return $label.$before.$input.$after;
    }

    protected function checkable($type, $name, $value, $checked, $options)
    {
        $checked = $this->getCheckedState($type, $name, $value, $checked);
        if ($checked) {
            $options['checked'] = 'checked';
        }
        $options['id'] = array_get($options, 'id', $this->id($type, $name));
        return $this->constructHTML(parent::input($type, $name, $value, $this->clearOptions($options)), $options);
    }

    public function textarea($name, $value = null, $options = [])
    {
        $options['class'] = array_get($options, 'class', '') . ' form-control';
        $options['id'] = array_get($options, 'id', $this->id('textarea', $name));
        return $this->constructHTML(parent::textarea($name, $value, $this->clearOptions($options)), $options);
    }

    public function label($name, $value = null, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' control-label' : 'control-label';
        return parent::label($name, $value, $options);
    }

    public function datepicker($name, $value = null, array $options = [])
    {
        $options['id'] = array_get($options, 'id', $this->id('datepicker', $name));
        $options['data-plugin'] = 'datepicker';
        $options['data-language'] = str_slug(\LaravelGettext::getLocale(), '-');
        $options['beforeInput'] = '<div class="input-group"><label for="'.$options['id'].'" class="input-group-addon bg-dark"><i class="icon fa-calendar"></i></label>';
        $options['afterInput'] = '</div>';

        return $this->input('text', $name, $value, $options);
    }

    public function selectpicker($name, $list = [], $selected = null, $options = [])
    {
        $options['data-plugin'] = 'selectpicker';
        $options['data-none-selected-text'] = array_get($options, 'placeholder', '');
        $options['data-live-search'] = array_get($options, 'search', false);
        $options['data-size'] = array_get($options, 'size', 10);
        $options['class'] = array_get($options, 'class', '') . ' show-tick';
        $options['id'] =  array_get($options, 'id', $this->id('select-picker', $name));

        if (isset($options['data-filter']) && $options['data-filter'] === true) {
            $tmp = ['' => ''];
            foreach ($list as $val) {
                $tmp[$val] = $val;
            }
            $list = $tmp;
            unset($tmp);
        }

        return $this->select($name, $list, $selected, $options);
    }

    public function select($name, $list = [], $selected = null, $options = [])
    {
        $options['class'] = array_get($options, 'class', '') . ' form-control';
        $options['id'] =  array_get($options, 'id', $this->id('select', $name));
        return $this->constructHTML(parent::select($name, $list, $selected, $this->clearOptions($options)), $options);
    }

    public function icon($icon = null, $options = [])
    {
        $options['class'] = isset($options['class']) ? $options['class'] . ' icon '.$icon : 'btn-default icon '.$icon;
        return $this->button('', $options);
    }

    public function submit($value = null, $options = [])
    {
        $options['type'] = 'submit';
        return $this->button($value, $options);
    }

    public function button($value = null, $options = [])
    {
        $classes = [];
        $classes[] = 'btn';
        $classes[] = isset($options['class']) ? $options['class'] : 'btn-default';
        $classes[] = isset($options['icon']) ? 'btn-labeled' : '';
        $options['class'] = implode(' ', $classes);
        $icon = isset($options['icon']) ? '<span class="btn-label"><i class="icon '.$options['icon'].'"></i></span>' : '';
        return parent::button($icon.$value, $this->clearOptions($options));
    }

    private function constructHTML($input, $options)
    {
        $options['container'] = array_get($options, 'container', true);
        $before = $options['container'] ? '<div class="form-group clearfix">' : '';
        $label = isset($options['label']) ? $this->label($options['id'], $options['label']) : '';
        $errors = '';
        if(isset($options['errors']) && is_array($options['errors']) && count($options['errors'])) {
            $before = $options['container'] ? '<div class="form-group has-error clearfix">' : '';
            $errors = $this->formatErrors($options['errors']);
        }

        $beforeInput = array_get($options, 'beforeInput', '');
        $afterInput = array_get($options, 'afterInput', '');

        $after = $options['container'] ? '</div>' : '';
        return $before.$label.$beforeInput.$input.$afterInput.$errors.$after;
    }

    private function formatErrors(array $errors)
    {
        if(isset($errors) && is_array($errors) && count($errors)) {
            $before = '<div class="help-block">';
            $messages = '';
            foreach ($errors as $error) {
                $messages .= '<div>' . $error . '</div>';
            }
            $after = '</div>';
            return $before.$messages.$after;
        } else {
            return '';
        }
    }

    private function id($type, $name)
    {
        return camel_case($type.'-field-'.$name);
    }

    private function clearOptions(array $options = [])
    {
        unset(
            $options['icon'],
            $options['label'],
            $options['size'],
            $options['errors'],
            $options['search'],
            $options['container'],
            $options['beforeInput'],
            $options['afterInput']
        );
        return $options;
    }
}
<?php
namespace App\Libs;

class FilterBuilder
{
    protected $form;

    public function __construct(FormBuilder $form)
    {
        $this->form = $form;
    }

    public function render(array $fields = [])
    {
        return '<div class="panel" id="filter">'.$this->getHeader().$this->getForm($fields).'</div>';
    }

    private function getForm(array $fields = [])
    {
        return $this->form->open([
            'class' => 'panel-body row',
        ]).$this->getFields($fields).$this->form->close();
    }

    private function getHeader()
    {
        return '<header class="panel-heading">
            <h3 class="panel-title">Filter</h3>
            <div class="panel-actions">
                <a class="panel-action icon fa-trash-o" id="resetFilter" data-toggle="tooltip" data-placement="top" title="reset"></a>
                <a class="panel-action icon fa-minus" data-toggle="panel-collapse"></a>
            </div>
        </header>';
    }

    private function getFields(array $fields = [])
    {
        $html = '';
        foreach ($fields as $field) {
            $html .= '<div class="col-md-3">';
            $html .= $field;
            $html .= '</div>';
        }
        return $html;
    }
}

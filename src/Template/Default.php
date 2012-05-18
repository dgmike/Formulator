<?php

class Apolo_Component_Formulator_Template_Default
    extends Apolo_Component_Formulator_Template
{
    public $templates = array(
        'table'         => '{open_table}{elements}{close_table}',
        'table_row'     => '{open_tr}{elements}{close_tr}',
        'table_column'  => '{open_td}{elements}{close_td}',
        'table_heading' => '{open_th}{elements}{close_th}',
        'table_tbody'   => '{open_tbody}{elements}{close_tbody}',
        'table_thead'   => '{open_thead}{elements}{close_thead}',
        'table_tfoot'   => '{open_tfoot}{elements}{close_tfoot}',

        'citystate'     => '{elements}',
        'repetition'    => '
                         <div class="fieldset_wrap">
                             {fieldsetopen}
                                <legend>
                                    {label}
                                    <button type="add" template="{uniq_id}" class="repetition add">Adicionar</button>
                                </legend>
                                {before}
                                <ul>
                                    {subElements}
                                    <li {containerAttrs}>{container}{elements}</li>
                                </ul>
                                {after}
                             {fieldsetclose}
                         </div>
                        ',
        'phonegroup'    => '
                         <div class="fieldset_wrap">
                             <fieldset>
                                 <legend>
                                     Telefones
                                     <button type="add" template="{uniq_id}" class="repetition add">Adicionar</button>
                                 </legend>
                                 <label>Padrao</label>
                                 <hr />
                                 <ul>
                                     {subElements}
                                     <li {containerAttrs}>{container}{elements}</li>
                                 </ul>
                             </fieldset>
                         </div>
                        ',
        'button'        => '<button{attrs}>{label}</button>',
        'hidden'        => '{input}',
        'radio'         => '<label class="radio">{input} {label}</label>',
        'checkbox'      => '<label class="checkbox">{input} {label}</label>',
        'fieldset'      => "<div class=\"fieldset_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'address'       => "<div class=\"address_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'checkboxgroup' => "<div class=\"checkbox_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'radiogroup'    => "<div class=\"radio_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'html'          => '{content}',

        'input'          => "<label{class}>\n<span>{label.content}</span>:\n{input}\n</label>",

        'default'       => "<label{class}>\n<span>{label}</span>:\n{input}\n</label>",
    );

    public function templateText($template, $element)
    {
        if (empty($element->attrs['label'])) {
            return '<label>{input}</label>';
        }
        return $template;
    }

    public function templateRepetition($template, Apolo_Component_Formulator_Element $element)
    {
        if (isset($element->subElements)) {
            if ('array' === gettype($element->subElements)) {
                $elements = array();
                foreach($element->subElements as $k => $subElement) {
                    $elements[] = sprintf(
                        '<li repeat="%d">%s</li>',
                        $k,
                        $this->render($subElement->getElements())
                    );
                }
                $elements = implode('', $elements);
            } else {
                $elements = $this->render($element->subElements->getElements());
            }
            $template = str_replace('{subElements}', $elements, $template);
        } else {
            $template = str_replace('{subElements}', '', $template);
        }



        foreach (array('before', 'after') as $_area) {
            if (isset($element->{$_area})) {
                if ('array' === gettype($element->{$_area})) {
                    $elements = array();
                    foreach($element->{$_area} as $k => $element) {
                        $elements[] = $this->render($element->getElements());
                    }
                    $elements = implode('', $elements);
                } else {
                    $elements = $this->render($element->{$_area}->getElements());
                }
                $template = str_replace('{'.$_area.'}', $elements, $template);
            } else {
                $template = str_replace('{'.$_area.'}', '', $template);
            }
        }

        return $template;
    }

    public function templatePhonegroup($template, Apolo_Component_Formulator_Element $element)
    {
        return $this->templateRepetition($template, $element);
    }

}

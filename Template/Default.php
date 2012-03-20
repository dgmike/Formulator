<?php

class Apolo_Component_Formulator_Template_Default
    extends Apolo_Component_Formulator_Template
{
    public $templates = array(
        'citystate'  => '{elements}',
        'repetition' => '
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
        'phoneGroup' => '
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
        'button'     => '<button{attrs}>{label}</button>',
        'hidden'     => '{input}',
        'radio'      => '<label class="radio">{input} {label}</label>',
        'checkbox'   => '<label class="checkbox">{input} {label}</label>',
        'fieldset'   => "<div class=\"fieldset_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'address'    => "<div class=\"address_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'checkboxgroup'   => "<div class=\"checkbox_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'radiogroup'   => "<div class=\"radio_wrap\">{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}</div>",
        'html'       => '{content}',
        'default'    => "<label{class}>\n<span>{label}</span>:\n{input}\n</label>",
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

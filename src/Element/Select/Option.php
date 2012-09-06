<?php

class Apolo_Component_Formulator_Element_Select_Option
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'select_option';
    public $acceptSubelements = false;
    public $validAttributes = array(
        'default' => array('value', 'label'),
        'option'  => array('selected', 'value'),
    );

    public function setElement(array $element)
    {
        if ($this->form) {
            $values = $this->form->getValues();
            if (   !empty($element['name'])
                && array_key_exists($element['name'], $values)
            ) {
                $values = $values[$element['name']];
            } else {
                $values = array();
            }
            if (is_string($values)) {
                $values = array($values);
            }
            if (!empty($element['_value']) && in_array($element['_value'], $values)) {
                $element['selected'] = 'selected';
            }
        }
        if (!empty($element['_value'])) {
            $element['value'] = $element['_value'];
        }
        foreach (array('label', 'value') as $item) {
            if (!isset($element[$item]) || !is_scalar($element[$item])) {
                throw new DomainException("Option must have a '$item'");
            }
            $this->setAttribute('default', $item, $element[$item]);
        }
        foreach ($element as $key=>$value) {
            if ($this->validAttribute('option', $key) && is_scalar($value)) {
                $this->setAttribute('option', $key, $value);
            }
        }
    }
}

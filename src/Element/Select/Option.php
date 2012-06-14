<?php

class Apolo_Component_Formulator_Element_Select_Option
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'select_option';
    public $acceptSubelements = false;
    public $validAttributes = array(
        'default' => array('value', 'label'),
        'option'  => array('selected'),
    );

    public function setElement(array $element)
    {
        foreach (array('value', 'label') as $item) {
            if (!isset($element[$item]) || !is_scalar($element[$item])) {
                throw new DomainException("Option must have a '$item'");
            }
            $this->setAttribute('default', $item, $element[$item]);
        }
        foreach ($element as $key=>$value) {
            if ($this->validAttribute('option', $key)) {
                $this->setAttribute('option', $key, $value);
            }
        }
    }
}

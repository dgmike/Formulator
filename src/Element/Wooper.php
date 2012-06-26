<?php

class Apolo_Component_Formulator_Element_Wooper 
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $needsLabel = false;
    public $validAttributes = array(
        'default' => array('after', 'before'),    
    );
    public $templateType = 'wooper';

    public function setElement(array $element)
    {
        if(!isset($element['before'])) {
            throw new DomainException('You must set the before');
        }

        if(!isset($element['after'])) {
            throw new DomainException('You must set the after');
        }

        $this->setAttribute('default', 'before', $element['before']);
        $this->setAttribute('default', 'after', $element['after']);
    }
}

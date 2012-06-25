<?php

class Apolo_Component_Formulator_Element_Script
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'script';
    public $acceptSubElements = false;
    public $validAttributes = array(
        'default' => array(),
    );

    public function setElement(array $element)
    {
        if ($this->form) {
            $this->form->addMedia('mustache.js');
        }
        if (empty($element['content'])) {
            throw new InvalidArgumentException('Mustache element needs "content"');
        }
        $this->setSubElements(
            array(
                array(
                    'type' => 'html',
                    'content' => $element['content']
                ),
            )
        );
        foreach ($element as $key => $value) {
            if ($this->validAttribute('default', $key, $value)) {
                $this->setAttribute('default', $key, $value);
            }
        }
    }
}

/*vim:set et:tabstop=4:shiftwidth=4:softtabstop=4:*/

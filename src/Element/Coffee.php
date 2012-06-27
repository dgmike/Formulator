<?php

class Apolo_Component_Formulator_Element_Coffee
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'script';
    public $acceptSubElements = false;
    public $validAttributes = array(
        'default' => array('type'),
    );

    public function setElement(array $element)
    {
        if ($this->form) {
            $this->form->addMedia('coffee-script.js');
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
        $element['type'] = 'text/coffeescript';
        foreach ($element as $key => $value) {
            if ($this->validAttribute('default', $key, $value)) {
                $this->setAttribute('default', $key, $value);
            }
        }
    }
}

/*vim:set et:tabstop=4:shiftwidth=4:softtabstop=4:*/

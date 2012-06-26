<?php

class Apolo_Component_Formulator_Element_Mustache
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'mustache';
    public $acceptSubElements = false;
    public $validAttributes = array(
        'default' => array(),
    );

    public function setElement(array $element)
    {
        if ($this->form) {
            $this->form->addMedia('mustache.js');
        }
        if (empty($element['content']) && empty($element['subElements'])) {
            throw new InvalidArgumentException('Mustache element needs "content" or "subElements"');
        }
        if (empty($element['id'])) {
            throw new InvalidArgumentException('Mustache element needs "id"');
        }
        if (empty($element['subElements'])) {
            $subElements = array( array('type' => 'html', 'content' => $element['content']));
        } else {
            $subElements = $element['subElements'];
        }
        $this->setSubElements( $subElements);
        foreach ($element as $key => $value) {
            if ($this->validAttribute('default', $key, $value)) {
                $this->setAttribute('default', $key, $value);
            }
        }
    }
}

/*vim:set et:tabstop=4:shiftwidth=4:softtabstop=4:*/

<?php
class Apolo_Component_Formulator_Element_Button
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'button';
    protected $validTypes = array('button', 'submit', 'reset');

    public  $validAttributes    = array(
        'default' => array('type', 'label'),
        'button' => array('name', 'value', 'id', 'disabled'),
    );

    public function setElement(array $element)
    {
        if (empty($element['_type']) || !is_string($element['_type'])) {
            throw new DomainException('You must set the _type');
        }

        if (!in_array($element['_type'], $this->validTypes)) {
            throw new DomainException(
                '_type must be: ' . implode(', ', $this->validTypes)
            );
        }

        $this->setAttribute('default', 'type', $element['_type']);

        if (isset($element['label'])){
            $this->setAttribute('default', 'label', $element['label']);
        }

        foreach ($element as $k=>$v) {
            if ($this->validAttribute('button', $k)) {
                $this->setAttribute('button', $k, $v);
            }
        }
    }

}

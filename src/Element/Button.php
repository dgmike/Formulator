<?php
class Apolo_Component_Formulator_Element_Button
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'button';
    protected $needsLabel = true;
    protected $type = 'text';

    public  $validAttributes    = array(
        'default' => array('label'),
        'button' => array('_type', 'name', 'value', 'id'),
    );

    public function setElement(array $element)
    {
        if ($this->needsLabel && empty($element['label'])){
            throw new DomainException('This Element Needs Label!');
        }
        if ($this->needsLabel && isset($element['label'])) {
            $this->setAttribute('label', 'name', $element['label']);
        }
        
        $this->setAttribute('button', 'attrs', $this->generateAttrs($element));
    }

    public function generateAttrs(array $element)
    {
        foreach ($this->validAttributes['button'] as $item) {
            if(!isset($element[$item])) {
                continue;
            }
            if('attrs' === $item) {
                continue;
            }
            if('_type' == $item) {
                $this->type = $element[$item];
                continue;
            }
            $this->setAttribute('button', $item, (string) $element[$item]);
        }
        return ' type="' . $this->type . '"' . $this->attributes('button');
    }
}

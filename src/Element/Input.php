<?php
class Apolo_Component_Formulator_Element_Input
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'input';
    protected $needsLabel = true;
    protected $type = 'text';

    public  $validAttributes    = array(
        'label' => array('name'),
        'input' => array('attrs', '_type', 'name', 'value', 'id')
    );

    public function setElement(array $element)
    {
        if ($this->needsLabel && empty($element['label'])){
            throw new DomainException("This Element Needs Label!");
        }
        if ($this->needsLabel && $element['label']){
            $this->setAttribute('label', 'name', $element['label']);
        }
        
        $this->setAttribute('input', 'attrs', $this->generateAttrs($element));
    }

    public function generateAttrs(array $element)
    {
        foreach ($this->validAttributes['input'] as $item) {
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
            $this->setAttribute('input', $item, (string) $element[$item]);
        }
        return ' type="' . $this->type . '"' . $this->attributes('input');
    }
}
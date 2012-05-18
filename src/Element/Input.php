<?php
class Apolo_Component_Formulator_Element_Input
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $templateType = 'input';
    protected $needsLabel = true;
    protected $type = 'text';

    public  $validAttributes    = array(
        'label' => array('content')
    );

    public function setElement(array $element)
    {
        if ($this->needsLabel && empty($element['label'])){
            throw new DomainException("This Element Needs Label!");
        }
        if ($this->needsLabel && $element['label']){
            $this->setAttribute('label', 'content', $element['label']);
        }
        //$this->setAtribute['input','']=$this->generateInputTag($element);
    }

    public function generateInputTag(array $element)
    {
        return sprintf('<input type="%s" />', $this->type);
    }
}
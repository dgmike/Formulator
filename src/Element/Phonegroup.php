<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Repetition.php';

/**
 * Formulator Component Element Phonegroup
 * 
 * This Class create a phone group element 
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Element
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
class Apolo_Component_Formulator_Element_PhoneGroup
    extends Apolo_Component_Formulator_Element_Repetition
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement()
    {
        $this->element['elements'] = array(array());
        parent::setElement();
    }

    protected function setElements()
    {
        $name = $this->element['name'];

        $this->element = array(
            'name' => $name,
            'elements' => array(
                array(
                    'type' => 'radio',  
                    'name' => $name . '.default', 
                    'value' => '['.$this->uniqId.']', 
                    'label' => '',
                    'class' => 'escolhepadrao',
                ),

                array(
                    'type' => 'select', 
                    'name' => $name .'.['.$this->uniqId.'][type]',  
                    'label' => 'Tipo',     
                    'class' => 'phone type', 
                    'values' => array(
                        'home' => 'Residencial', 
                        'cel' => 'Celular', 
                        'work' => 'Trabalho', 
                        'other' => 'Outro',
                    )
                ),

                array(
                    'type' => 'text',   
                    'name' => $name .'.['.$this->uniqId.'][code]',  
                    'label' => 'DDD',      
                    'class' => 'phone code',
                    'maxlength' => 2,
                    //'required' => 'required',
                    //'pattern' => '\d\d',
                ),
                array(
                    'type' => 'text',   
                    'name' => $name .'.['.$this->uniqId.'][phone]', 
                    'label' => 'Telefone', 
                    'class' => 'phone number',
                    'maxlength' => '9',
                    //'required' => 'required',
                    //'pattern' => '\d\d\d\d?-?\d\d\d\d'
                ),
            ),
            'values'   => $this->form->getValues() + array($name . '.number[]' => '[' . $this->uniqId . ']', $name . '.default' => '['.$this->uniqId.']'),
            'form'     => &$this->form,
        );

        parent::setElements();
    }
}

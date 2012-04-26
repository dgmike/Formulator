<?php

/**
 * Formulator Component Element Repetition
 * 
 * This Class do the element repetition 
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
class Apolo_Component_Formulator_Element_Repetition
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement()
    {
        if (empty($this->element['name'])) {
            trigger_error('Name is mandatory in repetition element type.');
            $this->element['name'] = '';
        }
        if (empty($this->element['elements'])) {
            trigger_error('Elements is mandatory in repetition element type.');
            $this->element['elements'] = array();
        }

        $this->attrs['fieldsetopen']  = '<fieldset'.$this->getClass().'>';
        $this->attrs['fieldsetclose'] = '</fieldset>';

        $this->setUp();
        $this->setContainerAttrs();
        $this->setElements();

        if (!empty($this->element['elementsRepetition'])) {
            $elementsRepetition = array();
            $instance           = new ReflectionClass(get_class($this->form));
            foreach ($this->element['elementsRepetition'] as $k => $_er) {
                $object = $instance->newInstance();
                $object->setForm(&$this->form);
                $object->config(array('elements' => $_er));
                $elementsRepetition[] = $object;
            }
            $this->attr['subElements'] = $elementsRepetition;
        }

        foreach (array('before', 'after') as $_area) {
            if (!empty($this->element[$_area])) {
                $elements = array();
                $instance = new ReflectionClass(get_class($this->form));
                foreach ($this->element[$_area] as $k => $_er) {
                    $object = $instance->newInstance();
                    $object->setForm(&$this->form);
                    $object->config(array('elements' => $_er));
                    $elements[] = $object;
                }
                $this->{$_area} = $elements;
            }
        }

    }

    protected function setUp()
    {
        $this->form->addMedia('webforms2.js');

        $this->uniqId = 'repetition_' . uniqid();
        $this->attrs['uniq_id'] = $this->uniqId;
        $this->attrs['container'] = '';
    }

    protected function setContainerAttrs()
    {
        $repeatValidAttributes = array(
            'repeat-start', 'repeat-min', 'repeat-max'
        );
        $repeatAttributes      = array();

        foreach ($repeatValidAttributes as $attr) {
            if (!empty($this->element[$attr])) {
                $repeatAttributes[] = sprintf(
                    '%s="%d"', $attr, $this->element[$attr]
                );
                unset($this->element[$attr]);
            }
        }
        $repeatAttributes = implode(' ', $repeatAttributes);
        $this->attrs['containerattrs'] = 'id="'
                                       . $this->uniqId . '" repeat="template" '
                                       . $repeatAttributes;
    }

    protected function setElements()
    {
        $name = $this->element['name'];
        array_unshift($this->element['elements'], array(
            'type' => 'hidden', 
            'name' => $name . '.index[]',
        ));
        array_push(
            $this->element['elements'],
            array(
                'type' => 'button', 
                'buttonType' => 'move-down', 
                'class' => 'move-up',   
                'text' => '&#x2193;',
            ),
            array(
                'type' => 'button', 
                'buttonType' => 'move-up',   
                'class' => 'move-down', 
                'text' => '&#x2191;',
            ),
            array(
                'type' => 'button', 
                'buttonType' => 'remove',    
                'class' => 'remove',    
                'text' => 'remove',
            )
        );
        $this->element['values'] = $this->form->getValues() + array(
            $name . '.index[]' => '[' . $this->uniqId . ']'
        );
        $this->element['form'] =& $this->form;
        $reflectionClass = new ReflectionClass(get_class($this->form));
        $this->elements = $reflectionClass->newInstance();
        $this->elements->setForm(&$this->form);
        $this->elements->config($this->element);
    }
}


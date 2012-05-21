<?php
/**
 * Formulator Component Radiogroup Element
 *
 * Use this element to create  a group of radios.
 *
 * PHP Version 5.2
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

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Fieldset.php';

/**
 * This Class create a group of radios on the form.
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
class Apolo_Component_Formulator_Element_Radiogroup
    extends Apolo_Component_Formulator_Element_Fieldset
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement(array $element)
    {
        if( !isset($this->element['name']) ) {
            trigger_error('"name" Attribute Mandatory!');
        }
        
        $name = $this->element['name'];

        if( !isset($this->element['elements']) ) {
            trigger_error('"elements" Attribute Mandatory!');
        }
        
        foreach ($this->element['elements'] as $key=>$value) {
            $this->element['elements'][$key] = $value + 
                array(
                    'type' => 'radio', 
                    'name' => $name
                );    
        }
        unset($this->element['name']);
    
        parent::setElement();
    }
}
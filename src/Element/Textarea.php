<?php

/**
 * Formulator Component Element Textarea
 * 
 * This Class create the textarea element 
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
class Apolo_Component_Formulator_Element_Textarea
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement(array $element)
    {
        $input = '<textarea '
               . $this->makeAttributes()
               .'>'
               . $this->getValue(false)
               . '</textarea>';
        $this->attrs['input'] = $input;
    }
}

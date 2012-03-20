<?php

/**
 * Formulator Component Element Password
 * 
 * This Class create the Password Element 
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
class Apolo_Component_Formulator_Element_Password
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement()
    {
        $input = '<input type="password"'
               . $this->makeAttributes()
               . $this->getValue()
               . '/>';
        $this->attrs['input'] = $input;
    }
}

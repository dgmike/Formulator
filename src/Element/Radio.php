<?php
/**
 * Formulator Component Radio Element
 *
 * Use this element to create the input type radio.
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

/**
 * This Class create the <samp>input</samp> type <samp>radio</samp> on the form.
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
class Apolo_Component_Formulator_Element_Radio
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This method create the <samp>input</samp> type <samp>radio</samp> 
     * on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
        $this->attrs['input'] = '<input type="radio"' 
                              . $this->makeAttributes() 
                              . $this->getValue().' />';
    }
}


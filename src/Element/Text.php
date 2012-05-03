<?php
/**
 * Formulator Component Text Element
 *
 * Use this element to create the input type text.
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
 * This Class create the <samp>input</samp> type <samp>text</samp> on the form.
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
class Apolo_Component_Formulator_Element_Text
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This method create the <samp>input</samp> type <samp>text</samp> 
     * on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
        $input = '<input type="text"'
               . $this->makeAttributes()
               . $this->getValue(true, false)
               . '/>';
        $this->attrs['input'] = $input;
    }
}

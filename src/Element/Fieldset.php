<?php
/**
 * Formulator Component Fieldset Element
 *
 * Use this element to create a <samp>fieldset</samp> on the form.
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
 * This Class create the <samp>fieldset</samp> on the form.
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
class Apolo_Component_Formulator_Element_Fieldset
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This method create the <samp>fieldset</samp> with the element 
     * <samp>legend</samp> on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
        $this->attrs['fieldsetopen']  = '<fieldset'.$this->makeAttributes().'>';
        $this->attrs['fieldsetclose'] = '</fieldset>';
        $this->attrs['legend'] = $this->getLabel();
    }
}

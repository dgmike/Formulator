<?php
/**
 * Formulator Component Button Element
 *
 * Use this element to create a <samp>button</samp> into the form.
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
 * This Class create the <samp>button</samp> into the form.
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
class Apolo_Component_Formulator_Element_Button
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This method create the <samp>button</samp> with the text <samp>ok</samp>
     * on the form.
     * 
     * @return void
     */
    public function setElement()
    {
        $especialAttributes = array(
            'text'       => 'ok',
            'buttonType' => 'button',
        );
        $especial = array();
        foreach ($especialAttributes as $attribute => $defaultAttr) {
            if (array_key_exists($attribute, $this->element)) {
                $especial[$attribute] = $this->element[$attribute];
                unset($this->element[$attribute]);
            } else {
                $especial[$attribute] = $defaultAttr;
            }
        }
        $this->attrs['attrs'] = ' type="' . $especial['buttonType'].'"' 
                                          . $this->makeAttributes();
        $this->attrs['label'] = $especial['text'];
    }
}

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
    public $validAttributes = array(
        'legend' => array('tag'),
    );
    public $templateType = 'fieldset';

    /**
     * This method create the <samp>fieldset</samp> with the element 
     * <samp>legend</samp> on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
        if (isset($element['legend'])
            && is_string($element['legend']) 
            && $element['legend']
        ) {
            $legend = htmlentities($element['legend']);
            $legend = sprintf('<legend>%s</legend>', $legend);
            $this->setAttribute('legend', 'tag', $legend);
        }
    }
}

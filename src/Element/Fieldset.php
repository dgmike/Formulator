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
     * This is the list of valid attributes that the fieldset element accepts
     *
     * @access public
     * @var array
     */
    public $validAttributes = array(
        'legend'   => array('tag'),
        'fieldset' => array('id', 'class'),
    );
    /**
     * This is the template type
     *
     * @access public
     * @var string
     */
    public $templateType = 'fieldset';

    /**
     * This method create the <samp>fieldset</samp> with the element 
     * <samp>legend</samp> on the form.
     * 
     * @param array $element the array of element's options
     *
     * @return void
     */
    public function setElement(array $element)
    {
        if (isset($element['legend'])
            && is_string($element['legend']) 
            && $element['legend']
        ) {
            $legend = htmlentities($element['legend'], ENT_QUOTES, "UTF-8");
            $legend = sprintf('<legend>%s</legend>', $legend);
            $this->setAttribute('legend', 'tag', $legend);
        }
        foreach ($this->validAttributes['fieldset'] as $item) {
            if (!empty($element[$item]) && is_string($element[$item])) {
                $this->setAttribute('fieldset', $item, $element[$item]);
            }
        }
    }
}

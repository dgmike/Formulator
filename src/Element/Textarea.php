<?php
/**
 * Formulator Component Textarea Element
 *
 * Use this element to create a <samp>textarea</samp> on the form.
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
 * This Class create the <samp>textarea</samp> on the form.
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
    public $validAttributes = array(
        'default'  => array('label'),
        'label'    => array('id', 'class'),
        'textarea' => array('rows', 'cols', 'name', 'readonly', 'disabled'),
    );
    public $templateType = 'textarea';

    /**
     * This method create the <samp>textarea</samp> with the element 
     * <samp>legend</samp> on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
        if(empty($element['label']) || !is_string($element['label'])) {
            trigger_error('You must set the label');
        }

        $this->setAttribute('default', 'label', $element['label']);

        if(empty($element['name']) || !is_string($element['name'])) {
            trigger_error('You must set the name');
        }

        foreach ($this->validAttributes['label'] as $item) {
            if (!empty($element[$item]) && is_string($element[$item])) {
                $this->setAttribute('label', $item, $element[$item]);
            }
        }

        foreach ($this->validAttributes['textarea'] as $item) {
            if (!empty($element[$item])) {
                $val = $element[$item];
                $isRowCol = in_array($item, array('rows', 'cols'));
                if($isRowCol && (!ctype_digit($val) && !is_int($val))) {
                    trigger_error("$item must be integer or string (as digit)");
                }
                $this->setAttribute('textarea', $item, $val);
            }
        }
    }
}

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
     * do not accept subElements, it uses "values" instead
     *
     * @access public
     * @var string
     */
    public $acceptSubElements = false;
    /**
     * This is the template type
     *
     * @access public
     * @var string
     */
    public $templateType = 'subelements';
    /**
     * This is the list attributes that the radio element accepts
     *
     * @access public
     * @var array
     */
    public $fieldsetAttributes = array('class', 'id');

    /**
     * This method create the group of elements with radios
     * on the form.
     *
     * @param array $element the array of element's options
     *
     * @return void
     */
    public function setElement(array $element)
    {
        foreach (array('label', 'values', 'name') as $item) {
            if (empty($element[$item])) {
                throw new DomainException(
                    "You must set $item in radio element type"
                );
            }
        }
        if (!is_array($element['values'])) {
            throw new DomainException(
                "\$element['values'] must be an associative array"
            );
        }
        $radios = array();
        foreach ($element['values'] as $value => $label) {
            $radio = array(
                'type'  => 'input_radio',
                'name'  => $element['name'],
                'label' => $label,
                'value' => $value,
            );
            array_push($radios, $radio);
        }
        $fieldset = array(
                'type'   => 'fieldset',
                'legend' => $element['label'],
                'subElements' => $radios,
            );
        foreach ($this->fieldsetAttributes as $item) {
            if (!empty($element[$item])) {
                $fieldset[$item] = $element[$item];
            }
        }
        $this->setSubElements(array($fieldset));
    }
}

<?php
/**
 * Formulator Component Element Input Radio
 *
 * Used to create a Input Radio Element
 *
 * PHP Version 5.2
 *
 * @category  Component
 * @package   Formulator
 * @author    Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author    Michell Campos <michell@corp.virgula.com.br>
 * @copyright 2011-2012 Virgula S/A
 * @license   Virgula Copyright
 * @link      http://virgula.uol.com.br
 */

/**
 * loading the Input class
 */
$ds   = DIRECTORY_SEPARATOR;
$file = realpath(__DIR__ . $ds . '..' . $ds . 'Input.php');
require_once $file;
unset($ds, $file);

/**
 * Formulator Component Element Input Radio
 * 
 * This Class create the Input Radio element with his options 
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
class Apolo_Component_Formulator_Element_Input_Radio
    extends Apolo_Component_Formulator_Element_Input
    implements Apolo_Component_Formulator_ElementInterface
{
     /**
     * This is the template type
     * It uses the 'choice' template type
     *
     * @access public
     * @var string
     */
    public    $templateType = 'choice';
    /**
     * This defines if the legend is mandatory
     *
     * @access protected
     * @var boolean
     */
    protected $needsLabel   = true;
    /**
     * This is the element type
     *
     * @access protected
     * @var string
     */
    protected $type         = 'radio';

    public $validAttributes    = array(
        'label' => array('name'),
        'input' => array(
            'attrs',
            '_type',
            'name',
            'value',
            'checked',
            'id',
            'disabled',
        ),
    );

    public function setElement(array $element)
    {
        if($this->form) {
            $values = $this->form->getValues();
            $name   = preg_replace('@\[\]$@', '', $element['name']);

            if(!empty($values[$name]) && $element['_value'] == $values[$name]) {
                $element['checked'] = 'checked';
            }

            //haaaaaaaaack Pegadinha do malandro!
            if (isset($element['_value'])) {
                $element['value'] = $element['_value']; 
            }
        }
        parent::setElement($element);
    }
}

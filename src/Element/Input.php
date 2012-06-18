<?php
/**
 * Formulator Component Element Input
 *
 * Used to configure and render all the Input Elements
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
 * Formulator Component Element Input
 * 
 * This Class create the Input element with his options 
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
class Apolo_Component_Formulator_Element_Input
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This is the template type
     *
     * @access public
     * @var string
     */
    public $templateType = 'input';
    /**
     * This defines if the legend is mandatory
     *
     * @access protected
     * @var boolean
     */
    protected $needsLabel = true;
    /**
     * This is the default element type
     *
     * @access protected
     * @var string
     */
    protected $type = 'text';

    /**
     * This is the list of valid attributes that the input element accepts
     *
     * @access public
     * @var array
     */
    public  $validAttributes    = array(
        'label' => array('name'),
        'input' => array('attrs', '_type', 'name', 'value', 'id'),
    );
    
    /**
     * Creates the Input element with his options
     *
     * @param array $element the array of element's options
     *
     * @return the created element
     */
    public function setElement(array $element)
    {
        if ($this->needsLabel && empty($element['label'])) {
            throw new DomainException('This Element Needs Label!');
        }
        if (isset($element['label'])) {
            $this->setAttribute('label', 'name', $element['label']);
        }
        
        $this->setAttribute('input', 'attrs', $this->generateAttrs($element));
    }

    /**
     * Generates the Input element's options using the setAttribute method
     *
     * @param array $element the array of input's options
     *
     * @return a string containing all the input attributes (html)
     */
    public function generateAttrs(array $element)
    {
        foreach ($this->validAttributes['input'] as $item) {
            if (!isset($element[$item])) {
                continue;
            }
            if ('attrs' === $item) {
                continue;
            }
            if ('_type' == $item) {
                $this->type = $element[$item];
                continue;
            }
            $this->setAttribute('input', $item, (string) $element[$item]);
        }
        return ' type="' . $this->type . '"' . $this->attributes('input');
    }
}

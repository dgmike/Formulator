<?php
/**
 * Formulator Component Element Button
 *
 * Used to configure and render all the Button Elements
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
 * Formulator Component Element Button
 * 
 * This Class create the Button element with his options 
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
     * This is the template type
     *
     * @access public
     * @var string
     */
    public $templateType = 'button';
    /**
     * This is the list of valid types that the button element accepts
     *
     * @access protected
     * @var array
     */
    protected $validTypes = array('button', 'submit', 'reset');
    /**
     * This is the list of valid attributes that the input element accepts
     *
     * @access public
     * @var array
     */
    public  $validAttributes    = array(
        'default' => array('type', 'label'),
        'button' => array('name', 'value', 'id', 'disabled'),
    );
    
    /**
     * Creates the Button element with his options
     *
     * @param array $element the array of element's options
     *
     * @return the created element
     */
    public function setElement(array $element)
    {
        if (empty($element['_type']) || !is_string($element['_type'])) {
            throw new DomainException('You must set the _type');
        }

        if (!in_array($element['_type'], $this->validTypes)) {
            throw new DomainException(
                '_type must be: ' . implode(', ', $this->validTypes)
            );
        }

        $this->setAttribute('default', 'type', $element['_type']);

        if (isset($element['label'])) {
            $this->setAttribute('default', 'label', $element['label']);
        }

        foreach ($element as $k=>$v) {
            if ($this->validAttribute('button', $k)) {
                $this->setAttribute('button', $k, $v);
            }
        }
    }

}

<?php
/**
 * Formulator Set of elements
 *
 * The above classes and interfaces defines the Elements of Formulator
 * class. Use the interface to know what to do and use the Element class
 * to help on more usual methods.
 *
 * PHP Version 5.2
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */

/**
 * Formulator Component Formulator Element Interface
 * 
 * This Class has a indice with the methods to be used by another class 
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
interface Apolo_Component_Formulator_ElementInterface
{
    /**
     * Sets the element
     *
     * This method can set an element if this class was implemented in another 
     * class.
     *
     * @param array $element The element configuration
     *
     * @see ./Element/Textarea.php
     * @return void
     */
    public function setElement(array $element);

    /**
     * Sets the subelements, if is validAttribute
     *
     * @param array $elements The subelements
     *
     * @return void
     */
    public function setSubElements(array $elements);

    /**
     * Verifies if an attribute is a valid attribute
     *
     * @param string $context   Context of attribute, can be label/input/etc
     * @param string $attribute An attribute name
     * @param string $value     An attribute value
     *
     * @return void
     */
    public function setAttribute(
        $context = 'default', $attribute = '', $value = ''
    );

    /**
     * Verifies if an attribute is a valid attribute
     *
     * @param string $context   Context of attribute, can be label/input/etc
     * @param string $attribute An attribute name
     *
     * @return bool
     */
    public function validAttribute($context = 'default', $attribute = '');

    /**
     * Retrive all attributes in HTML
     *
     * @param string $context Context of attribute, can be label/input/etc
     *
     * @return string
     */
    public function attributes($context = 'default');

    /**
     * Port to accept subelements
     *
     * @param boolean $accept Accepts or not accepts
     * @return void
     */
    public function setAcceptSubElements($accept);

    /**
     * Retrives a determinated attribute
     *
     * @param string $context       Context of attribute, can be label/input/etc
     * @param string $attributeName The name of attribute
     * @param bool   $showAttribute Makes return the attribute name
     * @param bool   $escaped       Makes return escape the value
     *
     * @return string
     */
    public function attribute(
        $context = '', $attributeName = 'value', $showAttribute = true,
        $escaped = true
    );

    /**
     * Sets the value of element
     *
     * @param string $value The value
     * 
     * @return void
     */
    public function setValue($value = '');

    /**
     * Retrives the value
     *
     * @return string
     */
    public function getValue();
}

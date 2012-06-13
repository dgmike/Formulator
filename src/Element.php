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

require_once __DIR__ . DIRECTORY_SEPARATOR . 'ElementInterface.php';

/**
 * Formulator Component Formulator Element
 *
 * This abstract Class has methods to make and get attributes and get values
 * of the form elements.
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 * @abstract
 */
abstract class Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * Informs if this objects accepts subelements
     *
     * @var bool
     */
    protected $acceptSubElements = true;

    /**
     * Template type
     *
     * The template uses this key know what kind of element it needs to render
     *
     * @var string
     */
    public  $templateType       = 'default';

    /**
     * Set of valid attributes
     *
     * Must have a context and valid attributes
     *
     * <pre>
     * array(
     *   'label' => array('for', 'class', 'id'),
     * );
     * </pre>
     *
     * @var array
     */
    public  $validAttributes    = array(
        // 'context' => array('attributes')
    );

    /**
     * Attributes generated
     *
     * When script sets the element, it set some attributes to render in
     * future. This are the generated attributes.
     *
     * <pre>
     * array(
     *   'label' => array('for', 'class', 'id'),
     *   'input' => array('type', 'name', 'value'),
     * );
     * </pre>
     *
     * @var array
     */
    public  $attritubes         = array();

    /**
     * Value for this element
     *
     * @var string
     * @protected
     */
    protected $value = '';

    /**
     * Range of subelements
     *
     * This are an array containing various
     * {@link Apolo_Component_Formulator_Element elements}
     *
     * @var array
     */
    public  $subElements        = array();

    /**
     * Parent element
     *
     * @var Apolo_Component_Formulator_Element
     */
    protected $parent = null;

    /**
     * This method is caller internally by the Formulator::element
     *
     * @param array $element The element configuration
     *
     * @internal
     * @final
     */
    final function __construct(array $element)
    {
        $this->setElement($element);
        if ($this->acceptSubElements && !empty($element['subElements'])) {
            $this->setSubElements($element['subElements']);
        }
        if (isset($element['value'])) {
            $this->value = (string) $element['value'];
        }
    }

    /**
     * Verifies if an attritube is valid
     *
     * This method verifies over configuration if this attribute is valid for
     * determinated context.
     *
     * **Note:** All elements accepts <code>data-*</code> attribute
     *
     * @param string $context   Context where the attribute can be
     * @param string $attribute Name of attribue
     *
     * @throws DomainException when passed not scalar parameters
     * @uses Apolo_Component_Formulator_Element::$validAttributes
     * @return bool
     */
    public function validAttribute($context = 'default', $attribute = '')
    {
        foreach (array('context', 'attribute') as $item) {
            if (!is_scalar($$item)) {
                throw new InvalidArgumentException(
                    'Invalid argument for ' . $item
                );
            }
            $$item = (string) $$item;
        }
        if (   isset($this->validAttributes[$context])
            && 'data-' === substr($attribute, 0, 5)
        ) {
            return true;
        }
        return isset($this->validAttributes[$context])
            && in_array($attribute, $this->validAttributes[$context]);
    }

    /**
     * Sets the attribute to future response
     *
     * This method tries to set an attribute validatting the attribute before it
     *
     * @param string $context   Context where the attribube will be setted
     * @param string $attribute Name of attribute
     * @param string $value     Value of attribute
     *
     * @return void
     */
    public function setAttribute(
        $context = 'default', $attribute = '', $value = ''
    ) {
        foreach (array('context', 'attribute', 'value') as $item) {
            if (!is_scalar($$item)) {
                throw new InvalidArgumentException(
                    'Invalid argument for ' . $item
                );
            }
            $$item = (string) $$item;
        }
        if (!$this->validAttribute($context, $attribute)) {
            throw new InvalidArgumentException(
                'Invalid attribute for: ' . $context . '/' . $attribute
            );
        }
        if (!isset($this->attributes[$context])) {
            $this->attributes[$context] = array();
        }
        $this->attributes[$context][$attribute] = $value;
    }

    /**
     * Retrive all attributes in HTML
     *
     * @param string $context Context of attribute, can be label/input/etc
     *
     * @return string
     */
    public function attributes($context = 'default')
    {
        if (!is_scalar($context)) {
            throw new InvalidArgumentException('Invalid argument type');
        }
        $context = (string) $context;
        if (empty($this->attributes[$context])) {
            return '';
        }
        $attributes = array();
        foreach (array_keys($this->attributes[$context]) as $item) {
            $attributes[] = $this->attribute($context, $item);
        }
        return implode('', $attributes);
    }

    /**
     * Gets an attribute
     *
     * This method retrives an attribute over the content element
     *
     * @param string $context       Context where the attribute will be getted
     * @param string $attribute     Name of attribute
     * @param bool   $showAttribute Shows the attribute name
     * @param bool   $escaped       Returns the value escaped (htmlentities)
     *
     * @uses Apolo_Component_Formulator_Element::_validateAttributeArgs
     * @return string
     */
    public function attribute(
        $context = '', $attribute = 'value', $showAttribute = true,
        $escaped = true
    ) {
        $this->_validateAttributeArgs(
            $context, $attribute, $showAttribute, $escaped
        );
        if (!$this->validAttribute($context, $attribute)) {
            return '';
        }
        if (!isset($this->attributes)
            || !isset($this->attributes[$context])
            || !isset($this->attributes[$context][$attribute])
        ) {
            return '';
        }
        $value = $this->attributes[$context][$attribute];
        $value = $this->_formatAttribute($value, $escaped);
        if ($showAttribute) {
            $value = ' ' . $attribute . '="'.$value.'"';
        }
        return $value;
    }

    /**
     * Validate typage attributes
     *
     * @param string $context       Context where the attribute will be getted
     * @param string $attribute     Name of attribute
     * @param bool   $showAttribute Shows the attribute name
     * @param bool   $escaped       Returns the value escaped (htmlentities)
     *
     * @throws InvalidArgumentException when $context or $attribute are not
     *  scalar values
     * @throws InvalidArgumentException when $showAttribute or $escaped are not
     *  boolean values
     * @return string
     */
    private function _validateAttributeArgs(
        $context, $attribute, $showAttribute, $escaped
    ) {
        if (!is_scalar($context)) {
            throw new InvalidArgumentException(
                'Invalid argument for context'
            );
        }
        if (!is_scalar($attribute)) {
            throw new InvalidArgumentException(
                'Invalid argument for attribute'
            );
        }
        if (!is_bool($showAttribute)) {
            throw new InvalidArgumentException(
                'Invalid argument for showAttribute'
            );
        }
        if (!is_bool($escaped)) {
            throw new InvalidArgumentException(
                'Invalid argument for escaped'
            );
        }
    }

    /**
     * Formats an attribute
     *
     * @param string $value   Value of attribute
     * @param bool   $escaped Returns the value escaped (htmlentities)
     *
     * @return string
     */
    private function _formatAttribute($value, $escaped)
    {
        if ($escaped) {
            $value = htmlentities($value, ENT_QUOTES);
        }
        return $value;
    }

    /**
     * Sets the subelements, if is validAttribute
     *
     * @param array $subElements The subelements
     *
     * @return void
     */
    public function setSubElements(array $subElements)
    {
        $this->subElements = array();
        foreach ($subElements as $element) {
            $element = Apolo_Component_Formulator::element($element);
            $this->subElements[] = $element;
        }
    }

    /**
     * Sets the value of element
     *
     * @param string $value The value
     *
     * @return void
     */
    public function setValue($value = '')
    {
        $this->value = $value;
    }

    /**
     * Retrives the value
     *
     * @param bool $escaped Escapes the value
     *
     * @return string
     */
    public function getValue($escaped = true)
    {
        $value = (string) $this->value;
        if (!is_bool($escaped)) {
            throw new InvalidArgumentException(
                'Invalid argument, must be boolean type'
            );
        }
        if ($escaped) {
            $value = htmlentities($value, ENT_QUOTES, 'UTF-8');
        }
        return $value;
    }

    /**
     * Retriver the aceept of subElements
     *
     * @return bool
     */
    public function acceptSubElements()
    {
        return $this->acceptSubElements;
    }

    /**
     * Sets parent element
     *
     * This method is called on render, when this element is a subElement
     *
     * @param Apolo_Component_Formulator_Element $parent Parent element
     *
     * @return void
     */
    public function setParent(Apolo_Component_Formulator_Element $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Retrives the parent Element
     *
     * @return Apolo_Component_Formulator_Element | null
     */
    public function getParent()
    {
        return $this->parent;
    }
}
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

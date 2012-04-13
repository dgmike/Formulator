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
     * This method can set an element if this class was implemented in another 
     * class 
     * 
     * @example ./Element/Textarea.php
     *
     * @return void
     */
    public function setElement();

    /**
     * makeAttributes 
     * 
     * @return void
     */
    public function makeAttributes();

    /**
     * getValue 
     * 
     * @param mixed $attribute 
     * @param mixed $escaped 
     *
     * @return void
     */
    public function getValue($attribute = true, $escaped = true);
}

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
 */
abstract class Apolo_Component_Formulator_Element
{
    public $attrs = array();
    protected $element = array();
    protected $values = array(); 

    // public function __construct($element, array $values, $form)
    public function __construct($element)
    {
    	return;
        $this->form    =& $form;
        $this->element =  $element;

        if ($values) {
            $this->values = $values;
        }
        $this->attrs['type'] = $element['type'];
        if (isset($element['label'])) {
            $this->attrs['label'] = $element['label'];
        }
        $this->setElement($element);
        if (isset($this->element['elements'])) {
            $config = array(
                'elements' => $this->element['elements'],
                'values'   => !empty($this->element['values']) ? $this->element['values'] : $values,
                'form'     => &$form,
            );
            $reflectionClass = new ReflectionClass(get_class($form));
            $this->elements = $reflectionClass->newInstanceArgs();
            $this->elements->setForm($form);
            $this->elements->config($config);
        }
    }

    public function makeAttributes()
    {
        $attributes = array();
        foreach($this->element as $key => $value) {
            if (
                in_array($key, array('elements', 'label', 'value', 'type', 'validation'))
            || !is_scalar($value)
            ) {
                continue;
            }            
            $attributes[] = $key . '="'.htmlentities($value, ENT_QUOTES).'"';
        }        
        if ($attributes) {
            return ' ' . implode(' ', $attributes);
        }        
    }

    private function _getAttribute($attributeName = 'value', $attribute = true, $escaped = true)
    {
        $value = '';
        if ('value' == $attributeName && isset($this->values[$this->element['name']])) {
            $value = $this->values[$this->element['name']];                            
        } else {
            if (!empty($this->element[$attributeName])) {
                $value = $this->element[$attributeName];
            }
        }        

        /**
         * Get value post if isset session         
         */
        if (isset($_SESSION['temp_post']) && $attributeName == 'value') {
            foreach ($_SESSION['temp_post'] as $k => $v) {
                $bf = array('[', ']');
                $af = array('.', '');
                $ne = str_replace($bf, $af, $this->element['name']);
                if ($ne == $k) {
                    $value = utf8_decode($v);
                }
            }
        }

        if ($value) {
            if ($escaped) {
                $value = htmlentities($value, ENT_QUOTES);
            }
            if ($attribute) {            
                $value = ' ' . $attributeName . '="'.$value.'"';
            }
        }
        
        return $value;
    }

    public function getValue($attribute = true, $escaped = true)
    {
        return $this->_getAttribute('value', $attribute, $escaped);
    }

    public function getClass($attribute = true, $escaped = true)
    {
        return $this->_getAttribute('class', $attribute, $escaped);
    }

    public function __call($method, $args)
    {
        if ('get' === substr($method, 0, 3)) {
            $attribute = strtolower(substr($method, 3));
            if ('elements' !== $attribute && isset($this->attrs[$attribute])) {
                return (string) $this->attrs[$attribute];
            } else {
                trigger_error('Invalid attribute: ' . $attribute);
            }
        }
        trigger_error('Method invalid: ' . $method, E_USER_ERROR);
    }
}

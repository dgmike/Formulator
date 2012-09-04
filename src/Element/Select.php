<?php
/**
 * Formulator Component Select Element
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
 * Formulator Component Element Select
 * 
 * This Class create the Select element with his options 
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
class Apolo_Component_Formulator_Element_Select
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
    public $templateType = 'select';
    /**
     * This is the list of valid attributes that the select element accepts
     *
     * @access public
     * @var array
     */
    public $validAttributes = array(
        'default' => array('name'),
        'label'   => array('name'),
        'select'  => array(
            // based on
            // http://www.w3.org/TR/2012/WD-html5-20120329/the-select-element.html#the-select-element
            'autofocus', 'disabled', 'form', 'multiple',
            /*'name', // this is used in default */
            'required', 'size',
            // global attributes
            // http://www.w3.org/TR/2012/WD-html5-20120329/global-attributes.html#global-attributes
            'accesskey', 'class', 'contenteditable', 'contextmenu', 'dir',
            'draggable', 'dropzone', 'hidden', 'id', 'lang', 'spellcheck',
            'style', 'tabindex', 'title', 'translate',
            // event attributes
            'onabort', 'onblur', 'oncanplay', 'oncanplaythrough',
            'onchange', 'onclick', 'oncontextmenu', 'oncuechange',
            'ondblclick', 'ondrag', 'ondragend', 'ondragenter', 
            'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 
            'ondurationchange', 'onemptied', 'onended', 'onerror', 
            'onfocus', 'oninput', 'oninvalid', 'onkeydown', 'onkeypress', 
            'onkeyup', 'onload', 'onloadeddata', 'onloadedmetadata', 
            'onloadstart', 'onmousedown', 'onmousemove', 'onmouseout', 
            'onmouseover', 'onmouseup', 'onmousewheel', 'onpause', 'onplay',
            'onplaying', 'onprogress', 'onratechange', 'onreset',
            'onscroll', 'onseeked', 'onseeking', 'onselect', 'onshow', 
            'onstalled', 'onsubmit', 'onsuspend', 'ontimeupdate', 
            'onvolumechange', 'onwaiting',
        ),
    );
    
    /**
     * This method create the group of elements with selects
     * on the form.
     *
     * @param array $element the array of element's options
     *
     * @return void
     */
    public function setElement(array $element)
    {
        if (empty($element['name'])) {
            throw new DomainException('Select needs "name"');
        }
        $this->setAttribute('default', 'name', (string) $element['name']);
        foreach (array_keys($element) as $attribute) {
            if ($this->validAttribute('select', $attribute)) {
                $this->setAttribute('select', $attribute, $element[$attribute]);
            }
        }
        if (!empty($element['label'])) {
            $name = sprintf('<span>%s</span>', (string) $element['label']);
            $this->setAttribute('label', 'name', $name);
        }
        if (!empty($element['values']) && is_array($element['values'])) {
            $options = array();
            foreach ($element['values'] as $value => $label) {
                $option = array(
                    'type'  => 'select_option',
                    'name'  => $element['name'],
                    'value' => $value,
                    '_value' => $value,
                    'label' => $label,
                );
                array_push($options, $option);
            }
            $this->setSubElements($options);
        }
        if ($this->attribute('label', 'name')) {
            $this->setAttribute('label', 'name', $name);
        }
    }
}

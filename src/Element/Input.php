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
	'input' => array(
		// used by element ui
		'attrs', '_type', 
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
		// particular defined attributes
		// http://www.w3.org/TR/2012/WD-html5-20120329/the-input-element.html#the-input-element
		'accept', 'alt', 'autocomplete', 'autofocus', 'checked', 
		'dirname', 'disabled', 'form', 'formaction', 'formenctype', 
		'formmethod', 'formnovalidate', 'formtarget', 'height', 'list', 
		'max', 'maxlength', 'min', 'multiple', 'name', 'pattern', 
		'placeholder', 'readonly', 'required', 'size', 'src', 'step', 
		'type', 'value', 'width',
                // mozilla specification
		// https://developer.mozilla.org/en/HTML/Element/Input
                'mozactionhint', 'x-moz-errormessage',
	),
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
	foreach ($element as $key => $value) {
		if (in_array($key, array('type', 'attrs'))) {
			continue;
		}
		if ('_type' === $key) {
			$this->type = $value;
			continue;
		}
		if ($this->validAttribute('input', $key)) {
			$this->setAttribute('input', $key, (string) $value);
		}

	}
        return ' type="' . $this->type . '"' . $this->attributes('input');
    }
}

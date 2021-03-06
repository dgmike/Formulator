<?php

/**
 * Formulator Component Element Tinymce
 * 
 * This Class add the element textarea with Tinymce 
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
class Apolo_Component_Formulator_Element_Tinymce
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This is the list of valid attributes that the textarea element accepts
     *
     * @access public
     * @var array
     */
    public $validAttributes = array(
        'default'  => array('label'),
        'label'    => array('id', 'class'),
        'textarea' => array('rows', 'cols', 'name', 'readonly', 'disabled'),
    );
    /**
     * This is the template type
     *
     * @access public
     * @var string
     */
    public $templateType = 'textarea';

    /**
     * This method create the <samp>textarea</samp> with the element 
     * <samp>legend</samp> on the form.
     *
     * @param array $element the array of element's options
     *
     * @return void
     */
    public function setElement(array $element)
    {
        $this->form->addMedia('tinymce/jscripts/tiny_mce/tiny_mce_dev.js');
        $this->form->addMedia('tinymce.js');

        if (empty($element['label']) || !is_string($element['label'])) {
            throw new DomainException('You must set the label');
        }

        $this->setAttribute('default', 'label', $element['label']);

        if (empty($element['name']) || !is_string($element['name'])) {
            throw new DomainException('You must set the name');
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
                if ($isRowCol && (!ctype_digit($val) && !is_int($val))) {
                    throw new DomainException("$item must be integer or string (as digit)");
                }
                $this->setAttribute('textarea', $item, $val);
            }
        }
    }
}

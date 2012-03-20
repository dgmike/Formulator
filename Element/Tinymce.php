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
    public function setElement()
    {
        #$this->form->addMedia('tiny_mce/jquery.tinymce.js');
        #$this->form->addMedia('tiny_mce/tiny_mce.js');
        #$this->form->addMedia('tinymce.js');

        $input = '<textarea class="tinymce" '
               . $this->makeAttributes()
               .'>'
               . $this->getValue()
               . '</textarea>';
        $this->attrs['input'] = $input;
    }
}

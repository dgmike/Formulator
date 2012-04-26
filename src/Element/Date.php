<?php

/**
 * Formulator Component Element Date
 * 
 * This Class create the Date element 
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
class Apolo_Component_Formulator_Element_Date
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement()
    {
        #$this->form->addMedia('jquery-ui.js' . PHP_EOL);
        #$this->form->addMedia('smoothness/jquery-ui-1.8.16.custom.css');
        #$this->form->addMedia('form.js' . PHP_EOL);

        $input = '<input type="date"'
               . $this->makeAttributes()
               . $this->getValue()
               . '/>';
        $this->attrs['input'] = $input;
    }
}

<?php

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
    public function setElement(array $element)
    {
        $options = array();
        foreach ($this->element['values'] as $key => $value) {
            $options[] = '<option value="'.$key.'"'.$this->_selected($key).'>'.$value.'</option>';
        }
        
        $input = '<select '
               . $this->makeAttributes()
               . '>' . implode('', $options) . '</select>';
               
        $this->attrs['input'] = $input;
    }

    private function _selected($value)
    {
        if ($this->getValue(false) == $value) 
        {
          return ' selected="selected"'; 
        }
    }
}

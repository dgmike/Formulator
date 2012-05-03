<?php

class Apolo_Component_Formulator_Element_Table_Column 
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
     function setElement(array $element)
     {
        // See Apolo_Component_Formulator_Element_Column
        $this->attrs['open_td'] = '<td' . $this->makeAttributes() . '>';
        $this->attrs['close_td'] = '</td>';
     }
}

<?php

class Apolo_Component_Formulator_Element_Table_Heading 
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
     function setElement(array $element)
     {
        // See Apolo_Component_Formulator_Element_Column
        $this->attrs['open_th'] = '<th' . $this->makeAttributes() . '>';
        $this->attrs['close_th'] = '</th>';
     }
}

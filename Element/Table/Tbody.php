<?php

class Apolo_Component_Formulator_Element_Table_Tbody
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement()
    {
        // see Apolo_Component_Formulator_Element_Table_Row
        $this->attrs['open_tbody'] = '<tbody' . $this->makeAttributes() . '>';
        $this->attrs['close_tbody'] = '</tbody>';
    }
}

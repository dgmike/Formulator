<?php

class Apolo_Component_Formulator_Element_Table_Row
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public function setElement(array $element)
    {
        // See Apolo_Component_Formulator_Element_Column
        $this->attrs['open_tr'] = '<tr' . $this->makeAttributes() . '>';
        $this->attrs['close_tr'] = '</tr>';
    }
}

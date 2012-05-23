<?php

class Apolo_Component_Formulator_Template_Debug
    extends Apolo_Component_Formulator_Template
{
    public $templates = array(
        'default' => "{call:defaultElement}\n{subElements}",
    );

    public function defaultElement($element)
    {
        $output = ':- ';
        $parent = $element;
        while ($parent = $parent->getParent()) {
            $output = str_replace(':-', ': ', $output) . ' :- ';
        }
        $output .= str_replace('Apolo_Component_Formulator_Element_', '', get_class($element))
        ;
        /*
                 . '("' 
                 . trim($element->attribute('default', 'content', false)) 
                 . '")';
                 */
        return $output;
    }
}

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
        $class       = get_class($element);
        $prefix      = preg_quote('Apolo_Component_Formulator_Element_');
        $elementName = preg_replace("/^$prefix/", '', $class);
        $output     .= strtolower($elementName);
        return $output;
    }
}

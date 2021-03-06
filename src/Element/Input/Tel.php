<?php

$ds   = DIRECTORY_SEPARATOR;
$file = realpath(__DIR__ . $ds . '..' . $ds . 'Input.php');
require_once $file;
unset($ds, $file);

class Apolo_Component_Formulator_Element_Input_Tel
    extends Apolo_Component_Formulator_Element_Input
    implements Apolo_Component_Formulator_ElementInterface
{
    public    $templateType = 'input';
    protected $needsLabel   = true;
    protected $type         = 'tel';

    /*
    public $validAttributes    = array(
        'label' => array('name'),
        //'input' => array('attrs', '_type', 'name', 'value', 'id', 'placeholder', 'readonly', 'disabled'),
);
     */
}

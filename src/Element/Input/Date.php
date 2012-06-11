<?php

$ds   = DIRECTORY_SEPARATOR;
$file = realpath(__DIR__ . $ds . '..' . $ds . 'Input.php');
require_once $file;
unset($ds, $file);

class Apolo_Component_Formulator_Element_Input_Date
    extends Apolo_Component_Formulator_Element_Input
    implements Apolo_Component_Formulator_ElementInterface
{
    public    $templateType = 'input';
    protected $needsLabel   = true;
    protected $type         = 'date';

    public $validAttributes    = array(
        'label' => array('name'),
        'input' => array('attrs', '_type', 'name', 'value', 'id', 'readonly', 'disabled', 'required'),
    );
}
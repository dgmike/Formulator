<?php
/**
 * Formulator Component Element Input Date
 *
 * Used to create a Input Date Element
 *
 * PHP Version 5.2
 *
 * @category  Component
 * @package   Formulator
 * @author    Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author    Michell Campos <michell@corp.virgula.com.br>
 * @copyright 2011-2012 Virgula S/A
 * @license   Virgula Copyright
 * @link      http://virgula.uol.com.br
 */

/**
 * loading the Input class
 */
$ds   = DIRECTORY_SEPARATOR;
$file = realpath(__DIR__ . $ds . '..' . $ds . 'Input.php');
require_once $file;
unset($ds, $file);

/**
 * Formulator Component Element Input Date
 * 
 * This Class create the Input Date element with his options 
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
class Apolo_Component_Formulator_Element_Input_Date
    extends Apolo_Component_Formulator_Element_Input
    implements Apolo_Component_Formulator_ElementInterface
{
    public    $templateType = 'input';
    protected $needsLabel   = true;
    protected $type         = 'date';

    public $validAttributes    = array(
        'label' => array('name'),
        'input' => array(
            'attrs',
            '_type',
            'name',
            'value',
            'id',
            'readonly',
            'disabled',
            'required',
        ),
    );
}

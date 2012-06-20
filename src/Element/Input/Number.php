<?php
/**
 * Formulator Component Element Input Number
 *
 * Used to create a Input Number Element
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
 * Formulator Component Element Input Number
 * 
 * This Class create the Input File element with his options 
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
class Apolo_Component_Formulator_Element_Input_Number
    extends Apolo_Component_Formulator_Element_Input
    implements Apolo_Component_Formulator_ElementInterface
{
    public    $templateType = 'input';
    protected $needsLabel   = true;
    protected $type         = 'number';

    public $validAttributes    = array(
        'label' => array('name'),
        'input' => array(
            'attrs',
            '_type',
            'name',
            'value',
            'id',
            'placeholder',
            'readonly',
            'disabled',
        ),
    );
}

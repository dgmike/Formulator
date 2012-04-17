<?php
/**
 * Formulator Set of elements
 *
 * The above classes and interfaces defines the Elements of Formulator
 * class. Use the interface to know what to do and use the Element class
 * to help on more usual methods.
 *
 * PHP Version 5.2
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */

/**
 * Formulator Component Formulator Element Interface
 * 
 * This Class has a indice with the methods to be used by another class 
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
interface Apolo_Component_Formulator_ElementInterface
{
    /**
     * This method can set an element if this class was implemented in another 
     * class 
     * 
     * @example ./Element/Textarea.php
     *
     * @return void
     */
    public function __construct(array $element);

    /**
     * Retrives a determinated attribute
     */
    public function attribute($attributeName = 'value', $showAttribute = true, $escaped = true);

    /**
     * Retrive all attributes in HTML
     */
    public function makeAttributes();
}

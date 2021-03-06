<?php
/**
 * Formulator Component Html Element
 *
 * Use this element to create <samp>html</samp> content on the form.
 *
 * PHP Version 5.2
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

/**
 * This Class create <samp>html</samp> content on the form.
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
class Apolo_Component_Formulator_Element_Html
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This is the template type
     *
     * @access public
     * @var string
     */
    public $templateType = 'html';
    /**
     * This is the list of valid attributes that the html element accepts
     *
     * @access public
     * @var array
     */
    public  $validAttributes    = array(
        'default' => array('content')
    );

    /**
     * This method create the <samp>html</samp> on the form.
     *
     * @param array $element the array of element's options
     *
     * @return void
     */
    public function setElement(array $element)
    {
        $this->setAttribute('default', 'content', $element['content']);
    }
}

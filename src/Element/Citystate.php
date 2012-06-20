<?php
/**
 * Formulator Component City and State
 *
 * This element type creates two input elements: city and state and adds a
 * js to manipulate the brazilian's cities and states.
 *
 * PHP Version 5.2
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Element
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */

/**
 * Brazilian's Cities and States
 *
 * This element creates two input type text elements with the names
 * "name[uf]" and "name[state]". The label of this inputs are "Cidade"
 * and "Estado".
 *
 * Aditionality, in media, is added a javascript file that substitues the
 * input by two dinamic selects with brazilian's cities and states.
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Element
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
class Apolo_Component_Formulator_Element_Citystate
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
public $templateType = 'subElements';
    public  $validAttributes    = array();
    /**
     * This method create the <samp>fieldset</samp> with the element 
     * <samp>legend</samp> on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
if ($this->form) {
$this->form->addMedia('citystate.js');
$this->form->addMedia('form.js');
}
        $this->setSubElements(
            array(
                array(
                    'type' => 'input_text',
                    'label' => 'Estado',
                    'name' => $element['name'] . '[uf]',
                ),
                array(
                    'type' => 'input_text',
                    'label' => 'Estado',
                    'name' => $element['name'] . '[city]',
                ),
            )
        );
    }

}

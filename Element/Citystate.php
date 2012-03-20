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
    /**
     * This method create the <samp>fieldset</samp> with the element 
     * <samp>legend</samp> on the form.
     * 
     * @return void
     */
    public function setElement()
    {
        $this->form->addMedia('citystate.js');

        if (empty($this->element['name'])) {
            trigger_error('Name is mandatory in repetition element type.');
            $this->element['name'] = '';
        }

        $this->setElements();
    }

    protected function setElements()
    {
        $name = $this->element['name'];
        $this->element['elements'] = array(
            array(
                'type'  => 'text', 
                'label' => 'Estado',
                'name'  => $name . '[uf]',
                //'rules' => array('trim', 'isRequired', 'exact_length[2]',),
            ),
            array(
                'type'  => 'text', 
                'label' => 'Cidade',
                'name'  => $name . '[city]',
                //'rules' => array('trim', 'isRequired', 'min_length[2]',),
            ),
        );

        $this->element['values'] = $this->form->getValues();
        $this->element['form'] =& $this->form;

        $reflectionClass = new ReflectionClass(get_class($this->form));
        $this->elements  = $reflectionClass->newInstance();
        $this->elements->setForm(&$this->form);
        $this->elements->config($this->element);
    }
}


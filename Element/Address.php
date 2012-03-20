<?php
/**
 * Formulator Component Fieldset Element
 *
 * Use this element to create a <samp>fieldset</samp> on the form.
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
 * This Class create the <samp>fieldset</samp> on the form.
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
class Apolo_Component_Formulator_Element_Address
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
        $this->attrs['fieldsetopen']  = '<fieldset'.$this->makeAttributes().'>';
        $this->attrs['fieldsetclose'] = '</fieldset>';
        $this->attrs['legend'] = $this->getLabel();


        $name = $this->element['name'];

        $this->element['elements'] = array(
                array(
                    'type' => 'text',   
                    'name' => $name .'[zipcode]', 
                    'label' => 'CEP', 
                    'class' => 'cep',
                    'maxlength' => '9',
                ),
                array(
                    'type' => 'text',   
                    'name' => $name .'[location]', 
                    'label' => 'Endereco', 
                    'class' => 'endereco',
                ),
                array(
                    'type' => 'text',   
                    'name' => $name .'[number]', 
                    'label' => 'Número', 
                    'class' => 'numero',
                    'maxlength' => '5',
                ),
                array(
                    'type' => 'text',   
                    'name' => $name .'[complement]', 
                    'label' => 'Complemento', 
                    'class' => 'complemento',
                ),
                array(
                    'type' => 'text',   
                    'name' => $name .'[neighborhood]', 
                    'label' => 'Bairro', 
                    'class' => 'bairro',
                ),
                array(
                    'type' => 'citystate',   
                    'name' => $name, 
                ),
                array(
                    'type' => 'text',   
                    'name' => $name .'[country]', 
                    'label' => 'Pais', 
                    'class' => 'pais',
                ),


        );
    }
}

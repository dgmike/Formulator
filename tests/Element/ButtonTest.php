<?php

class Apolo_Component_Formulator_Element_ButtonTest
    extends PHPUnit_Framework_TestCase
{
    protected $form;

    public function setUp() {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testButton()
    {
        $this->form->addElement(array(
            'type'      => 'button',
            'label'     => 'Descrição',
            'name'      => 'descricao',
            'class'     => 'nomedaclasse',
            'id'        => 'nomedoID',
            'rows'      => 100,
            'cols'      => 200,
            'readonly'  => 'readonly',
            'disabled'  => 'disabled',
        ));

        $this->assertEquals(
                        '<label id="nomedoID" class="nomedaclasse">'
            . PHP_EOL . '    <span>'
            . PHP_EOL . '        Descri&ccedil;&atilde;o'
            . PHP_EOL . '    </span>'
            . PHP_EOL . '    <button rows="100" cols="200" name="descricao" readonly="readonly" disabled="disabled">'
            . PHP_EOL . '    </button>'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }
}
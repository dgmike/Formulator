<?php

class Apolo_Component_Formulator_Element_InputTest
    extends PHPUnit_Framework_TestCase
{
    protected $form;

    public function setUp() {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testTextarea()
    {
        $this->form->addElement(array(
            'type'      => 'textarea',
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
            . PHP_EOL . '    <textarea rows="100" cols="200" name="descricao" readonly="readonly" disabled="disabled">'
            . PHP_EOL . '    </textarea>'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }

    public function testTextareaHasValue()
    {
        $this->marktestskipped();
        $this->form->addElement(array(
            'type'  => 'textarea',
            'label' => 'Descrição',
            'name'  => 'descicao',
            'value' => 'descrição "completa"',
            'readonly'  => 'readonly',
            'disabled'  => 'disabled',
        ));
        $this->assertEquals(
                        '<label class="nomedaclasse" id="nomedoID">'
            . PHP_EOL . '    <span>'
            . PHP_EOL . '        Descrição'
            . PHP_EOL . '    </span>'
            . PHP_EOL . '    <textarea name="descricao" cols="200" rows="100">'
            . PHP_EOL . '        descrição &quot;completa&quot;'
            . PHP_EOL . '    </textarea>'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }
}
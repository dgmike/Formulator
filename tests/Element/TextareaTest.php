<?php

class Apolo_Component_Formulator_Element_TextareaTest
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
        $this->form->addElement(array(
            'type'  => 'textarea',
            'label' => 'Descrição',
            'name'  => 'descricao',
            'value' => 'descrição "completa"',
        ));
        $this->assertEquals(
                        '<label>'
            . PHP_EOL . '    <span>'
            . PHP_EOL . '        Descri&ccedil;&atilde;o'
            . PHP_EOL . '    </span>'
            . PHP_EOL . '    <textarea name="descricao">'
            . PHP_EOL . '        descri&ccedil;&atilde;o &quot;completa&quot;'
            . PHP_EOL . '    </textarea>'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }
}
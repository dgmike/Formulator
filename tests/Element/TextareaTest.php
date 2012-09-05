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
            . PHP_EOL . '    <textarea rows="100" cols="200" name="descricao" readonly="readonly" disabled="disabled"></textarea>'
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
            . PHP_EOL . '    <textarea name="descricao">descri&ccedil;&atilde;o &quot;completa&quot;</textarea>'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }
    
    /**
     * @expectedException DomainException
     * @expectedExceptionMessage You must set the label
     */
    public function testLabelIsMandatory()
    {
        $this->form->addElement(array('type'=>'textarea', 'name'=>'nometeste'));
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage You must set the name
     */
    public function testNameIsMandatory()
    {
        $this->form->addElement(array('type'=>'textarea', 'label'=>'labelteste'));
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage rows must be integer or string (as digit)
     */
    public function testRowsColsAreDigit()
    {
        $this->form->addElement(array('type'=>'textarea', 'label'=>'labelteste', 'name'=>'nometeste', 'rows'=>'olarows', 'cols'=>'olacols'));
    }
}
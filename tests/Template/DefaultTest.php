<?php

class Apolo_Component_Formulator_Template_DefaultTest
    extends PHPUnit_Framework_TestCase
{
    protected $form;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator();
        $this->form->setTemplate('default');
    }

    public function testCorrectClass()
    {
        $this->assertEquals(
            'Apolo_Component_Formulator_Template_Default', 
            get_class($this->form->getTemplate())
        );
    }

    public function testHtmlIsTheSame()
    {
        $html = 'Now is ' . date('r');
        $this->form->addElement(array('type' => 'html', 'content' => $html));
        $this->assertEquals(
            $html,
            $this->form->render('elements')
        );
    }

    public function testInput()
    {
        $this->form->addElement(array('type' => 'input', 'name' => 'nome', 'label' => "Nome"));
        $this->assertEquals(
            '<label><span>Nome</span> <input type="text" name="nome" /></label>',
            $this->form->render('elements')
        );
    }

    public function testInputQuotes()
    {
        $this->form->addElement(array('type' => 'input', 'name' => 'nome', 'label' => "Nome", 'value' => '"Escreva seu nome"'));
        $this->assertEquals(
            '<label><span>Nome</span> <input type="text" name="nome" value="&quot;Escreva seu nome&quot;" /></label>',
            $this->form->render('elements')
        );
    }

    public function testInputOtherAttributes()
    {
        $this->markTestSkipped();
        $this->form->addElement(array('type' => 'input', 'name' => 'nome', 'label' => "Nome", 'value' => '"Escreva seu nome"'));
        $this->assertEquals(
            '<label><span>Nome</span> <input type="text" name="nome" value="&quot;Escreva seu nome&quot;" /></label>',
            $this->form->render('elements')
        );
    }

    public function testInputType()
    {
        $this->form->addElement(array('type' => 'input', 'name' => 'nome', 'label' => "Nome", '_type' => 'radio'));
        $this->assertEquals(
            '<label><span>Nome</span> <input type="radio" name="nome" /></label>',
            $this->form->render('elements')
        );
    }
}

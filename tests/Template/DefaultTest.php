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

    public function testHtmlIsNotEscaped()
    {
        $html = '<p>' . PHP_EOL
              . '    My example' . PHP_EOL
              . '</p>';
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
                        '<label>'
            . PHP_EOL . '    <span>'
            . PHP_EOL . '        Nome'
            . PHP_EOL . '    </span>'
            . PHP_EOL . '    <input type="text" name="nome" />'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }

    public function testInputQuotes()
    {
        $this->form->addElement(array('type' => 'input', 'name' => 'nome', 'label' => "Nome", 'value' => '"Escreva seu nome"'));
        $this->assertEquals(
                        '<label>'
            . PHP_EOL . '    <span>'
            . PHP_EOL . '        Nome'
            . PHP_EOL . '    </span>'
            . PHP_EOL . '    <input type="text" name="nome" value="&quot;Escreva seu nome&quot;" />'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }

    public function testInputType()
    {
        $this->form->addElement(array('type' => 'input', 'name' => 'nome', 'label' => "Nome", '_type' => 'radio'));
        $this->assertEquals(
                        '<label>'
            . PHP_EOL . '    <span>'
            . PHP_EOL . '        Nome'
            . PHP_EOL . '    </span>'
            . PHP_EOL . '    <input type="radio" name="nome" />'
            . PHP_EOL . '</label>',
            $this->form->render('elements')
        );
    }
}

<?php

class DefaultTest
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
}

<?php

class Apolo_Component_Formulator_Element_Input_HiddenTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateHidden()
    {
        $this->form->addElement(array(
            'type'  => 'input_hidden',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleHidden()
    {
        $this->form->addElement(array(
            'type'  => 'input_hidden',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $expected = '<input type="hidden" name="input_test" value="linux" />';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrHidden()
    {
        $this->form->addElement(array(
            'type'        => 'input_hidden',
            'name'        => 'input_test',
            'value'       => 'linux',
            'label'       => 'Linux',
            'disabled'    => 'disabled',
        ));
        $expected = '<input type="hidden" name="input_test" value="linux" disabled="disabled" />';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

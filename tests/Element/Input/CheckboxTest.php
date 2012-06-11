<?php

class Apolo_Component_Formulator_Element_Input_CheckboxTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateCheckbox()
    {
        $this->form->addElement(array(
            'type'  => 'input_checkbox',
            'name'  => 'so[]',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleCheckbox()
    {
        $this->form->addElement(array(
            'type'  => 'input_checkbox',
            'name'  => 'multiple_choices[]',
            'value' => 'choice 1',
            'label' => 'Multiple choices',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <input type="checkbox" name="multiple_choices[]" value="choice 1" />' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Multiple choices' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderCheckedInput()
    {
        $this->form->addElement(array(
            'type'    => 'input_checkbox',
            'name'    => 'so[]',
            'value'   => 'linux',
            'label'   => 'Linux',
            'checked' => 'checked',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <input type="checkbox" name="so[]" value="linux" checked="checked" />' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

<?php

class Apolo_Component_Formulator_Element_Input_NumberTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateNumber()
    {
        $this->form->addElement(array(
            'type'  => 'input_number',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleNumber()
    {
        $this->form->addElement(array(
            'type'  => 'input_number',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="number" name="input_test" value="linux" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrNumber()
    {
        $this->form->addElement(array(
            'type'        => 'input_number',
            'name'        => 'input_test',
            'value'       => 'linux',
            'label'       => 'Linux',
            'placeholder' => 'number',
            'readonly'    => 'readonly',
            'disabled'    => 'disabled',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="number" name="input_test" value="linux" placeholder="number" readonly="readonly" disabled="disabled" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

<?php

class Apolo_Component_Formulator_Element_Input_DateTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateDate()
    {
        $this->form->addElement(array(
            'type'  => 'input_date',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleDate()
    {
        $this->form->addElement(array(
            'type'  => 'input_date',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="date" name="input_test" value="linux" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrDate()
    {
        $this->form->addElement(array(
            'type'        => 'input_date',
            'name'        => 'input_test',
            'value'       => 'linux',
            'label'       => 'Linux',
            'readonly'    => 'readonly',
            'disabled'    => 'disabled',
            'required'    => 'required',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="date" name="input_test" value="linux" readonly="readonly" disabled="disabled" required="required" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

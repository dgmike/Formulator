<?php

class Apolo_Component_Formulator_Element_Input_TelTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateTel()
    {
        $this->form->addElement(array(
            'type'  => 'input_tel',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleTel()
    {
        $this->form->addElement(array(
            'type'  => 'input_tel',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="tel" name="input_test" value="linux" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrTel()
    {
        $this->form->addElement(array(
            'type'        => 'input_tel',
            'name'        => 'input_test',
            'value'       => 'linux',
            'label'       => 'Linux',
            'placeholder' => 'tel',
            'readonly'    => 'readonly',
            'disabled'    => 'disabled',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="tel" name="input_test" value="linux" placeholder="tel" readonly="readonly" disabled="disabled" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

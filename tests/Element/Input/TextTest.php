<?php

class Apolo_Component_Formulator_Element_Input_TextTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateText()
    {
        $this->form->addElement(array(
            'type'  => 'input_text',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleText()
    {
        $this->form->addElement(array(
            'type'  => 'input_text',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="text" name="input_test" value="linux" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrText()
    {
        $this->form->addElement(array(
            'type'        => 'input_text',
            'name'        => 'input_test',
            'value'       => 'linux',
            'label'       => 'Linux',
            'placeholder' => 'text',
            'readonly'    => 'readonly',
            'disabled'    => 'disabled',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="text" name="input_test" value="linux" placeholder="text" readonly="readonly" disabled="disabled" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

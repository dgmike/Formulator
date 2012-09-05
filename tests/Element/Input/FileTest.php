<?php

class Apolo_Component_Formulator_Element_Input_FileTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateFile()
    {
        $this->form->addElement(array(
            'type'  => 'input_file',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleFile()
    {
        $this->form->addElement(array(
            'type'  => 'input_file',
            'name'  => 'input_test',
            'label' => 'Linux',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="file" name="input_test" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrFile()
    {
        $this->form->addElement(array(
            'type'        => 'input_file',
            'name'        => 'input_test',
            'label'       => 'Linux',
            'accept'      => 'image/*', 
            'multiple'    => 'multiple',
            'disabled'    => 'disabled',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="file" name="input_test" accept="image/*" multiple="multiple" disabled="disabled" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

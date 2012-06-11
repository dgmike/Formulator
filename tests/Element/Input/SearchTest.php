<?php

class Apolo_Component_Formulator_Element_Input_SearchTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateSearch()
    {
        $this->form->addElement(array(
            'type'  => 'input_search',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function testRenderSimpleSearch()
    {
        $this->form->addElement(array(
            'type'  => 'input_search',
            'name'  => 'input_test',
            'value' => 'linux',
            'label' => 'Linux',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="search" name="input_test" value="linux" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderAttrSearch()
    {
        $this->form->addElement(array(
            'type'        => 'input_search',
            'name'        => 'input_test',
            'value'       => 'linux',
            'label'       => 'Linux',
            'placeholder' => 'search',
            'readonly'    => 'readonly',
            'disabled'    => 'disabled',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Linux' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <input type="search" name="input_test" value="linux" placeholder="search" readonly="readonly" disabled="disabled" />' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

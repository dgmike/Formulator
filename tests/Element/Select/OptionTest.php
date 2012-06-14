<?php

class Apolo_Component_Formulator_Element_Select_OptionTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    protected function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateAnElement()
    {
        $this->form->addElement(array(
            'type' => 'select_option',
            'label' => 'Nigéria',
            'value' => 'nigeria',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    /**
     * @dataProvider requiredStuffs
     * @expectedException DomainException
     */
    public function testNeedsSomeStuffs($stuff)
    {
        $element = array(
            'type' => 'select_option',
            'label' => 'ANYWAY',
            'value' => 'ANYWAY',
        );
        unset($element[$stuff]);
        $this->form->addElement($element);
    }

    public function requiredStuffs()
    {
        return array(
            array('value'),
            array('label'),
        );
    }

    public function testRenderASimpleOption()
    {
        $this->form->addElement(array(
            'type'  => 'select_option',
            'value' => 'animation',
            'label' => 'Animation',
        ));
        $expected = '<option value="animation">' . PHP_EOL
                  . '    Animation' . PHP_EOL
                  . '</option>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderQuotedOption()
    {
        $this->form->addElement(array(
            'type'  => 'select_option',
            'value' => 'say "hello"',
            'label' => 'Say "Hello"!',
        ));
        $expected = '<option value="say &quot;hello&quot;">' . PHP_EOL
                  . '    Say &quot;Hello&quot;!' . PHP_EOL
                  . '</option>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testRenderOtherParams()
    {
        $this->form->addElement(array(
            'type'         => 'select_option',
            'value'        => 'hello',
            'label'        => 'Hello!',
            'data-enabled' => 'yes',
            'selected'     => 'selected',
            'title'        => 'It says: "Hi"',
        ));
        $expected = '<option value="hello" data-enabled="yes" selected="selected" title="It says: &quot;Hi&quot;">' . PHP_EOL
                  . '    Hello!' . PHP_EOL
                  . '</option>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

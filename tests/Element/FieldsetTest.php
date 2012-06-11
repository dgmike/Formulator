<?php

class Apolo_Component_Formulator_Element_FieldsetTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateAnEmptyFieldSet()
    {
        $this->form->addElement(array(
            'type' => 'fieldset',
        ));
        $this->assertCount(1, $this->form->getElements());
        $expected = '<fieldset>' . PHP_EOL
                  . '</fieldset>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testCreateFieldsetWithSubElements()
    {
        $this->form->addElement(array(
            'type'        => 'fieldset',
            'subElements' => array(
                array('type' => 'html', 'content' => '<p>SubElement 1</p>'),
                array('type' => 'html', 'content' => '<p>SubElement 2</p>'),
            ),
        ));
        $expected = '<fieldset>' . PHP_EOL
                  . '    <p>' . PHP_EOL
                  . '        SubElement 1' . PHP_EOL
                  . '    </p>' . PHP_EOL
                  . '    <p>' . PHP_EOL
                  . '        SubElement 2' . PHP_EOL
                  . '    </p>' . PHP_EOL
                  . '</fieldset>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testCreateFieldsetWithLegend()
    {
        $this->form->addElement(array(
            'type'   => 'fieldset',
            'legend' => 'My legend',
        ));
        $expected = '<fieldset>' . PHP_EOL
                  . '    <legend>' . PHP_EOL
                  . '        My legend' . PHP_EOL
                  . '    </legend>' . PHP_EOL
                  . '</fieldset>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

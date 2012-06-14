<?php

class Apolo_Component_Formulator_Element_ButtonTest
    extends PHPUnit_Framework_TestCase
{
    protected $form;

    public function setUp() {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCreateButton()
    {
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => 'submit',
        ));

        $this->assertCount(1, $this->form->getElements());
        
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => 'reset',
        ));

        $this->assertCount(2, $this->form->getElements());
    }
    
    /**
     * @expectedException DomainException
     */
    public function testTypeIsRequired()
    {
        $this->form->addElement(array(
            'type'      => 'button',
        ));
    }

    /**
     * @expectedException DomainException
     */
    public function testType()
    {
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => 'whatever',
        ));
    }

    /**
     * @dataProvider goodTypes
     */
    public function testType2($type)
    {
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => $type,
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    public function goodTypes() {
        return array(
            array('button'),
            array('submit'),
            array('reset'),
        );
    }

    public function testRender()
    {
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => 'button',
        ));

        $expected = '<button type="button">' .
            PHP_EOL . '</button>';

        $this->assertEquals($this->form->render('elements'), $expected);
    }

    public function testAttributes()
    {
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => 'button',
            'label'     => '<img src="key1.jpg" />',
            'name'      => 'buttonname',
            'value'     => 'buttonvalue',
            'id'        => 'buttonid',
            'disabled'  => 'disabled',
        ));

        $expected = '<button type="button" name="buttonname" value="buttonvalue" id="buttonid" disabled="disabled">' .
            PHP_EOL . '    <img src="key1.jpg" />' .
            PHP_EOL . '</button>';

        $this->assertEquals($this->form->render('elements'), $expected);
    }

    public function testSubElements()
    {
        $this->form->addElement(array(
            'type'      => 'button',
            '_type'     => 'button',
            'subElements' => array(
                array('type'=>'html', 'content'=>'whatever'),
            ),
        ));

        $expected = '<button type="button">' .
            PHP_EOL . '    whatever' .
            PHP_EOL . '</button>';

        $this->assertEquals($this->form->render('elements'), $expected);
    }
}
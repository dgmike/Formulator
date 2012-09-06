<?php

class Apolo_Component_Formulator_Element_SelectTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    protected function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    public function testCanCreateASelect()
    {
        $this->form->addElement(array(
            'type' => 'select',
            'name' => 'empty',
        ));
        $this->assertCount(1, $this->form->getElements());
    }

    /**
     * @expectedException DomainException
     */
    public function testErrorIfNotName()
    {
        $this->form->addElement(array(
            'type' => 'select',
        ));
    }

    public function testCreateSimpleSelect()
    {
        $this->form->addElement(array(
            'type' => 'select',
            'name' => 'empty',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <select name="empty">' . PHP_EOL
                  . '    </select>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testCreateSelectWithLabel()
    {
        $this->form->addElement(array(
            'type'  => 'select',
            'label' => 'Empty Select Element',
            'name'  => 'empty',
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '        Empty Select Element' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <select name="empty">' . PHP_EOL
                  . '    </select>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
    public function testCreateOneOption()
    {
        $this->form->addElement(array(
            'type' => 'select',
            'name' => 'sex',
            'values' => array(
                'm' => 'male',
                'f' => 'female',
            ),
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <select name="sex">' . PHP_EOL
                  . '        <option value="m">' . PHP_EOL
                  . '            male' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '        <option value="f">' . PHP_EOL
                  . '            female' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '    </select>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
    
    public function testCreateWithSomeAttributes()
    {
        $this->form->addElement(array(
            'type'      => 'select',
            'name'      => 'os',
            'multiple'  => 'multiple',
            'size'      => 5,
            'autofocus' => 'autofocus',
            'required'  => 'required',
            'values'    => array(
                'win'   => 'Windows',
                'linux' => 'Linux',
                'mac'   => 'Mac Os',
            )
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <select name="os" multiple="multiple" size="5" autofocus="autofocus" required="required">' . PHP_EOL
                  . '        <option value="win">' . PHP_EOL 
                  . '            Windows' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '        <option value="linux">' . PHP_EOL
                  . '            Linux' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '        <option value="mac">' . PHP_EOL
                  . '            Mac Os' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '    </select>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testCreateWithValue()
    {
        $this->form->config(array(
            'values' => array(
                'sex' => 'f',
            )
        ));
        $this->form->addElement(array(
            'type' => 'select',
            'name' => 'sex',
            'values' => array(
                'm' => 'Male',
                'f' => 'Female',
            ),
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <select name="sex">' . PHP_EOL
                  . '        <option value="m">' . PHP_EOL
                  . '            Male' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '        <option value="f" selected="selected">' . PHP_EOL
                  . '            Female' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '    </select>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testCreateWithMultipleValue()
    {
        $this->form->config(
            array(
                'values' => array(
                    'coffee' => array(
                        'expresso', 'latte'
                    ),
                ),
            )
        );
        $this->form->addElement(array(
            'type' => 'select',
            'name' => 'coffee',
            'multiple' => 'multiple',
            'size' => 5,
            'values' => array(
                'expresso' => 'Expresso',
                'venti'    => 'Venti',
                'latte'    => 'Latte',
            ),
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <select name="coffee" multiple="multiple" size="5">' . PHP_EOL
                  . '        <option value="expresso" selected="selected">' . PHP_EOL
                  . '            Expresso' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '        <option value="venti">' . PHP_EOL
                  . '            Venti' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '        <option value="latte" selected="selected">' . PHP_EOL
                  . '            Latte' . PHP_EOL
                  . '        </option>' . PHP_EOL
                  . '    </select>' . PHP_EOL
                  . '</label>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

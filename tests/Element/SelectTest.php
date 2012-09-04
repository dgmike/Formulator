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
        $expected = '<select name="empty">' . PHP_EOL . '</select>';
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
        $expected = '<select name="sex">' . PHP_EOL
                  . '    <option value="m">' . PHP_EOL
                  . '        male' . PHP_EOL
                  . '    </option>' . PHP_EOL
                  . '    <option value="f">' . PHP_EOL
                  . '        female' . PHP_EOL
                  . '    </option>' . PHP_EOL
                  . '</select>';
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
            'values'    => array(
                'win'   => 'Windows',
                'linux' => 'Linux',
                'mac'   => 'Mac Os',
            )
        ));
        $expected = '<label>' . PHP_EOL
                  . '    <span>' . PHP_EOL
                  . '    </span>' . PHP_EOL
                  . '    <select name="os" multiple="multiple" size="5" autofocus="autofocus">' . PHP_EOL
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
}

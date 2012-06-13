<?php

class Apolo_Component_Formulator_Element_CheckboxTest
    extends PHPUnit_Framework_TestCase
{
    protected $form = null;

    public function setUp()
    {
        $this->form = new Apolo_Component_Formulator;
    }

    /**
     * @dataProvider mandatoryAttributes
     * @expectedException DomainException
     */
    public function testNeedToHaveAttribute($attribute)
    {
        $element = array(
                'type'  => 'checkbox',
                'label' => 'S.O. de sua preferência',
                'name'  => 'so[]', // vai para os checkboxes
                'values' => array(
                    'windows xp' => 'Windows XP',
                    'windows 7'  => 'Windows 7',
                    'ubuntu'     => 'Ubuntu',
                    'kde'        => 'KDE',
                    ),
                );
        unset($element[$attribute]);
        $this->form->addElement($element);
    }

    public function mandatoryAttributes()
    {
        return array(
            array('label'), 
            array('values'), 
            array('name'),
        );
    }

    /**
     * @expectedException DomainException
     */
    public function testValuesMustBeArray()
    {
        $this->form->addElement(array(
            'type'   => 'checkbox',
            'label'  => 'Can you endorse-me?',
            'name'   => 'endose[]',
            'values' => 'my invalid value',
        ));
    }

    public function testSettingOneElementGenerateThree()
    {
        $this->form->addElement(array(
            'type'   => 'checkbox',
            'label'  => 'Do you accept the terms?',
            'name'   => 'accept[]',
            'values' => array(
                'yes' => 'Yes, I do.',
            ),
        ));
        // using debug, so this will print one element per line
        $this->form->setTemplate('debug');
        $elements = trim($this->form->render('elements'));
        $elements = explode(PHP_EOL, $elements);
        $this->assertCount(3, $elements);
    }

    public function testRenderCheckboxes()
    {
        $this->form->addElement(array(
            'type'   => 'checkbox',
            'label'  => 'What are your favorites scary movies?',
            'name'   => 'movies[]',
            'values' => array(
                'the saw'      => 'The saw',
                'friday, 13th' => 'Friday, the 13th',
                'elm street'   => 'A nightmare on Elm Street',
            ),
        ));
        $expected = '<fieldset>' . PHP_EOL
                  . '    <legend>' . PHP_EOL
                  . '        What are your favorites scary movies?' . PHP_EOL
                  . '    </legend>' . PHP_EOL
                  . '    <label>' . PHP_EOL
                  . '        <input type="checkbox" name="movies[]" value="the saw" />' . PHP_EOL
                  . '        <span>' . PHP_EOL
                  . '            The saw' . PHP_EOL
                  . '        </span>' . PHP_EOL
                  . '    </label>' . PHP_EOL
                  . '    <label>' . PHP_EOL
                  . '        <input type="checkbox" name="movies[]" value="friday, 13th" />' . PHP_EOL
                  . '        <span>' . PHP_EOL
                  . '            Friday, the 13th' . PHP_EOL
                  . '        </span>' . PHP_EOL
                  . '    </label>' . PHP_EOL
                  . '    <label>' . PHP_EOL
                  . '        <input type="checkbox" name="movies[]" value="elm street" />' . PHP_EOL
                  . '        <span>' . PHP_EOL
                  . '            A nightmare on Elm Street' . PHP_EOL
                  . '        </span>' . PHP_EOL
                  . '    </label>' . PHP_EOL
                  . '</fieldset>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }

    public function testClassAndIdGoesToFieldset()
    {
        $this->form->addElement(array(
            'type'   => 'checkbox',
            'label'  => 'Do you accept the terms?',
            'class'  => 'fieldset',
            'id'     => 'accept',
            'name'   => 'accept[]',
            'values' => array(
                'yes' => 'Yes, I do.',
            ),
        ));
        $expected = '<fieldset id="accept" class="fieldset">' . PHP_EOL
                  . '    <legend>' . PHP_EOL
                  . '        Do you accept the terms?' . PHP_EOL
                  . '    </legend>' . PHP_EOL
                  . '    <label>' . PHP_EOL
                  . '        <input type="checkbox" name="accept[]" value="yes" />' . PHP_EOL
                  . '        <span>' . PHP_EOL
                  . '            Yes, I do.' . PHP_EOL
                  . '        </span>' . PHP_EOL
                  . '    </label>' . PHP_EOL
                  . '</fieldset>';
        $this->assertEquals($expected, $this->form->render('elements'));
    }
}

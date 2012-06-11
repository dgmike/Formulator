<?php

class Apolo_Component_Formulator_Element_InputTest
    extends PHPUnit_Framework_TestCase
{
    protected $input = array(
        'type'  => 'input',
        'label' => 'Label',
        'name'  => 'my_custom_name',
    );

    public function testRenderLikeInput()
    {
        $elements = array($this->input);
        $form = new Apolo_Component_Formulator(compact('elements'));
        $output = $form->render('elements');
        $this->assertEquals($output, 
                      '<label>' .
            PHP_EOL . '    <span>' .
            PHP_EOL . '        Label' .
            PHP_EOL . '    </span>' .
            PHP_EOL . '    <input type="text" name="my_custom_name" />' .
            PHP_EOL . '</label>'
        );
    }

    /**
     * @expectedException        DomainException
     * @expectedExceptionMessage This Element Needs Label!
     */
    public function testNormalInputNeedsLabel()
    {
        $input = $this->input;
        unset($input['label']);
        $elements = array($input);
        $form = new Apolo_Component_Formulator(compact('elements'));
    }

    public function testAttributesCanNotBeSetted()
    {
        $input = $this->input;
        $input['attrs'] = 'easy';
        $elements = array($input);
        $form = new Apolo_Component_Formulator(compact('elements'));
        $output = $form->render('elements');
        $this->assertThat(
            $output,
            $this->logicalNot(
                $this->stringContains('easy')
            )
        );
    }

    public function testNeedsLabel()
    {
        $input = $this->input;

        $elementReflection = new ReflectionClass('Apolo_Component_Formulator_Element_Input');
        $needsLabel = $elementReflection->getProperty('needsLabel');
        $needsLabel->setAccessible(true);

        $element = new Apolo_Component_Formulator_Element_Input($input);
        $needsLabel->setValue($element, false);

        unset($input['label']);
        $element->setElement($input);

        $this->assertEquals('Apolo_Component_Formulator_Element_Input', get_class($element));
    }

    /**
     * @expectedException        DomainException
     * @expectedExceptionMessage This Element Needs Label!
     */
    public function testNeedsLabel2()
    {
        $input = $this->input;

        $elementReflection = new ReflectionClass('Apolo_Component_Formulator_Element_Input');
        $needsLabel = $elementReflection->getProperty('needsLabel');
        $needsLabel->setAccessible(true);

        $element = new Apolo_Component_Formulator_Element_Input($input);
        $needsLabel->setValue($element, true);

        unset($input['label']);
        $element->setElement($input);
    }

    public function testTypeInput()
    {
        $input = $this->input;
        $input['_type'] = 'radio';
        $elements = array($input);
        $form = new Apolo_Component_Formulator(compact('elements'));
        $output = $form->render('elements');
        $this->assertContains(' type="radio"', $output);
    }

    public function testValue()
    {
        $input = $this->input;
        $input['value'] = 'My Value';
        $elements = array($input);
        $form = new Apolo_Component_Formulator(compact('elements'));
        $output = $form->render('elements');
        $this->assertContains(' value="My Value"', $output);
    }
}

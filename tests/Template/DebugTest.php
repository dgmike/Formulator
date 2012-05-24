<?php

class Apolo_Component_Formulator_Template_DebugTest
    extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->form  = new Apolo_Component_Formulator(array(
            'elements' => array(
                array(
                    'type'    => 'html',
                    'content' => 'HTML TEXT',
                    'subElements' => array(
                        array(
                            'type'    => 'html',
                            'content' => 'INNER HTML',
                        )
                    ),
                ),
                array(
                    'type'    => 'html',
                    'content' => 'HTML 2',
                    'subElements' => array(
                        array(
                            'type'    => 'html',
                            'content' => 'INNER HTML 1',
                            'subElements' => array(
                                array(
                                    'type'    => 'html',
                                    'content' => 'TERNARY ELEMENT',
                                ),
                            ),
                        ),
                        array(
                            'type'    => 'html',
                            'content' => 'INNER HTML 2',
                        ),
                    ),
                )
            ),
        ));
        $this->form->setTemplate('debug');
        $this->debug = $this->form->getTemplate();
    }

    public function testDebugIsTemplate()
    {
        $this->assertTrue(
            $this->debug instanceOf Apolo_Component_Formulator_Template
        );
    }

    public function testFormCallsDefaultElementMethod()
    {
        $mockDebugTemplate = $this->getMock(
            get_class($this->debug), array('defaultElement')
        );
        $mockDebugTemplate
            ->expects($this->exactly(6))
            ->method('defaultElement')
            ->will($this->returnValue('my debug'));

        $this->form->setTemplate($mockDebugTemplate);
        $this->form->render('elements');
    }

    public function testRenderSimpleElement()
    {
        $element = Apolo_Component_Formulator::element(array(
            'type'    => 'html',
            'content' => 'SIMPLE CONTENT',
        ));
        $this->assertEquals(":- html", $this->debug->defaultElement($element));
    }

    public function testRenderSimpleElement2()
    {
        $form = new Apolo_Component_Formulator(array(
        'elements' => array(
            array(
            'type'    => 'html',
            'content' => 'SIMPLE CONTENT',
            'subElements' => array(
                array(
                    'type' => 'html',
                    'content' => 'INNER HTML',
                )
            ),
            ))));
        $form->setTemplate('debug');
        $this->assertEquals(":- html\n:   :- html\n", $form->render('elements'));
    }

    public function testRenderSimpleElement3()
    {
        $html = array('type' => 'html', 'content' => 'SIMPLE');
        $element = Apolo_Component_Formulator::element($html);
        $elementChild = Apolo_Component_Formulator::element($html);
        $elementChild->setParent($element);
        $this->assertEquals(':   :- html', $this->debug->defaultElement($elementChild));
    }

    public function testRenderSimpleElement4()
    {
        $html = array('type' => 'html', 'content' => 'SIMPLE');
        $element = Apolo_Component_Formulator::element($html);
        $elementChild = Apolo_Component_Formulator::element($html);
        $elementGrandChild = Apolo_Component_Formulator::element($html);

        $elementChild->setParent($element);
        $elementGrandChild->setParent($elementChild);

        $this->assertEquals(':   :   :- html', $this->debug->defaultElement($elementGrandChild));
    }

    public function testRenderComplexElement()
    {
        $output = ":- html\n"
                . ":   :- html\n"
                . ":- html\n"
                . ":   :- html\n"
                . ":   :   :- html\n"
                . ":   :- html\n";
        $this->assertEquals($output, $this->form->render('elements'));
    }
}

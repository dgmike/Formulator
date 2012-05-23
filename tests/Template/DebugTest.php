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

    /*
    public function testRenderSubElements()
    {
        print "\n" . $this->form->render('elements');
    }
    */
}

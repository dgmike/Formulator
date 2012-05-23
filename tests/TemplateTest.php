<?php

class Apolo_Component_Formulator_TemplateTest
    extends PHPUnit_Framework_TestCase
{
    public $complexElementTree = array(
            'elements' => array(
                array(
                    'type'    => 'html',
                    'content' => 'test1',
                    'subElements' => array(
                        array(
                            'type'    => 'html',
                            'content' => 'test1-1',
                        ),
                        array(
                            'type' => 'html',
                            'content' => 'test1-2',
                        ),
                    ),
                ),
                array(
                    'type' => 'html',
                    'content' => 'test2',
                ),
                array(
                    'type' => 'html',
                    'content' => 'test3',
                    'subElements' => array(
                        array(
                            'type' => 'html',
                            'content' => 'test3-1',
                            'subElements' => array(
                                array(
                                    'type' => 'html',
                                    'content' => 'test3-1-1',
                                ),
                            ),
                        )
                    ),
                )
            ),
        );

    protected $html = array(
        'type'    => 'html',
        'content' => 'TestHTML',
    );

    protected $subElements = array(
        'subElements' => array(
            array(
                'type'    => 'html',
                'content' => '',
                ),
            ),
    );


    public function createTemplate(array $methods = array())
    {
        return $this->getMockForAbstractClass(
            'Apolo_Component_Formulator_Template',
            array(),
            $mockClassName = '',
            $callOriginalConstructor = true,
            $callOriginalClone = true,
            $callAutoload = true,
            $methods
        );
    }

    public function createTemplate2(array $methods = array())
    {
        return $this->getMock(
            'Apolo_Component_Formulator_Template',
            $methods,
            $arguments = array(),
            $mockClassName = '',
            $callOriginalConstructor = TRUE,
            $callOriginalClone = TRUE,
            $callAutoload = TRUE
        );
    }

    public function createElement(array $methods = array(), $element = null, $extraMethods = array())
    {
        if (null === $element) {
            $element = $this->html;
        }

        $object = $this->getMockForAbstractClass(
            'Apolo_Component_Formulator_Element',
            $arguments = array($element),
            $mockClassName = '',
            $callOriginalConstructor = true,
            $callOriginalClone = true,
            $callAutoload = true,
            $mockedMethods = $methods
        );

        if ($extraMethods) {
            $object =
                $this->getMockBuilder(get_class($object))
                     ->disableOriginalConstructor()
                     ->setMethods($extraMethods)
                     ->getMock();
        }

        return $object;
    }

    public function getPropertyValue($object, $property)
    {
        $objectReflection = new ReflectionClass($object);
        $property = $objectReflection->getProperty($property);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    /**
     * @covers Apolo_Component_Formulator_Template::setForm
     */
    public function testSetForm()
    {
        $template = $this->createTemplate();
        $this->assertNull($this->getPropertyValue($template, 'form'));
        $form = new Apolo_Component_Formulator;
        $template->setForm($form);
        $this->assertEquals($form, $this->getPropertyValue($template, 'form'));
    }

    public function createMediaTemplate()
    {
        // setup
        $form = $this->getMock(
            'Apolo_Component_Formulator',
            array('getMedia')
        );
        $form->expects($this->once())
             ->method('getMedia')
             ->will($this->returnValue(array(
                'js'  => array('file1.js',  'file2.js'),
                'css' => array('file1.css', 'style.css'),
             )));
        $template = $this->createTemplate();
        $template->setForm($form);
        return $template;
    }

    /**
     * @covers Apolo_Component_Formulator_Template::renderMedia
     */
    public function testRenderMedia()
    {
        $template = $this->createMediaTemplate();
        // uses only one form->getMedia
        for ($i = 0; $i < 1000; $i++) {
            $area = array('css', 'js');
            array_rand($area);
            $area = array_pop($area);
            $template->renderMedia($area);
        }
    }

    /**
     * @covers Apolo_Component_Formulator_Template::renderMedia
     */
    public function testRenderMedia2()
    {
        $template = $this->createMediaTemplate();
        $jsOutput = $template->renderMedia('js');
        $this->assertEquals(
            array(
                '<script type="text/javascript" src="/js/file1.js"></script>',
                '<script type="text/javascript" src="/js/file2.js"></script>',
            ),
            $jsOutput
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Template::renderMedia
     */
    public function testRenderMedia3()
    {
        $template  = $this->createMediaTemplate();
        $cssOutput = $template->renderMedia('css');
        $this->assertEquals(
            array(
                '<link rel="stylesheet" href="/css/file1.css" />',
                '<link rel="stylesheet" href="/css/style.css" />',
            ),
            $cssOutput
        );
    }

    public function testRenderMedia4()
    {
        $template  = $this->createMediaTemplate();
        $this->assertNull($template->renderMedia('invalid'));
    }

	public function testRenderCloseForm()
	{
    	$template = $this->createTemplate();
    	$this->assertEquals('</form>', $template->renderCloseForm());
    }

    public function testMakeAttributes()
    {
    	$template = $this->createTemplate();
    	$args = array(
    	    'name'          => 'nome',
    	    'id'            => 'my_id',
    	    'data-provider' => '"escaped"',
    	    'data-invalid'  => array(),
    	);
    	$output = $template->makeAttributes($args);
    	$this->assertEquals(
    	    ' name="nome" id="my_id" data-provider="&quot;escaped&quot;"',
    	    $output
    	);
    }

    public function testMakeAttributes2()
    {
        $template = $this->createTemplate();
        $this->assertEmpty($template->makeAttributes(array()));
    }

    public function testRenderOpenForm()
    {
        $template = $this->createTemplate();
        $form = $this->getMock(
            'Apolo_Component_Formulator', array('getConfig')
        );
        $form->expects($this->once())
             ->method('getConfig')
             ->will($this->returnValue(array(
                'action' => '/my/url',
                'id'     => '"new name"',
                'method' => 'post',
             )));
        $template->setForm($form);
        $output = $template->renderOpenForm();
        $this->assertEquals(
            '<form action="/my/url" id="&quot;new name&quot;"'
            . ' method="post">' . PHP_EOL,
            $output
        );
    }

    public function haveRunkit()
    {
        if (!function_exists('runkit_method_redefine')) {
            $this->markTestSkipped(
                'Runkit extension not avaliable'
            );
        }
    }

    public function redefineMockFinalOrPrivateMethod($template, $method)
    {
        runkit_method_redefine(
            get_class($template),
            $method,
            '',
            '
                $arguments = func_get_args();
                $result = $this->__phpunit_getInvocationMocker()->invoke(
                    new PHPUnit_Framework_MockObject_Invocation_Object(
                        "'.get_parent_class($template).'", "'.$method.'", $arguments, $this
                        )
                    );
                return $result;
            '
        );
        $reflection = new ReflectionClass($template);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
    }

    public function testRender()
    {
        // Verify if php have runKit
        $this->haveRunkit();

        $template = $this->createTemplate(array('_renderElements'));
        $this->redefineMockFinalOrPrivateMethod($template, '_renderElements');

        $template->expects($this->once())
             ->method('_renderElements')
             ->will($this->returnArgument(0));

        $form = new Apolo_Component_Formulator($this->complexElementTree);
        $template->setForm($form);
        $this->assertEquals($form, $template->render());
    }

    public function testRender2()
    {
        $this->haveRunkit();
        $template = $this->createTemplate(array('_renderElement'));
        $this->redefineMockFinalOrPrivateMethod($template, '_renderElement');

        $template->expects($this->exactly(3))
             ->method('_renderElement')
             ->will($this->returnValue('ELEMENT'));

        $form = new Apolo_Component_Formulator($this->complexElementTree);
        $template->setForm($form);
        $this->assertEquals(str_repeat('ELEMENT', 3), $template->render());
    }

    public function testRender3()
    {
        $this->haveRunkit();

        $element = $this->getMock('stdClass', array(
            'initRender', 'endRender'
        ));
        $element->templateType = 'html';

        $element->expects($this->once())
                ->method('initRender');

        $element->expects($this->once())
                ->method('endRender');

        $template = $this->createTemplate(array('_renderElement'));
        $this->redefineMockFinalOrPrivateMethod($template, '_renderElement');

        $reflection = new ReflectionClass($template);
        $method = $reflection->getMethod('_renderElements');
        $method->setAccessible(true);


        $method->invokeArgs($template, array(array($element)));
    }

    public function testRender4()
    {
        $element = $this->getMock('stdClass', array(
            'setParent'
        ));
        $element->templateType = 'html';
        $element->subElements = $this->html;

        $element->expects($this->once())
                ->method('setParent');

        $template = $this->createTemplate(array('_renderElement'));

        $reflection = new ReflectionClass($template);
        $method = $reflection->getMethod('_renderElements');
        $method->setAccessible(true);

        $method->invokeArgs(
            $template, 
            array(
                array($element),
                $parentElement = $this->createElement()
            )
        );
    }

    public function testRender5()
    {
        $this->haveRunkit();
        $template = $this->createTemplate(array('_getTemplate'));
        $this->redefineMockFinalOrPrivateMethod($template, '_getTemplate');
        $template->expects($this->once())
            ->method('_getTemplate')
            ->will($this->returnValue('template'));
        
        $reflection = new ReflectionClass($template);
        $method = $reflection->getMethod('_renderElement');
        $method->setAccessible(true);
        $result = $method->invokeArgs(
            $template, array(
                $this->html, 'html'
            )
        );
        $this->assertEquals($result, 'template');
    }

    public function testRender6()
    {
        $this->haveRunkit();
        $template = $this->createTemplate(array('_parseTokens'));
        $this->redefineMockFinalOrPrivateMethod($template, '_parseTokens');
        $template->expects($this->once())
            ->method('_parseTokens')
            ->will($this->returnValue('tokens regererated'));
        
        $method = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs(
            $template, array(
                $this->html, 'html'
            )
        );
        $this->assertEquals($result, 'tokens regererated');
    }

    public function testRender7()
    {
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_getTemplate');
        $method->setAccessible(true);

        $templateResult1 = uniqid();
        $templateResult2 = uniqid();

        $template->templates['mytype']  = $templateResult1;
        $template->templates['default'] = $templateResult2;

        $this->assertEquals(
            $method->invokeArgs($template, array('myType')),
            $templateResult1
        );

        $this->assertEquals(
            $method->invokeArgs($template, array('anyothertype')),
            $templateResult2
        );

        $this->assertEquals(
            $method->invokeArgs($template, array('myOtherTemplate')),
            $templateResult2
        );

        unset($template->templates['default']);

        $this->assertEquals(
            $method->invokeArgs($template, array('templateDoNotExists')),
            '{label}: {input}'
        );
    }

    public function testRender8()
    {
        $uniqid = uniqid();

        $template = $this->createTemplate2(array('templateWay'));

        $template->expects($this->once())
            ->method('templateWay')
            ->will($this->returnValue($uniqid));

        $method = new ReflectionMethod($template, '_getTemplate');
        $method->setAccessible(true);

        $this->assertEquals(
            $method->invokeArgs($template, array('way')),
            $uniqid
        );
    }

    public function testRender9()
    {
        $this->haveRunkit();
        $template = $this->createTemplate(array('_parseTokens'));
        $template->templates = array(
            'html' => 'one{token}two{token2}three',
        );
        $this->redefineMockFinalOrPrivateMethod($template, '_parseTokens');
        $template->expects($this->once())
            ->method('_parseTokens')
            ->will($this->returnCallback(function($tokens){
                    $args = func_get_args();
                    return implode('º', $args[0]);
                }));
        $method = new ReflectionMethod($template, '_renderElement');
        $method->setAccessible(true);
        $result = $method->invokeArgs(
            $template, array(
                $this->html, 'html'
            )
        );
        $this->assertEquals($result, 'oneº{token}ºtwoº{token2}ºthree');
    }

    public function testRender10()
    {
        $template = $this->createTemplate();
        $element  = $this->createElement(array(), null, array('initRenderChilds'));
        $element->subElements = $this->html;
        $element->expects($this->once())
                ->method('initRenderChilds');

        $method = new ReflectionMethod($template, '_renderElements');
        $method->setAccessible(true);
        $method->invokeArgs($template, array(array($element), $element));
    }

    public function testRender11()
    {
        $template = $this->createTemplate();
        $element  = $this->createElement(array(), null, array('endRenderChilds'));
        $element->subElements = $this->html;
        $element->expects($this->once())
                ->method('endRenderChilds');

        $method = new ReflectionMethod($template, '_renderElements');
        $method->setAccessible(true);
        $method->invokeArgs($template, array(array($element), $element));
    }

    public function testParseTokens()
    {
        $template = $this->createTemplate2();
        $element  = $this->createElement();
        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'simple', ' as', ' one,',
                ' two,', ' three.',
            ),
            $element
        ));
        $this->assertEquals('simple as one, two, three.', $result);
    }

    public function testParseTokens2()
    {
        $template = $this->createTemplate2();
        $element  = $this->createElement(array('attribute'));

        $element->expects($this->once())
            ->method('attribute')
            ->will($this->returnValue('Michael'));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Say my name: ', '{name}'
            ),
            $element
        ));
        $this->assertEquals('Say my name: Michael', $result);
    }

    public function testParseTokens3()
    {
        $template = $this->createTemplate2();
        $element  = $this->createElement(array('attribute'));

        $element->expects($this->once())
            ->method('attribute')
            ->will($this->returnArgument(0));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Say my name: ', '{name}'
            ),
            $element
        ));
        $this->assertEquals('Say my name: default', $result);
    }

    public function testParseTokens4()
    {
        $template = $this->createTemplate2();
        $element  = $this->createElement(array('attribute'));

        $element->expects($this->once())
            ->method('attribute')
            ->will($this->returnArgument(1));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Say my name: ', '{name}'
            ),
            $element
        ));
        $this->assertEquals('Say my name: name', $result);
    }

    public function testParseTokens5()
    {
        $template = $this->createTemplate2();
        $element  = $this->createElement(array('attribute'));

        $element->expects($this->once())
            ->method('attribute')
            ->will($this->returnArgument(0));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Say my name: ', '{label.age}'
            ),
            $element
        ));
        $this->assertEquals('Say my name: label', $result);
    }

    public function testParseTokens6()
    {
        $template = $this->createTemplate2();
        $element  = $this->createElement(array('attribute'));

        $element->expects($this->once())
            ->method('attribute')
            ->will($this->returnArgument(1));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Say my name: ', '{label.age}'
            ),
            $element
        ));
        $this->assertEquals('Say my name: age', $result);
    }

    public function testParseTokens7()
    {
        $this->haveRunkit();
        $uniqid   = uniqid();
        $template = $this->createTemplate(array('_runCall'));
        $element  = $this->createElement();

        $this->redefineMockFinalOrPrivateMethod($template, '_runCall');
        $template->expects($this->once())
            ->method('_runCall')
            ->will($this->returnValue($uniqid));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Run the method: ', '{call:uniqid}'
            ),
            $element
        ));
        $this->assertEquals('Run the method: '.$uniqid, $result);
    }

    public function testParseTokens8()
    {
        $this->haveRunkit();
        $uniqid   = uniqid();
        $template = $this->createTemplate(array('_renderElements'));
        $element  = $this->createElement();

        $this->redefineMockFinalOrPrivateMethod($template, '_renderElements');
        $template->expects($this->once())
            ->method('_renderElements')
            ->will($this->returnValue($uniqid));

        $method   = new ReflectionMethod($template, '_parseTokens');
        $method->setAccessible(true);
        $result = $method->invokeArgs($template, array(
            array(
                'Run the method: ', '{subElements}'
            ),
            $element
        ));
        $this->assertEquals('Run the method: '.$uniqid, $result);
    }

    /**
     * @dataProvider validInvalidCalls
     */
    public function testIsCall($testString, $testOutput)
    {
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_isCall');
        $method->setAccessible(true);
        $output = $method->invokeArgs($template, array($testString));
        $this->assertEquals($testOutput, (bool) $output);
    }

    public function validInvalidCalls()
    {
        return array(
            array('{call:name}', true),
            array('{call:name7}', true),
            array('{call:Age}', true),
            array('call', false),
            array('{}', false),
            array('call.name', false),
            array('call:name', false),
            array('{call}', false),
            array('{call.name}', false),
            array('{call:_age}', false),
            array('{call:a_e', false),
            array('{call:name', false),
            array('call:name}', false),
            array('{call:756}', false),
        );
    }

    public function testRunCall()
    {
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_runCall');
        $method->setAccessible(true);
        $element = $this->createElement(array(), null, array('cpto'));
        $element->expects($this->once())
            ->method('cpto')
            ->will($this->returnValue('CPTO'));
        $output = $method->invokeArgs($template, array(
            'cpto', $element
        ));
        $this->assertEquals('CPTO', $output);
    }

    public function testRunCall2()
    {
        function myFunction()
        {
            return 'My sample';
        }
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_runCall');
        $method->setAccessible(true);
        $element = $this->createElement();
        $output = $method->invokeArgs($template, array(
            'myFunction', $element
        ));
        $this->assertEquals('My sample', $output);
    }

    public function testRunCall3()
    {
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_runCall');
        $method->setAccessible(true);
        $element = $this->createElement();
        $output = $method->invokeArgs($template, array(
            'inexistentFuncion', $element
        ));
        $this->assertEquals('', $output);
    }

    public function testRunCall4()
    {
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_runCall');
        $method->setAccessible(true);
        $element = $this->createElement();
        $output = $method->invokeArgs($template, array(
            'date', // needs more than one parameter
            $element
        ));
        $this->assertEquals('', $output);
    }

    public function testRunCall5()
    {
        $template = $this->createTemplate();
        $method = new ReflectionMethod($template, '_runCall');
        $method->setAccessible(true);
        $element = $this->createElement();
        $output = $method->invokeArgs($template, array(
            'setSubElements', // needs more than one parameter
            $element
        ));
        $this->assertEquals('', $output);
    }
}

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
            get_parent_class($template),
            $method,
            null,
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
    }

    public function testRender()
    {
        // Verify if php have runKit
        $this->haveRunkit();

        $template = $this->createTemplate(array('_renderElements'));
        $this->redefineMockFinalOrPrivateMethod($template, '_renderElements');

        $template->expects($this->once())
             ->method('_renderElements')
             ->will($this->returnValue('RENDER ELEMENTS'));

        $form = new Apolo_Component_Formulator($this->complexElementTree);
        $template->setForm($form);
        $this->assertEquals('RENDER ELEMENTS', $template->render());
    }

}

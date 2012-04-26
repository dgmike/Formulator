<?php
class Apolo_Component_Formulator_ElementTest
    extends PHPUnit_Framework_TestCase
{
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

    public function createElement(array $methods = array(), $element = null)
    {
        if (null === $element) {
            $element = $this->html;
        }
        return $this->getMockForAbstractClass(
            'Apolo_Component_Formulator_Element',
            array($element),
            $mockClassName = '',
            $callOriginalConstructor = true,
            $callOriginalClone = true,
            $callAutoload = true,
            $methods
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::__construct
     * @covers Apolo_Component_Formulator_Element::setElement
     */
    public function testCallsElement()
    {
        $element = $this->createElement(array(
            'setElement', 'setSubElements'
        ));

        // allways run setElement
        $element->expects($this->once())
                ->method('setElement');

        // have no subelements
        $element->expects($this->never())
                ->method('setSubElements');

        $element->__construct($this->html);
    }

    /**
     * @covers Apolo_Component_Formulator_Element::__construct
     * @covers Apolo_Component_Formulator_Element::setAcceptSubElements
     * @covers Apolo_Component_Formulator_Element::setElement
     */
    public function testCallElement2()
    {
        $elements = $this->html + $this->subElements;
        $element = $this->createElement(array(
            'setElement', 'setSubElements'
        ));

        $element->setAcceptSubElements(true);

        // allways run setElement
        $element->expects($this->once())
                ->method('setElement');

        // running subelements
        $element->expects($this->once())
                ->method('setSubElements');

        $element->__construct($elements);
    }

    /**
     * @covers Apolo_Component_Formulator_Element::__construct
     * @covers Apolo_Component_Formulator_Element::setAcceptSubElements
     * @covers Apolo_Component_Formulator_Element::setElement
     */
    public function testCallElement3()
    {
        $elements = $this->html + $this->subElements;
        $element = $this->createElement(array(
            'setElement', 'setSubElements'
        ));

        $element->setAcceptSubElements(false);

        // never runs if you can not accept
        $element->expects($this->never())
                ->method('setSubElements');

        $element->__construct($elements);
    }

    /**
     * @covers Apolo_Component_Formulator_Element::__construct
     * @covers Apolo_Component_Formulator_Element::getValue
     */
    public function testCallElement4()
    {
        $element = $this->createElement();
        $element->__construct(array(
            'type'    => 'html',
            'content' => '',
            'value'   => 'simple value',
        ));
        $this->assertEquals('simple value', $element->getValue());
    }

    /**
     * @covers Apolo_Component_Formulator_Element::validAttribute
     */
    public function testValidAttribute()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'html' => array(
                'class', 'id'
            ),
        );
        $this->assertTrue($element->validAttribute('html', 'class'));
        $this->assertFalse($element->validAttribute('html', 'onClick'));
        $this->assertFalse($element->validAttribute('content', 'any'));
    }

    /**
     * @covers Apolo_Component_Formulator_Element::validAttribute
     */
    public function testValidAttribute2()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'html' => array(
                'class', 'id'
            ),
            'content' => array(
            ),
        );
        foreach (range(1, 10) as $item) {
            $attribute = uniqid();
            // choose one of both
            $content = array_rand(array_flip(array('html', 'content')));
            $this->assertTrue(
                $element->validAttribute('html', 'data-' . $attribute)
            );
        }
    }

    /**
     * @covers Apolo_Component_Formulator_Element::validAttribute
     */
    public function testValidAttribute3()
    {
        $element = $this->createElement();
        $this->assertFalse(
            $element->validAttribute('html', 'data-noelement')
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::validAttribute
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for context
     */
    public function testValidAttribute4()
    {
    	$element = $this->createElement();
        $element->validAttribute(array(), 'whaterver');
    }

    /**
     * @covers Apolo_Component_Formulator_Element::validAttribute
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for attribute
     */
    public function testValidAttribute5()
    {
    	$element = $this->createElement();
        $element->validAttribute('whatever', new stdClass);
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::validAttribute
     */
    public function testSetAttribute()
    {
        $element = $this->createElement();
        // validating data- on html element
        $element->validAttributes = array(
            'html' => array(),
        );
        $element->setAttribute('html', 'data-any', uniqid());
        $this->assertNotEmpty($element->attribute('html', 'data-any'));
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::validAttribute
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid attribute for: anycontext/anyattr
     */
    public function testSetAttribute2()
    {
        $element = $this->createElement();
        $element->setAttribute('anycontext', 'anyattr', 'anyvalue');
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::validAttribute
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for context
     */
    public function testSetAttribute3()
    {
        $element = $this->createElement();
        $element->setAttribute(array(), 'attribute', 'value');
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::validAttribute
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for attribute
     */
    public function testSetAttribute4()
    {
        $element = $this->createElement();
        $element->setAttribute('context', new stdClass, 'value');
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::validAttribute
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for value
     */
    public function testSetAttribute5()
    {
        $element = $this->createElement();
        $element->setAttribute('context', 'attribute', fopen(__FILE__, 'r'));
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for context
     */
    public function testAttribute()
    {
        $element = $this->createElement();
        $element->attribute(array());
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for attribute
     */
    public function testAttribute2()
    {
        $element = $this->createElement();
        $element->attribute('context', array());
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for showAttribute
     */
    public function testAttribute3()
    {
        $element = $this->createElement();
        $element->attribute(
            'context', 'attribute', 'showAttribute can only be boolean'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument for escaped
     */
    public function testAttribute4()
    {
        $element = $this->createElement();
        $element->attribute(
            'context', 'attribute', true, 'escaped can only be boolean'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     */
    public function testAttribute5()
    {
        $element = $this->createElement();
        $value = $element->attribute('anycontext');
        $this->assertEquals(
            '', $value, 'Context was not defined'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @covers Apolo_Component_Formulator_Element::setAttribute
     */
    public function testAttribute6()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'html' => array(
                'class', 'id'
            ),
        );
        $element->setAttribute('html', 'data-any', 'anyvalue');

        $value = $element->attribute('html', 'invalidValue');
        $this->assertEquals(
            '', $value, 'Context was not defined'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @covers Apolo_Component_Formulator_Element::setAttribute
     */
    public function testAttribute7()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'html' => array(
                'class', 'id'
            ),
        );
        $element->setAttribute('html', 'class', 'input text');
        $element->setAttribute('html', 'data-any', 'anyvalue');

        $value = $element->attribute('html', 'data-any');
        $this->assertEquals(
            ' data-any="anyvalue"', $value, 'Context defined'
        );

        $value = $element->attribute('html', 'class', true);
        $this->assertEquals(
            ' class="input text"', $value, 'Context defined'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @covers Apolo_Component_Formulator_Element::setAttribute
     */
    public function testAttribute8()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'html' => array(
                'class', 'id'
            ),
        );
        $element->setAttribute('html', 'class', 'input text');
        $element->setAttribute('html', 'data-any', 'anyvalue');

        $value = $element->attribute('html', 'data-any', false);
        $this->assertEquals(
            'anyvalue', $value, 'Context defined'
        );

        $value = $element->attribute('html', 'class', false);
        $this->assertEquals(
            'input text', $value, 'Context defined'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::attribute
     * @covers Apolo_Component_Formulator_Element::setAttribute
     */
    public function testAttribute9()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'html' => array(
                'class', 'id'
            ),
        );
        $element->setAttribute('html', 'class', '"myClassName"');

        $value = $element->attribute('html', 'class', false);
        $this->assertEquals(
            '&quot;myClassName&quot;', $value, 'Context escaped by default'
        );

        $value = $element->attribute('html', 'class', false, true);
        $this->assertEquals(
            '&quot;myClassName&quot;', $value, 'Context escaped'
        );

        $value = $element->attribute('html', 'class', false, false);
        $this->assertEquals(
            '"myClassName"', $value, 'Context not escaped'
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAcceptSubElements
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Parameter invalid. Must be a boolean
     */
    public function testSetAcceptSubElements()
    {
    	$element = $this->createElement();
    	$element->setAcceptSubElements('invalid type, not boolean');
    }

	/**
	 * @covers Apolo_Component_Formulator_Element::setSubElements
	 * @covers Apolo_Component_Formulator::element
	 */
    public function testSetSubElements()
    {
        $element = $this->createElement();
        $element->setSubElements(array(
            array(
                'type'    => 'html',
                'content' => 'My Content',
            ),
        ));
        $this->assertCount(1, $element->subElements, 'Sets a subElement');

        $element = $this->createElement();
        $element->setSubElements(array(
            array(
                'type'    => 'html',
                'content' => 'My Content',
            ),
            array(
                'type'    => 'html',
                'content' => 'My Other Content',
            ),
        ));
        $this->assertCount(2, $element->subElements, 'Sets a subElement');
    }

	/**
	 * @covers Apolo_Component_Formulator_Element::setSubElements
	 * @covers Apolo_Component_Formulator::element
	 */
    public function testSetSubElements2()
    {
        $element = $this->createElement();
        $element->setSubElements(array(
            array(
                'type'    => 'html',
                'content' => 'My Content',
            ),
        ));
        $this->assertCount(1, $element->subElements, 'Sets a subElement');

        $element->setSubElements(array(
            array(
                'type'    => 'html',
                'content' => 'My Content',
            ),
            array(
                'type'    => 'html',
                'content' => 'My Other Content',
            ),
        ));
        $this->assertCount(
            2, $element->subElements, 'reset and sets a subElement'
        );
    }

	/**
	 * @covers Apolo_Component_Formulator_Element::setSubElements
	 * @covers Apolo_Component_Formulator::element
	 */
    public function testSetSubElements3()
    {
        $element = $this->createElement();
        $element->setSubElements(array(
            array(
                'type'    => 'html',
                'content' => 'My Content',
            ),
        ));
        $this->assertInstanceOf(
            'Apolo_Component_Formulator_Element', $element->subElements[0]);
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setValue
     * @covers Apolo_Component_Formulator_Element::getValue
     */
    public function testSetGetValue()
    {
        $element = $this->createElement();
        $element->setValue('my value');
        $this->assertEquals('my value', $element->getValue());
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setValue
     * @covers Apolo_Component_Formulator_Element::getValue
     */
    public function testGetValue()
    {
        $element = $this->createElement();
        $element->setValue('"my value"');
        $this->assertEquals('&quot;my value&quot;', $element->getValue());
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setValue
     * @covers Apolo_Component_Formulator_Element::getValue
     */
    public function testGetValue2()
    {
        $element = $this->createElement();
        $element->setValue('"my value"', true);
        $this->assertEquals('&quot;my value&quot;', $element->getValue(true));

        $this->assertEquals('"my value"', $element->getValue(false));
    }
    
    /**
     * @covers Apolo_Component_Formulator_Element::setValue
     * @covers Apolo_Component_Formulator_Element::getValue
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument, must be boolean type
     */
    public function testGetValue3()
    {
        $element = $this->createElement();
        $element->setValue('"my value"', true);
        $element->getValue('invalid type');
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::attributes
     */
    public function testAttributes()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'default' => array('name'),
        );
        $element->setAttribute('default', 'data-person', 'Mike');
        $element->setAttribute('default', 'name', 'person');

        $this->assertEquals(
            ' data-person="Mike" name="person"',
            $element->attributes()
        );
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::attributes
     */
    public function testAttributes2()
    {
        $element = $this->createElement();
        $element->validAttributes = array(
            'default' => array('name'),
        );
        $this->assertEmpty($element->attributes());
        $this->assertEmpty($element->attributes('anycontext'));
        $element->setAttribute('default', 'data-anytype', '');
        $this->assertEmpty($element->attributes());
    }

    /**
     * @covers Apolo_Component_Formulator_Element::setAttribute
     * @covers Apolo_Component_Formulator_Element::attributes
     *
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument type
     */
    public function testAttributes3()
    {
        $element = $this->createElement();
        $element->attributes(new stdClass);
    }
}

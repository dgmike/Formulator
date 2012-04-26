<?php
/**
 * Requiring configurations
 */
require_once __DIR__ . '/config.php';

class Apolo_Component_FormulatorTest 
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var Apolo_Component_Formulator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Apolo_Component_Formulator;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        @unlink(dirname(__DIR__) . '/src/Element/Invalidclass.php');
        @unlink(dirname(__DIR__) . '/src/Element/Invalid/Class.php');
        @rmdir(dirname(__DIR__) . '/src/Element/Invalid');
    }

    /**
     * @covers Apolo_Component_Formulator::__construct
     * @covers Apolo_Component_Formulator::getConfig
     * @covers Apolo_Component_Formulator::getElements
     */
    public function testInitCallsAConfigCommand()
    {
        $this->object = new Apolo_Component_Formulator();
        $config = $this->object->getConfig();
        $this->assertCount(
            0, $config, 'No configuration'
        );
        $this->assertEquals(
            array(), $config, 'No configuration'
        );
        $this->assertEquals(
            array(), $this->object->getElements(), 'No element setted'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::__construct
     * @covers Apolo_Component_Formulator::getConfig
     * @covers Apolo_Component_Formulator::getElements
     */
    public function testInitCallsAConfigCommand2()
    {
        $this->object = new Apolo_Component_Formulator(array(
            'method' => 'POST',
        ));
        $config = $this->object->getConfig();
        $this->assertCount(
            1, $config, 'Have configured'
        );
        $this->assertEquals(
            'POST', $config['method'], 'Configured method'
        );
        $this->assertEquals(
            array(), $this->object->getElements(), 'No element setted'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::__construct
     * @covers Apolo_Component_Formulator::getConfig
     * @covers Apolo_Component_Formulator::getElements
     */
    public function testInitCallsAConfigCommand3()
    {
        $this->object = new Apolo_Component_Formulator(array(
            'elements' => array(array(
                'type' => 'html',
                'content' => '',
            )),
        ));
        $this->assertEquals(
            array(), $this->object->getConfig(), 'No configuration was setted'
        );
        $this->assertCount(
            1, $this->object->getElements(), 'Added one element'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::__construct
     * @covers Apolo_Component_Formulator::getConfig
     * @covers Apolo_Component_Formulator::getElements
     */
    public function testInitCallsAConfigCommand4()
    {
        $this->object = new Apolo_Component_Formulator($configuration = null, 
            array(
                'type' => 'html',
                'content' => '',
            ), array(
                'type' => 'html',
                'content' => '',
            )
        );
        $this->assertEquals(
            array(), $this->object->getConfig(), 'Null not sets a config'
        );
        $this->assertCount(
            2, $this->object->getElements(), 'Setted 2 elements'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::config
     * @covers Apolo_Component_Formulator::getConfig
     */
    public function testConfigSetsTheConfigValuesAndElements()
    {
        $uniqId = uniqId();
        $this->object->config(array(
            'method' => 'post',
            'action' => '/my/custom/url/' . $uniqId,
        ));
        $config = $this->object->getConfig();
        $this->assertEquals(
            $config['method'], 'post', 'The method was setted'
        );
        $this->assertEquals(
            $config['action'], '/my/custom/url/' . $uniqId,
            'The action was setted'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::config
     * @covers Apolo_Component_Formulator::getConfig
     * @covers Apolo_Component_Formulator::getElements
     */
    public function testConfigSetsTheConfigValuesAndElements2()
    {
        $uniqId = uniqId();
        $this->object->config(array(
            'method' => 'post',
            'action' => '/my/custom/url/' . $uniqId,
        ));
        $this->object->config(array(
            'method' => 'get',
            'id'     => 'myID',
        ));
        $config = $this->object->getConfig();
        $this->assertEquals(
            $config['action'], '/my/custom/url/' . $uniqId,
            'The action not changed'
        );
        $this->assertEquals(
            $config['id'], 'myID', 'New value for ID'
        );
        $this->assertEquals(
            $config['method'], 'get', 'Changed the method'
        );
        $this->assertCount(
            0, $this->object->getElements(), 'No element was setted'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::config
     * @covers Apolo_Component_Formulator::getElements
     */
    public function testConfigSetsTheConfigValuesAndElements3()
    {
        $this->object->config(array(
            'elements' => array(
                array(
                    'type' => 'html',
                    'content' => '',
                ),
            ),
        ));
        $this->assertCount(
            1, $this->object->getElements(), 'One element is added'
        );
        $this->object->config(array(
            'elements' => array(
                array(
                    'type' => 'html',
                    'content' => '',
                ),
            ),
        ));
        $this->assertCount(
            2, $this->object->getElements(), 'A new element is added'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::config
     * @covers Apolo_Component_Formulator::getValues
     */
    public function testConfigSetsTheConfigValuesAndElements4()
    {
        $this->object->config(array(
            'values' => array(
                'person' => 'Michael',
                'status' => 'married',
            ),
        ));
        $values = $this->object->getValues();
        $this->assertEquals(
            'Michael', $values['person'], 'Setted value over config'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::config
     * @covers Apolo_Component_Formulator::getValues
     */
    public function testConfigSetsTheConfigValuesAndElements5()
    {
        $this->object->config(array(
            'values' => array(
                'person' => 'Michael',
                'status' => 'married',
            ),
        ));
        $this->object->config(array(
            'values' => array(
                'person' => 'Alice',
                'age'    => 21,
            ),
        ));
        $values = $this->object->getValues();
        $this->assertEquals(
            'Alice', $values['person'], 'Reseted value over config'
        );
        $this->assertEquals(
            '21', $values['age'], 'Setted new value over config'
        );
        $this->assertFalse(
            array_key_exists('status', $values), 'Old values are unseted'
        );
    }

    /**
     * @deprecated 2012-04-19
     *
     * @covers Apolo_Component_Formulator::setForm
     * @covers Apolo_Component_Formulator::getForm
     * /
    public function testSetFormJustNeedsToPassTheArguments()
    {
        $form = array(
            uniqId(true) => uniqId(true),
        );
        $this->object->setForm($form);
        $newForm = $this->object->getForm();
        $this->assertEquals(
            $form, $newForm, 'Just pass the config..'
        );
    }
    */

    /**
     * @covers Apolo_Component_Formulator::config
     * @covers Apolo_Component_Formulator::getConfig
     */
    public function testGetConfig()
    {
        $this->object->config(array(
            'target' => '_blank',
        ));
        $config = $this->object->getConfig();
        $this->assertEquals(
            '_blank', $config['target'], 'Getting the right config'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElements
     * @covers Apolo_Component_Formulator::getElements
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     */
    public function testAddElements()
    {
        $this->object->addElements(array());
        $this->assertCount(
            0, $this->object->getElements(), 'Empty array is not object'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElements
     * @covers Apolo_Component_Formulator::getElements
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     */
    public function testAddElements2()
    {
        $this->object->addElements(array(
            array(
                'type'    => 'html',
                'content' => '',
            )
        ));
        $this->assertCount(
            1, $this->object->getElements(), 'Added one element'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElements
     * @covers Apolo_Component_Formulator::getElements
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     */
    public function testAddElements3()
    {
        $this->object->addElements(array(
            array(
                'type'    => 'html',
                'content' => '',
            ),
            array(
                'type'    => 'html',
                'content' => '',
            ),
        ));
        $this->assertCount(
            2, $this->object->getElements(), 'Added two element'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElement
     * @covers Apolo_Component_Formulator::getElements
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     */
    public function testAddElement()
    {
        $this->object->addElement(array(
            'type' => 'html',
            'content' => '',
        ));
        $this->assertCount(
            1, $this->object->getElements(), 'Added one element'
        );
        $this->object->addElement(array(
            'type' => 'html',
            'content' => '',
        ));
        $this->assertCount(
            2, $this->object->getElements(), 'Added other element'
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElement
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage The element has no "type" defined
     */
    public function testAddElement2()
    {
        $this->object->addElement(array());
    }

    /**
     * @covers Apolo_Component_Formulator::addElement
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     * @dataProvider             invalidTypeArguments
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Invalid element "type"
     */
    public function testAddElement3($type)
    {
        $this->object->addElement(array(
            'type' => $type,
        ));
    }

    public function invalidTypeArguments()
    {
        return array(
            array(new stdClass),
            array(' name '),
            array(' name'),
            array('name '),
            array('~name'),
            array('*name'),
            array('my type'),
            array('_my_new_type'), // starts with underline
            array('my_new_type_'), // ends with underline
            array('a'),            // one character
            array('\\name'),       // invalid character
            array('nam/e'),        // invalid character
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElement
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     * @dataProvider typeTestFiles
     */
    public function testAddElement4($type, $file)
    {
        $file = str_replace('/', DIRECTORY_SEPARATOR, $file);
        $this->setExpectedException(
            'PHPUnit_Framework_Error_Warning'
        );
        $this->object->addElement(array(
            'type' => $type,
        ));
    }

    public function typeTestFiles()
    {
        return array(
            array('invalidfilename',    'Element/Invalidfilename.php'),
            array('invalid_filename',   'Element/Invalid/Filename.php'),
            array('invalidFilename',    'Element/Invalid/Filename.php'),
            array('invalid__Filename',  'Element/Invalid/Filename.php'),
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addElement
     * @covers Apolo_Component_Formulator::element
     * @covers Apolo_Component_Formulator::retriveFileClass4Element
     * @dataProvider typeTestClass
     */
    public function testAddElement5($type, $className)
    {
        if (!file_exists(dirname(__DIR__) . '/Element/Invalid')) {
            mkdir(dirname(__DIR__) . '/src/Element/Invalid');
        }
        file_put_contents(dirname(__DIR__) . '/src/Element/Invalidclass.php', '');
        file_put_contents(dirname(__DIR__) . '/src/Element/Invalid/Class.php', '');

        $this->setExpectedException(
            'DomainException', 
            "Class not defined: " . $className
        );
        $this->object->addElement(array(
            'type' => $type,
        ));

    }

    public function typeTestClass()
    {
        return array(
            array(
                'invalidclass',
                'Apolo_Component_Formulator_Element_Invalidclass'
            ),
            array(
                'invalidClass',
                'Apolo_Component_Formulator_Element_Invalid_Class'
            ),
            array(
                'invalid_class',
                'Apolo_Component_Formulator_Element_Invalid_Class'
            ),
            array(
                'invalid__class',
                'Apolo_Component_Formulator_Element_Invalid_Class'
            ),
        );
    }

    /**
     * @covers Apolo_Component_Formulator::render
     * @covers Apolo_Component_Formulator::setTemplate
     * @dataProvider gerenateMockTemplateAndTenderTypes
     */
    public function testRender($mock, $area, $expected)
    {
        $this->object->setTemplate($mock);
        $output = $this->object->render($area);
        $this->assertEquals($output, $expected);
    }

    public function newMockTemplate() {
        $template = $this->getMock('stdClass', array(
            'render', 'renderMedia', 'renderOpenForm', 'renderCloseForm',
            'setForm'
        ));
        $template->expects($this->once())
                 ->method('render')
                 ->will($this->returnValue('<input />'));

        $template->expects($this->exactly(2))
                 ->method('renderMedia')
                 ->will($this->returnValueMap(array(
                    array('css', array('file.css')),
                    array('js',  array('file.js')),
                 )));

        $template->expects($this->once())
                 ->method('renderOpenForm')
                 ->will($this->returnValue('<form>'));

        $template->expects($this->once())
                 ->method('renderCloseForm')
                 ->will($this->returnValue('</form>'));

        $template->expects($this->once())
                 ->method('setForm');

        return $template;
    }

    public function gerenateMockTemplateAndTenderTypes()
    {
        return array(
            array($this->newMockTemplate(), null, implode(' ', array(
                'mediaJS' => 'file.js',
                'mediaCss' => 'file.css',
                'openForm' => '<form>', 
                'elements' => '<input />',
                'closeForm' => '</form>',
            ))),
            array($this->newMockTemplate(), 'openForm', '<form>'),
            array($this->newMockTemplate(), 'closeForm', '</form>'),
            array($this->newMockTemplate(), 'mediaJS', 'file.js'),
            array($this->newMockTemplate(), 'mediaCSS', 'file.css'),
            array($this->newMockTemplate(), 'elements', '<input />'),
        );
    }

    /**
     * @covers Apolo_Component_Formulator::render
     */
    public function testOnEmptyTemplateUseDefaultTemplate()
    {
        $this->object->render();
        $class = get_class($this->object->getTemplate());
        $this->assertEquals(
            'Apolo_Component_Formulator_Template_Default', $class
        );
    }

    /**
     * @covers Apolo_Component_Formulator::setTemplate
     */
    public function testSetTemplateIncludesAFile()
    {
        $this->object->setTemplate('debug');
        $class = get_class($this->object->getTemplate());
        $this->assertEquals(
            'Apolo_Component_Formulator_Template_Debug', $class
        );
    }

    /**
     * @covers Apolo_Component_Formulator::__toString
     * @covers Apolo_Component_Formulator::setTemplate
     */
    public function test__toString()
    {
    	$this->object->setTemplate($this->newMockTemplate());
    	$output = (string) $this->object;
        $this->assertEquals(
            'file.js file.css <form> <input /> </form>', $output
        );
    }

    /**
     * @covers Apolo_Component_Formulator::addMedia
     * @covers Apolo_Component_Formulator::getMedia
     */
    public function testAddGetMedia()
    {
        $media = $this->object->getMedia();
        $this->assertCount(2, $media, 'Ony CSS and JS files');

        $this->object->addMedia('test.js');
        $media = $this->object->getMedia();

        $this->assertCount(0, $media['css'], 'Not added CSS files');
        $this->assertCount(1, $media['js'],  'Added one JavaScript');

        $this->object->addMedia('test.css');
        $media = $this->object->getMedia();
        $this->assertCount(1, $media['css'], 'Add new CSS');
        $this->assertCount(1, $media['js'],  'No new JavaScript');

        $this->object->addMedia('test.xml');
        $media = $this->object->getMedia();
        $this->assertCount(1, $media['css'], 'No new CSS');
        $this->assertCount(1, $media['js'],  'No new JavaScript');

        $this->assertCount(2, $media, 'Ony CSS and JS files');
    }

    /**
     * @covers       Apolo_Component_Formulator::setTemplate
     * @dataProvider invalidTemplateNames
     */
    public function testSetTemplate($template)
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Invalid template name'
        );
        $this->object->setTemplate($template);
    }

    public function invalidTemplateNames()
    {
        return array(
            array('~my name'),
            array('-my name'),
            array(' my name '),
            array(' '),
            array('my*name'),
            array(''),
            array('myname '),
            array('187373'),
            array('_my'),
        );
    }

    /**
     * @covers            Apolo_Component_Formulator::setTemplate
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testSetTemplate2()
    {
        $this->object->setTemplate('invalidclassfilename');
    }

    /**
     * @covers Apolo_Component_Formulator::setTemplate
     * @covers Apolo_Component_Formulator::getTemplate
     */
    public function testSetTemplate3()
    {
        $this->object->setTemplate('mocktemplate');
        $this->assertEquals(
            'Apolo_Component_Formulator_Template_Mocktemplate', 
            get_class($this->object->getTemplate())
        );
    }
}

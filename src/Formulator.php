<?php
/**
 * Formulator Component
 *
 * Use this component to make HTML forms anywhere.
 *
 * PHP Version 5.2
 *
 * @category  Component
 * @package   Component
 * @author    Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author    Michell Campos <michell@corp.virgula.com.br>
 * @copyright 2011-2012 Virgula S/A
 * @license   Virgula Copyright
 * @link      http://virgula.uol.com.br
 */

/**
 * loading abstract classes used in background
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Element.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Template.php';

/**
 * Formulator Component
 *
 * This Class has informations about form and his sub elements
 *
 * @category  Component
 * @package   Formulator\Core
 * @author    Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author    Michell Campos <michell@corp.virgula.com.br>
 * @copyright 2011-2012 Virgula S/A
 * @license   Virgula Copyright
 * @link      http://virgula.uol.com.br
 */
class Apolo_Component_Formulator
    implements RecursiveIterator
{
	private $_position = 0;

    const CLASS_PATTERN = '@^[a-z][a-z0-9_]*[a-z0-9]+$@i';
    const DS = DIRECTORY_SEPARATOR;

    /**
     * This is the form configuration
     *
     * @access private
     * @var array
     */
    private $_config   = array();

    /**
     * This is the form set of elements
     *
     * @access private
     * @var array
     */
    private $_elements = array();

    /**
     * This is the form set of values
     *
     * @access private
     * @var array
     */
    private $_values   = array();

    /**
     * This is the media used by the form
     *
     * It contains the CSS and JS elements
     *
     * @access private
     * @var array
     */
    private $_media = array(
        'css' => array(),
        'js'  => array(),
    );

    /**
     * This is the template object
     *
     * @access private
     * @var object
     */
    private $_template = null;

    /**
     * Construct the Formulator object
     *
     * You can pass an array with configurations and sub elements of form
     *
     *     $form = new Apolo_Component_Formulator(array(
     *         'method' => 'post',
     *         'target' => '_blank',
     *     ));
     *
     * @param array $args optional configs
     *
     * @uses Apolo_Component_Formulator::config()
     * @uses Apolo_Component_Formulator::addElements()
     *
     * @return void
     */
    public function __construct($args = array())
    {
        $args              = func_get_args();
        $is_config_present = (isset($args[0]) && !isset($args[0][0]));
        $config_is_null    = (array_key_exists(0, $args) && null == $args[0]);
        if ($is_config_present || $config_is_null) {
            if ($config = array_shift($args)) {
                $this->config($config);
            }
        }
        $this->addElements($args);
    }

    /**
     * This method configure and write the values and elements on form object.
     *
     * Passing an array and you can configure the form object with params of
     * tag <samp>form</samp>.
     *
     * The bellow code converts the form method to POST.
     *
     *     $form = new Apolo_Component_Formulator;
     *     $form->config(array(
     *         'method' => 'post',
     *     ));
     *
     * Passing the values in this array you can set the values of form.
     *
     * The bellow code set the elements <sapm>name</samp> and <samp>age</samp>
     * on form.
     *
     *     $form = new Apolo_Component_Formulator;
     *     $form->config(array(
     *         'values' => array(
     *             'name' => 'michell',
     *             'age'  => '31',
     *         ),
     *     ));
     *
     * Passing an array to configure the elements of form.
     *
     * The bellow code add 2 elements on form: <samp>name</samp> and
     * <samp>age</samp>.
     *
     *     $form = new Apolo_Component_Formulator;
     *     $form->config(array(
     *         'elements' => array(
     *             array(
     *                 'type' => 'text',
     *                 'name' => 'name',
     *             ),
     *             array(
     *                 'type' => 'number',
     *                 'name' => 'age',
     *             ),
     *         ),
     *     ));
     *
     * @param array $config config of form, values or/and elements
     *
     * @uses Apolo_Component_Formulator::addElements()
     *
     * @return Apolo_Component_Formulator
     */
    public function config($config)
    {
        if (isset($config['values'])) {
            $this->_values = $config['values'];
        }
        if (isset($config['elements'])) {
            $this->addElements($config['elements']);
        }
        unset($config['elements'], $config['values']);
        $this->_config = $config + $this->_config;
        return $this;
    }

    /**
     * This method get the form's config.
     *
     * With the bellow example you can get the form method.
     *
     *     // $form is an Apolo_Component_Formulator Object setted
     *     // on another file.
     *     $config = $form->getConfig();
     *     echo $config['method'];
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * This method add an array of elements.
     *
     * See how it works.
     *
     * {@source}
     *
     * @param array $elements array of elements
     *
     * @uses Apolo_Component_Formulator::addElement()
     *
     * @return void
     */
    public function addElements(array $elements)
    {
        /** @var array $element */
        foreach ($elements as $element) {
            $this->addElement($element);
        }
    }

    /**
     * This method add an element.
     *
     * This need to have a type and the type must be a string containing only
     * alpha lowecase characters. All elements types are listed in Element
     * directory. See some samples on config method.
     *
     * @param array $element array of config of element
     *
     * @see Apolo_Component_Formulator::config()
     * @uses Apolo_Component_Formulator::element()
     * @return Apolo_Component_Formulator
     */
    public function addElement($element)
    {
    	if ($element instanceof Apolo_Component_Formulator_Element) {
        	$this->_elements[] = $element;
        	return;
        }
        $this->_elements[] = self::element($element);
    }

    /**
     * This method generates a Element Object
     *
     * Use this static method to generate new elements and use in addElement
     * method and inside each element when it creates subelements.
     *
     * @param array $element Element configurations
     *
     * @throws InvalidArgumentException When <code>$element['type']</code> is
     *  not set
     * @throws InvalidArgumentException When $element['type'] is not
     *  alpha-dash-numeric or starts with a dash or number
     * @throws DomainException When element class file not found
     * @throws DomainException When element class not defined
     *
     * @see Apolo_Component_Formulator_Element
     * @see Apolo_Component_Formulator::addElement()
     *
     * @static
     * @return Apolo_Component_Formulator_Element
     */
    static public function element(array $element)
    {
        if (empty($element['type'])) {
            throw new InvalidArgumentException(
                'The element has no "type" defined'
            );
        }
        if (   !is_string($element['type'])
            || !preg_match(self::CLASS_PATTERN, $element['type'])
        ) {
            throw new InvalidArgumentException('Invalid element "type"');
        }
        list($file, $class) = self::retriveFileClass4Element($element['type']);
        include_once $file;
        if (!class_exists($class)) {
            throw new DomainException('Class not defined: ' . $class);
        }
        $reflectionClass = new ReflectionClass($class);
        return $reflectionClass->newInstance($element);
    }

    /**
     * Retrives a File and Class Name for a Element
     *
     * @param string $type Type of element
     *
     * @internal
     * @return array
     */
    static public function retriveFileClass4Element($type)
    {
        $replacements = array(
            array('@_+@', '_'),
            array('@_+(\w)@e', 'self::DS . strtoupper("\\1")'),
            array('@([A-Z])@e', 'self::DS . strtoupper("\\1")'),
        );
        $_patterns = array_map('reset', $replacements);
        $_replaces = array_map('end', $replacements);
        $file = preg_replace($_patterns, $_replaces, ucfirst($type));
        $file = 'Element' . self::DS . ucfirst($file) . '.php';
        $file = preg_replace('@\\' . self::DS . '+@', self::DS, $file);
        $className = 'Apolo_Component_Formulator_'
                   . str_replace(self::DS, '_', substr($file, 0, -4));
        $file = __DIR__ . self::DS . $file;
        return array($file, $className);
    }

    /**
     * Sets the template engine
     *
     * Use this method to say what template will render the form. You can pass
     * a string with filename (without extension) over /Template path.
     *
     * @param string|object $template Name or object template
     *
     * @throws InvalidArgumentException When template is not alpha-numeric or it
     *  length is minor than 1
     * @return void
     */
    public function setTemplate($template)
    {
        if (is_object($template)) {
            return $this->_template = $template;
        }
        if (!preg_match(self::CLASS_PATTERN, (string) $template)) {
            throw new InvalidArgumentException('Invalid template name');
        }
        $template = ucfirst(strtolower($template));
        $file     = __DIR__ . '/Template/' . $template . '.php';
        $object   = 'Apolo_Component_Formulator_Template_' . $template;
        if (!class_exists($object)) {
            include $file;
        }
        $reflectionClass = new ReflectionClass($object);
        $this->_template = $reflectionClass->newInstance();
    }

    /**
     * Get template object
     *
     * @return void
     */
    public function getTemplate()
    {
        return $this->_template;
    }

    /**
     * This method render the form using the template object
     *
     * If the template is not setted it get the default template.
     *
     * The follow areas are acepted:
     *
     * - mediaJS
     * - mediaCSS
     * - openForm
     * - closeForm
     * - elements
     *
     * @param string $area Area to render
     *
     * @return string
     */
    public function render($area = null)
    {
        if ($this->_template == null) {
            $this->setTemplate('default');
        }
        $this->_template->setForm($this);
        $form = array(
            'mediaJS'   => implode('', $this->_template->renderMedia('js')),
            'mediaCSS'  => implode('', $this->_template->renderMedia('css')),
            'openForm'  => $this->_template->renderOpenForm(),
            'elements'  => $this->_template->render(),
            'closeForm' => $this->_template->renderCloseForm(),
        );
        if (array_key_exists($area, $form)) {
            return $form[$area];
        }
        return join(' ', $form);
    }

    /**
     * This method return an array of elements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * This is a magic method to print the object.
     *
     * When you print the object it runs render method
     *
     * @see Apolo_Component_Formulator::render()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * This method add css or javascript used by the form.
     *
     * Can be used by any element on it construct.
     *
     * @param string $media the file name
     *
     * @return bool
     */
    public function addMedia($media)
    {
        if (!preg_match('@\.(js|css)$@i', $media, $match)) {
            return false;
        }
        $local = $match[1];
        if (!in_array($media, $this->_media[$local])) {
            $this->_media[$local][] = $media;
        }
    }

    /**
     * This method return an array with the media.
     *
     * @return array
     */
    public function getMedia()
    {
        return $this->_media;
    }

    /**
     * This method return an array with the values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->_values;
    }

    /** Iterator Methods 
     *
     * @TODO document and coverage all above methods
     */

    public function valid()
    {
        return isset($this->_elements[$this->_position]);
    }

    public function hasChildren()
    {
        return (bool) $this->_elements[$this->_position]->subElements;
    }

    public function next()
    {
        $this->_position++;
    }

    public function current()
    {
        return $this->_elements[$this->_position];
    }

    public function getChildren()
    {
    	$elements = array(
            'elements' => $this->_elements[$this->_position]->subElements,
        );
        return new Apolo_Component_Formulator($elements);
    }

    public function rewind()
    {
        $this->_position = 0;
    }

    public function key()
    {
        return $this->_position;
    }
}

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
 * @category   Component
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
class Apolo_Component_Formulator
{
    /**#@+
     * @access private
     * @var array
     */

    /**
     * This is the form configuration 
     */
    private $_config   = array();
    
    /**
     * This is the form set of elements 
     */
    private $_elements = array();
    
    /**
     * This is the form set of values 
     */
    private $_values   = array();
    
    /**
     * This is the media used by the form
     *
     * It contains the CSS and JS elements
     */
    private $_media = array(
        'css' => array(),
        'js'  => array(),
    );
    /**#@-*/

    /**
     * This is the template object 
     *
     * @access private
     * @var object
     */
    private $_template = null;

    /**
     * This is the recursive form element 
     *
     * @ignore
     * @access private
     * @var object
     */
    private $_form = null;

    /**
     * Construct the Formulator object
     * 
     * You can pass an array with configurations and sub elements of form
     * <code>
     * $form = new Apolo_Component_Formulator(array(
     *     'method' => 'post',
     *     'target' => '_blank',
     * ));
     * </code>
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
        $this->_form = $this;
        $args = func_get_args();
        $is_config_present = (isset($args[0]) && !isset($args[0][0]));
        $config_is_null = (array_key_exists(0, $args) && null == $args[0]);
        if ($is_config_present || $config_is_null) {
            $config = array_shift($args);
            if ($config) {
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
     * <code>
     * $form = new Apolo_Component_Formulator;
     * $form->config(array(
     *     'method' => 'post',
     * ));
     * </code>
     *
     * Passing the values in this array you can set the values of form.
     *
     * The bellow code set the elements <sapm>name</samp> and <samp>age</samp> 
     * on form.
     *
     * <code>
     * $form = new Apolo_Component_Formulator;
     * $form->config(array(
     *     'values' => array(
     *         'name' => 'michell',          
     *         'age'  => '31',          
     *     ),
     * ));
     * </code>
     *
     * Passing an array to configure the elements of form.
     *
     * The bellow code add 2 elements on form: <samp>name</samp> and 
     * <samp>age</samp>.
     *
     * <code>
     * $form = new Apolo_Component_Formulator;
     * $form->config(array(
     *     'elements' => array(
     *         array(
     *             'type' => 'text',
     *             'name' => 'name',
     *         ),
     *         array(
     *             'type' => 'number',
     *             'name' => 'age',
     *         ),
     *     ),
     * ));
     * </code>
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
            unset($config['values']);
        }
        if (isset($config['elements'])) {
            $this->addElements($config['elements']);
            unset($config['elements']);
        }
        $this->_config = $config + $this->_config;
        return $this;
    }


    /**
     * This method reset the form with your config and elements 
     * 
     * {@internal
     * when we create these subelements need to have the form page
     * information. Internally subelements have an object
     * form for each element. This element has all the
     * element settings page. To retrieve this information,
     * this method is used internally.
     * }
     *
     * @param Apolo_Component_Formulator $form The object to be resetted
     *
     * @ignore
     *
     * @return void
     */
    public function setForm($form)
    {
        $this->_form = $form;
    }

    /**
     * Just to read the form attributes
     *
     * @return array
     */
    public function getForm()
    {
        return $this->_form;
    }

    /**
     * This method get the form's config.
     * 
     * With the bellow example you can get the form method. 
     * 
     * <code> 
     * // $form is an Apolo_Component_Formulator Object setted on another file.
     * $config = $form->getConfig();
     * echo $config['method'];
     * </code>
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
     * @return Apolo_Component_Formulator
     */ 
    public function addElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        return $this;
    }

    /**
     * This method add an element.
     *
     * This need to have a type and the type must be a string containing only 
     * alpha lowecase characters. All elements types are listed in Element 
     * directory. See some samples on 
     * {@link Apolo_Component_Formulator::config()}
     *
     * @param array $element array of config of element
     *
     * @return Apolo_Component_Formulator
     */ 
    public function addElement(array $element)
    {        
        if (empty($element['type'])) {
            throw new Exception('The Element has no type defined');
        }
        if (!preg_match('@^[a-z_]+$@i', $element['type'])) {
            throw new Exception('Invalid element type');
        }
        $file = $element['type'];
        $file = preg_replace('@_(\w)@e', 'strtoupper("/\\1")', strtolower($file));
        $file = 'Element'
              . DIRECTORY_SEPARATOR
              . ucfirst($file)
              . '.php';
        if (!file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . $file)) {
            throw new Exception('Element file not found: '.$file);
        }
        include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . $file;
        $className = preg_replace(
            '@_(\w)@e', 'strtoupper("_\\1")',
            ucfirst(strtolower($element['type']))
        );
        $className = 'Apolo_Component_Formulator_Element_' . $className;
        if (!class_exists($className)) {
            throw new Exception('Class not defined: ' . $className);
        }
        $reflectionClass = new ReflectionClass($className);
        $this->_elements[] = $reflectionClass->newInstance(
            $element, $this->_values, $this->_form
        );

        return $this;
    }

    /**
     * This method render the form using the template object
     *
     * If the template is not setted it get the default template.
     *
     * The follow areas are acepted:
     *
     * - openForm
     * - elements
     * - closeForm
     * - mediaJS
     * - mediaCSS
     *
     * @param string $area Area to render
     *
     * @return string
     */
    public function render($area = null)
    {
        if ($this->_template == null) {
            include_once
                dirname(__FILE__) . DIRECTORY_SEPARATOR .
                'Template/Default.php';
            $this->_template = new Apolo_Component_Formulator_Template_Default;
        }
        $form = array(
            'openForm'  => $this->_template->renderOpenForm($this),
            'elements'  => $this->_template->render($this->_elements),
            //'csrf'      => $this->_template->renderCsrf($this->_elements),
            'closeForm' => $this->_template->renderCloseForm($this),
            'mediaJS'   => implode('', $this->_template->renderMedia($this, 'js')),
            'mediaCSS'  => implode('', $this->_template->renderMedia($this, 'css')),
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
     * When you print the object it runs 
     * {@link Apolo_Component_Formulator::render() render method} 
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
     * @return void
     */
    public function addMedia($media)
    {
        if (preg_match('@\.js$@i', $media)) {
            if (!in_array($media, $this->_media['js'])) {
                $this->_media['js'][] = $media;
            }
        }
        if (preg_match('@\.css$@i', $media)) {
            if (!in_array($media, $this->_media['css'])) {
                $this->_media['css'][] = $media;
            }
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

}

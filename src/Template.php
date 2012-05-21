<?php
/**
 * Formulator Template
 *
 * This is part of Formulator Component and can't be sold separately.
 *
 * PHP Version 5.2
 *
 * @category  Component
 * @package   Component
 * @author    Michael Granados <michaelgranados@corp.virgula.com.br>
 * @copyright 2011-2012 Virgula S/A
 * @license   Virgula Copyright
 * @link       http://virgula.uol.com.br
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Renderer.php';

/**
 * Formulator Template
 *
 * This abstract class render your form using a basic template of any kind
 * of element used by Formulator Component.
 *
 * @category   Template
 * @package    Formulator
 * @subpackage Core
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
abstract class Apolo_Component_Formulator_Template
{
    const CALL_PATTERN     = '@^\{call\:([a-z0-9_]+)\}@si';
    const FILTER_PATTERN   = '@^\{filter\:([a-z0-9_]+)\}@sie';
    const IS_TOKEN_PATTERN = '@^\{([a-z0-9]+\.?[a-z0-9_-]*)\}$@i';

    const TOKEN_PATTERN  = '@(
            \{filter\:  [a-z0-9_]+\}   |   # filters
            \{call\:    [a-z0-9_]+\}   |   # call methods
            \{[a-z0-9]+\.?[a-z0-9]*\}     # other tag, default way
        )@isx';

    protected $form = null;

    /**
     * List of templates
     *
     * Each key is the name of object used in Formulator. The key needs to
     * be a string in lowercase.
     *
     * @var array $templates
     */
    public $templates = array();

    /**
     * @var array $media Public of stored extenal contents, like CSS or JavaScript
     */
    public $media = array();

    /**
     * Set the form component, used to retrive some data in render
     *
     * @param Apolo_Component_Formulator $form The form
     *
     * @return void
     */
    public function setForm(Apolo_Component_Formulator $form)
    {
        $this->form = $form;
    }

    /**
     * Renders the open form
     *
     * You need to pass the formulator object to render
     *
     * @return string
     */
    public function renderOpenForm()
    {
        $attrs = $this->makeAttributes($this->form->getConfig());
        return "<form{$attrs}>" . PHP_EOL;
    }

    /**
     * Make all atrributes
     *
     * Converts an associative set/array to html element attributes
     *
     * Sample:
     * <pre>
     * // $fTemplate = new Apolo_Component_Formulator_Template
     * $config = array(
     *     'class' => 'simple space',
     *     'name'  => 'person',
     *     'style' => 'background: url("image.png")',
     * );
     * print $fTemplate->makeAttributes($config);
     * // clas="simple space" name="person"
     * // style="background: url(&quot;image.png&quot;)"
     * </pre>
     *
     * @param array $config Configurations
     *
     * @return string
     */
    public function makeAttributes(array $config)
    {
        $attributes = array();
        foreach ($config as $key => $value) {
            if (!is_string($value)) {
                continue;
            }
            $attributes[] = $key . '="'.htmlentities($value, ENT_QUOTES).'"';
        }
        if ($attributes) {
            return ' ' . implode(' ', $attributes);
        }
    }

    /**
     * Renders the close form
     *
     * @return string
     */
    public function renderCloseForm()
    {
        return '</form>';
    }

    /**
     * Renderizes the media objects to use in head tags
     *
     * @param string $area Area to render: js/css
     *
     * @return string
     */
    public function renderMedia($area)
    {
        if (!$this->media) {
            $media  = $this->form->getMedia();
            $_media = array('css' => array(), 'js' => array());
            foreach (array('css', 'js') as $type) {
                $_media[$type] = $this->_createMediaLinks($media[$type], $type);
            }
            $this->media = $_media;
        }
        if (array_key_exists($area, $this->media)) {
            return $this->media[$area];
        }
    }

    /**
     * Create media links to use in rederMedia
     *
     * @param array  $files List of files
     * @param string $type  Type of files: js or css
     *
     * @internal
     * @return array
     */
    private function _createMediaLinks(array $files, $type)
    {
        $types = array(
            'css' => '<link rel="stylesheet" href="/%s/%s" />',
            'js'  => '<script type="text/javascript" src="/%s/%s"></script>',
        );
        $template   = $types[$type];
        $mediaLinks = array();
        foreach ($files as $file) {
            $mediaLinks[] = sprintf($template, $type, $file);
        }
        return $mediaLinks;
    }

    /**
     * render elements
     *
     * Makes a loop over all elements in array set
     *
     * @TODO document and coverage all above methods
     *
     * @return string
     */
    final public function render()
    {
        $elementsIterator = new RecursiveArrayIterator(
            $this->form
        );
        $elementsIterator = $this->form;
        $output = $this->_renderElements($elementsIterator);
        return $output;
    }

    final private function _renderElements($elementSet, $parent = null)
    {
        $output = array();
        foreach ($elementSet as $item) {
            if ($parent) {
                $item->setParent($parent);
            }
            $reflection = new ReflectionClass($item);
            if ($reflection->hasMethod('initRender')) {
                $item->initRender();
            }
            $output[] = $this->_renderElement($item, $item->templateType);
            if ($reflection->hasMethod('endRender')) {
                $item->endRender();
            }
        }
        return implode('', $output);
    }

    final private function _renderElement($item, $templateType)
    {
        $output = array();
        $template = $this->_getTemplate($templateType);
        $tokens   = preg_split(
            self::TOKEN_PATTERN,
            $template, -1, PREG_SPLIT_DELIM_CAPTURE
        );
        $output[] = $this->_parseTokens($tokens, $item);
        return implode('', $output);
    }

    final private function _getTemplate($templateType)
    {
        if (array_key_exists(strtolower($templateType), $this->templates)) {
            $template = $this->templates[strtolower($templateType)];
        } else if (isset($this->templates['default'])) {
            $template = $this->templates['default'];
        } else {
            $template = '{label}: {input}';
        }

        $method = 'template' . ucfirst(strtolower($templateType));
        if (is_callable(array($this, $method))) {
            $template = call_user_func_array(
                array($this, $method),
                array($template, $element)
            );
        }
        return $template;
    }

    final private function _parseTokens($tokens, $item)
    {
        $output = array();
        foreach ($tokens as $token) {
            $firstLastChars = substr($token, 0, 1) . substr($token, -1, 1);
            if ($method = $this->_isCall($token)) {
                $output[] = $this->__run_call($method);
            } elseif ($filter = $this->_isFilter($token)) {
                $output[] = $this->__run_filter($item, $filter);
            } elseif ('{subElements}' === $token) {
                $output[] = $this->_renderElements($item->subElements, $item);
            } elseif ($_token = $this->_isToken($token)) {

                $token=substr($token, 1, -1);
                $token=explode('.', $token);
                if (count($token)==1) {
                    $context='default';
                    $attribute=$token[0];
                } else {
                    list($context, $attribute) = $token;
                }
                $output[]=$item->attribute($context, $attribute, false);
                //$output[] = $item->attrs[$_token];


            } else {
                $output[] = $token;
            }
        }
        return implode('', $output);
    }

    final private function _isFilter($token)
    {
        $replacer = '"filter_" . ucfirst("\1")';
        return preg_filter(self::FILTER_PATTERN, $replacer, $token);
    }

    final private function _isCall($token)
    {
        return preg_filter(self::CALL_PATTERN, '\1', $token);
    }

    final private function _isToken($token)
    {
        return preg_filter(self::IS_TOKEN_PATTERN, '\1', $token);
    }

    final private function __run_call($method)
    {
        $reflectionFunction = new ReflectionFunction($method);
        $numberOfRequiredParams = $reflectionFunction
            ->getNumberOfRequiredParameters();
        if ($numberOfRequiredParams) {
            return '';
        }
        return $reflectionFunction->invoke();
    }

    final private function __run_filter($element, $filter)
    {
        $reflectionClass = new ReflectionClass($element);
        if (!$reflectionClass->hasMethod($filter)) {
            return '';
        }
        $filter = $reflectionClass->getMethod($filter);
        $numberOfRequiredParams = $filter
            ->getNumberOfRequiredParameters();
        if (!$filter->isPublic() || $numberOfRequiredParams) {
        }
        return $filter->invoke($element);
    }
}

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
    /**
     * @var int $counter counter used in some templates
     */
    public $counter   = 0;

    /**
     * List of templates
     *
     * Each key is the name of object used in Formulator. The key needs to
     * be a string in lowercase.
     *
     * @var array $templates
     */
    public $templates = array(
        'hidden'   => '{input}',
        'fieldset' => '
            {fieldsetopen}<legend>{legend}</legend>{elements}{fieldsetclose}
        ',
        'default'  => '{label}: {input}',
    );

    /**
     * @var array $media Public of stored extenal contents, like CSS or JavaScript
     */
    public $media = array();

    /**
     * Renders the open form
     *
     * You need to pass the formulator object to render
     *
     * @param Apolo_Component_Formulator $form the form to use
     *
     * @return string
     */
    public function renderOpenForm(Apolo_Component_Formulator $form)
    {
        return '<form'.$this->makeAttributes($form->getConfig()).'>' . PHP_EOL;
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
     * @param Apolo_Component_Formulator $form Form configuration
     *
     * @return string
     */
    public function renderCloseForm(Apolo_Component_Formulator $form)
    {
        return '</form>';
    }

    /**
     * Renderizes the media objects to use in head tags
     * 
     * @param Apolo_Component_Formulator $form Form configuration
     * @param string                     $area Area to render: js/css
     *
     * @return string
     */
    public function renderMedia(Apolo_Component_Formulator $form, $area)
    {
        if (!$this->media) {
            $media  = $form->getMedia();
            $_media = array('css' => array(), 'js' => array());
            $template = array(
                'css' => '<link rel="stylesheet" href="%s/%s/%s">',
                'js'  => '<script type="text/javascript" src="%s/%s/%s"></script>',
            );
            foreach (array('css', 'js') as $type) {
                foreach ($media[$type] as $item) {
                    $_media[$type][] = sprintf($template[$type], null, $type, $item);
                }
            }
            $this->media = $_media;
        }
        if (array_key_exists($area, $this->media)) {
            return $this->media[$area];
        }
    }

    /**
     * render elements
     *
     * Makes a loop over all elements in array set
     * 
     * @param array $elements set of elements
     *
     * @uses  Apolo_Component_Formulator_Template::renderElement()
     * @return string
     */
    final public function render(array $elements)
    {
        $result = '';
        foreach ($elements as $element) {
            $part = $this->renderElement($element);
            $result .= $part;
        }
        return $result;
    }

    /**
     * Return input hidden csrf
     * by Neto
     * @param type array $elements 
     * @return string
     */
    /*final public function renderCsrf(array $elements) 
    {        
        return $elements[0]->attrs['input'];
    }*/

    /**
     * renderizes an element
     *
     * Tryes to render an element based on his type. If exists an method called
     * 'render{ElementType}' this method is called instead. Othercase uses the
     * renderDefaultElement method.
     *
     * @param Apolo_Component_Formulator_Element $element Formulator Element
     *
     * @uses Apolo_Component_Formulator_Element::renderDefaultElement()
     * @return string
     */
    final public function renderElement(Apolo_Component_Formulator_Element $element)
    {
        $type = $element->getType();
        $method = 'render' . ucfirst(strtolower($type));
        $method = array($this, $method);
        if (is_callable($method)) {
            return call_user_func($method, $element);
        }
        return $this->renderDefaultElement($element);
    }

    /**
     * renders default element 
     * 
     * @param Apolo_Component_Formulator_Element $element Element to render
     *
     * @uses Apolo_Component_Formulator_Template::template()
     * @return string
     */
    public function renderDefaultElement(Apolo_Component_Formulator_Element $element)
    {
        $type = $element->getType();
        if (array_key_exists(strtolower($type), $this->templates)) {
            $template = $this->templates[strtolower($type)] . PHP_EOL;
        } else if (isset($this->templates['default'])) {
            $template = $this->templates['default'] . PHP_EOL;
        } else {
            $template = '{label}: {input}' . PHP_EOL;
        }
        $method = 'template' . ucfirst(strtolower($type));
        if (is_callable(array($this, $method))) {
            $template = call_user_func_array(
                array($this, $method), 
                array($template, $element)
            );
        }
        return $this->template($template, $element);
    }

    /**
     * The render base
     * 
     * @param string                             $template The name of template
     * @param Apolo_Component_Formulator_Element $element  The element to render
     *
     * @return void
     */
    public function template($template, Apolo_Component_Formulator_Element $element)
    {
        if (isset($element->elements)) {
            $elements = $this->render($element->elements->getElements());
            $template = str_replace('{elements}', $elements, $template);
        }
        if (isset($element->subElements)) {
            if ('array' === gettype($element->subElements)) {
                $elements = array();
                foreach ($element->subElements as $subElement) {
                    $elements[] = $this->render($subElement->getElements());
                }
                $elements = implode('', $elements);
            } else {
                $elements = $this->render($element->subElements->getElements());
            }
            $template = str_replace('{subElements}', $elements, $template);
        } else {
            $template = str_replace('{subElements}', '', $template);
        }
        $template = str_replace('{counter}', $this->counter(), $template);
        $template = str_replace('{uniqid}', uniqid(), $template);
        preg_match_all('@{\w+}@', $template, $matches);
        $validStringElements = array(
            '{elements}', '{uniqid}', '{counter}', '{validation}'
        );
        foreach ($matches[0] as $item) {
            if (in_array($item, $validStringElements)) {
                continue;
            }
            $method = substr($item, 1, -1);
            $method = 'get' . ucfirst(strtolower($method));
            $template = str_replace($item, $element->$method(), $template);
        }
        return $template;
    }

    /**
     * counter
     *
     * Returns odd or even over the counter object
     *
     * @return string
     */
    public function counter()
    {
        return $this->counter++ % 2 ? 'odd' : 'even';
    }
}

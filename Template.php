<?php

abstract class Apolo_Component_Formulator_Template
{
    public $counter   = 0;
    public $templates = array(
        'hidden'   => '{input}',
        'fieldset' => "{fieldsetopen}\n<legend>{legend}</legend>\n{elements}{fieldsetclose}",
        'default'  => '{label}: {input}',
    );
    public $media = array();

    public function renderOpenForm(Apolo_Component_Formulator $form)
    {
        return '<form'.$this->makeAttributes($form->getConfig()).'>' . PHP_EOL;
    }

    public function makeAttributes(array $config)
    {
        $attributes = array();
        foreach($config as $key => $value) {
            if (!is_string($value)) {
                continue;
            }
            $attributes[] = $key . '="'.htmlentities($value, ENT_QUOTES).'"';
        }
        if ($attributes) {
            return ' ' . implode(' ', $attributes);
        }
    }


    public function renderCloseForm(Apolo_Component_Formulator $form)
    {
        return '</form>';
    }

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
                foreach($media[$type] as $item) {
                    $_media[$type][] = sprintf($template[$type], null, $type, $item);
                }
            }
            $this->media = $_media;
        }
        if (array_key_exists($area, $this->media)) {
            return $this->media[$area];
        }
    }

    final public function render(array $elements)
    {
        $result = '';
        foreach($elements as $element) {
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

    public function template($template, Apolo_Component_Formulator_Element $element)
    {
        if (isset($element->elements)) {
            $elements = $this->render($element->elements->getElements());
            $template = str_replace('{elements}', $elements, $template);
        }
        if (isset($element->subElements)) {
            if ('array' === gettype($element->subElements)) {
                $elements = array();
                foreach($element->subElements as $subElement) {
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
        foreach ($matches[0] as $item) {
            if (in_array($item, array('{elements}', '{uniqid}', '{counter}', '{validation}'))) {
                continue;
            }
            $method = substr($item, 1, -1);
            $method = 'get' . ucfirst(strtolower($method));
            $template = str_replace($item, $element->$method(), $template);
        }
        return $template;
    }

    public function counter()
    {
        return $this->counter++ % 2 ? 'odd' : 'event';
    }
}

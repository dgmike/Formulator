<?php

// @codeCoverageIgnoreStart

/**
 * Defining default timezone if not setted in php.ini
 */
if (!ini_get('date.timezone')) {
    date_default_timezone_set('America/Sao_Paulo');
}

set_include_path(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src'
                 . PATH_SEPARATOR . get_include_path());

require_once 'Formulator.php';

class Apolo_Component_Formulator_Template_Mocktemplate
{
    public $_form = null;

    public function setForm($form)
    {
        $this->_form = $form;
    }

    public function render()
    {
        return 'test';
    }

    public function renderMedia()
    {
        return array();
    }

    public function renderOpenForm()
    {
        return '<form>';
    }

    public function renderCloseForm()
    {
        return '</form>';
    }
}

// @codeCoverageIgnoreEnd

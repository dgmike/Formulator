<?php

class Apolo_Component_Formulator_Template_Default
    extends Apolo_Component_Formulator_Template
{
    public $templates = array(
        'html'  => '{content}',
        'input' => '<label><span>{label.name}</span> <input{input.attrs!} /></label>'
    );
}

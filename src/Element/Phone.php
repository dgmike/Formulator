<?php

class Apolo_Component_Formulator_Element_Phone
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    public $aceeptSubelements = false;
    public $templateType = 'subElements';
    public $validAttributes = array();

    public function setElement(array $element)
    {
    $id = uniqid(true);
        $mustache = $this->mustache('telefone_' . $id);
        $button = array(
            'type'    => 'button',
            '_type'   => 'button',
            'onclick' => 'var r=Math.floor(Math.random()*10000);'
                      .  '$("#telefone_'.$id.'")'
                      .  '.mustache({id:r})'
                      .  '.appendTo("#telefones_'.$id.'");'
		      .  'if ($("#telefones_'.$id.' fieldset :radio").size() == 1)'
		      .  '$("#telefones_'.$id.' fieldset :radio").click();'
                      .  'return false;',
            'label'   => 'Adicionar',
        );
        $subElements = array($mustache, $button);
        $this->setSubElements(
            array(
                array(
                    'type'        => 'fieldset',
                    'legend'      => 'Telefones',
                    'id'          => 'telefones_' . $id,
                    'subElements' => $subElements,
                ),
            )
        );
    }

    public function mustache($id) {
        $ids = array(
            'type' => 'input_hidden',
            'name' => 'phone_ids[]',
            'value' => '{{id}}',
        );
	$default = array(
	    'type' => 'input_radio',
	    'name' => 'phone_default[]',
	    'value' => '{{id}}',
	    'label' => 'Telefone Principal',
	    'title' => 'Define este telefone como o principal',
	);
	$tipo = array(
	    'type' => 'select',
	    'name' => 'phone_{{id}}[type]',
	    'values' => array(
	    	'residencial' => 'Residencial',
		'comercial' => 'Comercial',
		'celular' => 'Celular',
		'fax' => 'Fax',
		'outro' => 'Outro',
	    ),
	);
        $number = array(
            'type' => 'input_tel',
            'label' => 'Número',
	    'pattern' => '(\+?[0-9]{2,3}[ \.-]?)?([0-9]{1,4}[ \.-]?)?([0-9]{3,5})[ \.-]?([0-9]{3,5})',
	    'placeholder' => '+55 11 90000 0000',
            'name' => 'phone_{{id}}[number]',
        );
        $button = array(
            'type'    => 'button',
            '_type'   => 'button',
            'onclick' => '$(this).parents("fieldset").first().remove();'
                      .  'return false;',
            'label'   => 'Remover',
        );
	$fieldset = array(
			    'type' => 'fieldset',
			    'legend'=>'',
			    'subElements'=>array(
			            $ids, $default, $tipo, $number, $button
		            )
		    );
        $mustache = array(
            'type' => 'mustache',
            'id' => $id,
            'subElements' => array(
		    $fieldset
	    ),
        );
        return $mustache;
    }
}

/* vim:set et:set tabstop=4:set softtabstop=4:set autoindent: */

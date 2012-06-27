<?php

class Apolo_Component_Formulator_Template_Default
    extends Apolo_Component_Formulator_Template
{
    public $templates = array(
        'html'     => '{content!}',
        'choice'   => '<label><input{input.attrs!} /><span>{label.name}</span></label>',
        'input'    => '<label><span>{label.name}</span> <input{input.attrs!} /></label>',
        'input_hidden' => '<input{input.attrs!} />',
        'textarea' => '<label{@label}><span>{label}</span><textarea{@textarea}>{call:getValue}</textarea></label>',
        'fieldset' => '<fieldset{@fieldset}>{legend.tag!}{subElements}</fieldset>',
        'subelements' => '{subElements}',
        'select'   => '<label><span>{label.name}</span> <select name="{name}"{@select}>{subElements}</select></label>',
        'select_option' => '<option value="{value}"{@option}>{label}</option>',
        'button'   => '<button type="{type}"{@button}>{label!}{subElements}</button>',
        'mustache' => "\n<script type=\"text/mustache-template\"{@default}>{subElements}</script>\n",
        'script'   => "\n<script{@default}>{subElements}</script>\n",
        'wooper'   => '{before!}{subElements}{after!}',
    );

    public function decorator($output)
    {
        $special_tags = array('textarea', 'pre', 'code', 'script');
        $special_tags_regexp = implode('|', $special_tags);

        $output = preg_split('@(<(?<tag>'.$special_tags_regexp.')[^>]*[^\/]?>.*<\/\\2>)@Us', $output, -1, PREG_SPLIT_DELIM_CAPTURE);
        //header('content-type: text/plain');
        //print_r($output);
        //die;

        $new_output = array();
        $special_vars = array();
        while (list($k, $item) = each($output)) {
            if (!empty($output[$k+1]) && in_array(trim($output[$k+1]), $special_tags)) {
                $id = '[#' . sha1(uniqid() . uniqid() . uniqid()) . '#]';
                $special_vars[$id] = $item;
                array_push($new_output, $id);
                next($output);
                continue;
            }
            array_push($new_output, $item);
        }
        $output = implode('', $new_output);

        //header('content-type: text/plain');
        //print_r($output);
        //die;

        $output = trim(preg_replace('@[[:space:]]+@', ' ', $output));
        $output = str_replace('>', '>' . PHP_EOL, $output);
        $output = str_replace('<', PHP_EOL . '<', $output);
        $tokens = explode(PHP_EOL, $output);
        $spaces = 0;
        $output = '';
        foreach ($tokens as $item) {
            if (substr($item, 0, 2) == '</') {
                $spaces--;
            }
            $item = trim($item);
            if (!$item) {
                continue;
            }
            if ($spaces > 0) {
                $output .= str_repeat(' ', (4 * $spaces));
            }
            $output .= $item . PHP_EOL;
            if ('<' == substr($item, 0, 1) && '/>' != substr($item, -2) && substr($item, 0, 2) != '</') {
                $spaces++;
            }
        }
        foreach ($special_vars as $k=>$v) {
            $output = str_replace($k, $v, $output);
        }

        //header('content-type: text/plain');
        //print_r($output);
        //die;

        return trim($output);
    }
}

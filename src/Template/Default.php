<?php

class Apolo_Component_Formulator_Template_Default
    extends Apolo_Component_Formulator_Template
{
    public $templates = array(
        'html'     => '{content!}',
        'choice'   => '<label><input{input.attrs!} /><span>{label.name}</span></label>',
        'input'    => '<label><span>{label.name}</span> <input{input.attrs!} /></label>',
        'textarea' => '<label{@label}><span>{label}</span><textarea{@textarea}>{call:getValue}</textarea></label>',
        'fieldset' => '<fieldset{@fieldset}>{legend.tag!}{subElements}</fieldset>',
        'subelements' => '{subElements}',
        'select_option' => '<option value="{value}"{@option}>{label}</option>',
    );

    public function decorator($output)
    {
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
        return trim($output);
    }
}

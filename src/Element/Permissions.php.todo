<?php
/**
 * Formulator Component Radio Element
 *
 * Use this element to create the input type radio.
 *
 * PHP Version 5.2
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Element
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */

/**
 * This Class create the <samp>input</samp> type <samp>radio</samp> on the form.
 *
 * @category   Component
 * @package    Formulator
 * @subpackage Element
 * @author     Michael Granados <michaelgranados@corp.virgula.com.br>
 * @author     Michell Campos <michell@corp.virgula.com.br>
 * @copyright  2011-2012 Virgula S/A
 * @license    Virgula Copyright
 * @link       http://virgula.uol.com.br
 */
class Apolo_Component_Formulator_Element_Permissions
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    /**
     * This method create the <samp>input</samp> type <samp>radio</samp> 
     * on the form.
     * 
     * @return void
     */
    public function setElement(array $element)
    {
        $model = Apolo::model('usergroup');
        $adm_permission = $model->getPermissions();
        $this->attrs['input'] = '';
        $values = array();
        if (isset($_SESSION['temp_post'])) {
            foreach ($_SESSION['temp_post'] as $k => $v) {
                if (strpos($k, '.')) {
                    $arr = explode('.', $k, 2);
                    if ($arr[0] == 'permissions') {
                        $values[] = $v['$id']->__toString();
                    }
                }
            }
        }
        
        foreach ($adm_permission as $permission) {
            $flag = false;
            foreach($values as $value) {                
                if ($permission['_id']->__toString() == $value) {
                    $this->attrs['input'] .= '<p><input type="checkbox" name="permissions[]" checked="checked" 
                                        value="'.$permission['_id']->__toString().'"> '.$permission['value'].'</p>';
                    $flag = true;
                }
            }

            if (!$flag) {
                $this->attrs['input'] .= '<p><input type="checkbox" name="permissions[]" 
                                            value="'.$permission['_id']->__toString().'"> '.$permission['value'].'</p>';
            } 
        }
    }
}


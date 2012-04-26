<?php

class Apolo_Component_Formulator_Element_Table
    extends Apolo_Component_Formulator_Element
    implements Apolo_Component_Formulator_ElementInterface
{
    private $_parts = array('thead', 'tfoot', 'tbody');

    public function setElement()
    {
        // header('Content-type: text/plain');
        $this->_createBasicObjects();
        $this->_appendBodyElements();
        $this->_setRows();
        $this->_clearInvalidElements();
        $this->_selElement();
    }

    private function _selElement()
    {
        $this->attrs['open_table'] = '<table' . $this->makeAttributes() . '>';
        $this->attrs['close_table'] = '</table>';
        $this->element['elements'] = $this->attrs['elements'];
    }

    private function _createBasicObjects() 
    {
        foreach ($this->_parts as $item) {
            if (empty($this->element[$item])) {
                $this->attrs[$item] = array();
            } else {
                $this->attrs[$item] = $this->element[$item];
            }
        }
    }

    private function _appendBodyElements()
    {
        if (isset($this->element['rows'])) {
            $this->element['elements'] = $this->element['rows'];
            unset($this->element['rows']);
        }
        if (!empty($this->element['elements'])) {
            foreach ($this->element['elements'] as $item) {
                $this->attrs['tbody'][] = $item;
            }
            unset($this->element['elements']);
        }
    }

    private function _clearInvalidElements()
    {
        $elements = array();
        foreach ($this->_parts as $item) {
            unset($this->element[$item]);
            if (empty($this->attrs[$item])) {
                continue;
            }
            $elements[] = array(
                'type' => 'Table_' . ucfirst($item),
                'elements' => $this->attrs[$item]
            );
        }
        $this->attrs['elements'] = $elements;
    }

    private function _setRows()
    {
        foreach ($this->_parts as $part) {
            if (empty($this->attrs[$part])) {
                continue;
            }
            foreach ($this->attrs[$part] as &$row) {
                if (!isset($row['type'])) {
                    $row['type'] = 'Table_Row';
                }
                if (isset($row['row'])) {
                    $row['elements'] = $row['row'];
                    unset($row['row']);
                }
                if (isset($row['elements'])) {
                    foreach($row['elements'] as &$column) {
                        if (!isset($column['type'])) {
                            $column['type'] = $part == 'thead'
                                            ? 'Table_Heading' 
                                            : 'Table_Column';
                        }
                        if (isset($column['column'])) {
                            $column['elements'] = $column['column'];
                            unset($column['column']);
                        }
                        krsort($column);
                    }
                }
                krsort($row);
            }
        }
    }
}

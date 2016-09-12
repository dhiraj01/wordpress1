<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserForm
 *
 * @author hawk
 */
class View_UserForm extends View_SideBySide{
    
    public function render()
    {
        $this->_form->appendAttribute("class", $this->class);
       
        echo '<form', $this->_form->getAttributes(), '><fieldset>';
        $this->_form->getErrorView()->render();
        echo '<input type="hidden" name="rm_form_sub_id" value='.$this->_form->getAttribute('id').'>';
        echo '<input type="hidden" name="rm_form_sub_no" value='.$this->_form->getAttribute('number').'>';
        $elements = $this->_form->getElements();
        $elementSize = sizeof($elements);
        $elementCount = 0;
        for ($e = 0; $e < $elementSize; ++$e)
        {
            $element = $elements[$e];

            if ($element instanceof Element_Hidden || $element instanceof Element_HTML)
                $element->render();
            elseif ($element instanceof Element_Button || $element instanceof Element_HTMLL)
            {
                if ($e == 0 || (!$elements[($e - 1)] instanceof Element_Button && !$elements[($e - 1)] instanceof Element_HTMLL))
                    echo '<div class="buttonarea">';
                else
                    echo ' ';

                $element->render();

                if (($e + 1) == $elementSize || (!$elements[($e + 1)] instanceof Element_Button && !$elements[($e + 1)] instanceof Element_HTMLL))
                    echo '</div>';
            }elseif ($element instanceof Element_HTMLH || $element instanceof Element_HTMLP)
            {               
                echo '<div class="rmrow">', $element->render(), '', $this->renderDescriptions($element), '</div>';
                ++$elementCount;
            }elseif($element instanceof Element_Map )
            {
                $ele_id = $element->getAttribute('id');
                $unique_ele_id = $ele_id."_".$this->_form->getAttribute('id')."_".$this->_form->getAttribute('id');
                $element->setAttribute('id',$unique_ele_id);
                echo '<div class="rmrow">', $this->renderLabel($element), '<div class="rminput">', $element->render(), '</div>', $this->renderDescriptions($element), '</div>';
                ++$elementCount;
            }else
            {
                echo '<div class="rmrow">', $this->renderLabel($element), '<div class="rminput">', $element->render(), '</div>', $this->renderDescriptions($element), '</div>';
                ++$elementCount;
            }
        }

        echo '</fieldset></form>';
    }
    
    protected function renderLabel(Element $element)
    {
      
        $label = $element->getLabel();
        
        if (!empty($label))
        {
            //echo '<label class="control-label" for="', $element->getAttribute("id"), '">';
            echo '<div class="rmfield" for="', $element->getAttribute("id"), '" style="',$element->getAttribute("labelstyle"),'"><label>';
            if ($element->isRequired())
            {
            echo '<sup class="required">* </sup>';
            }
            echo $label, '</label></div>';
        }
    }
    
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class TextArea extends codexForms
{
    var $_params = array();
    function TextArea($name,$params) { 
        $params['attributes']['cols'] = (isset($params['attributes']['cols']))? $params['attributes']['cols'] : 40 ;
        $params['attributes']['rows'] = (isset($params['attributes']['rows']))? $params['attributes']['rows'] : 10 ;
        codexForms::initiate($name,$params);
        $this->_params = $params;
    }

    function prepForDB($value){
        if(isset($this->_params['params']['serialize']))
            return serialize($value);
        return $value;//(nl2br($value));
    }

    function prepForDisplay($value){
        return (stripslashes(strip_tags($value,'<br /><br>')));
    }

	function getHTML()
	{
        $html = "";
		$html .= $this->prefix;
        
        if(isset($this->_params['params']['serialize'])){
            $this->value = unserialize($this->value);
            $temp = '';
            if(is_array($this->value))
                foreach($this->value as $key=>$val){
                    $temp .= $key.': '.$val.'<br />'."\n";
                }
            $this->value = $temp;
            unset($temp);
        }
        if($this->getMessage($this->name))
            $html .= '<div class="failure">'.$this->getMessage($this->name).'</div>';

        /*$html .= '
            <label for="'.$this->element_name.'">
                '.$this->label.'
            </label>
            <textarea id="'.$this->name.'" name="'.$this->element_name.'" '.$this->getAttributes($this->attributes).'>'.$this->br2nl(stripslashes(strip_tags($this->value))).'</textarea>
        ';*/
        if(isset($this->_params['params']['serialize'])){
            $html .= '
            <table border=0>
                <tr>
                    <td> 
                        <label for="'.$this->element_name.'"  class="control-label">
                            '.$this->label.'
                        </label>
                    </td>
                    <td>'.$this->value.'</td>
                </tr>
            </table>';
        }else{
           $html .= '
            <label for="'.$this->element_name.'" class="control-label">
                '.$this->label.'
            </label><div class="controls">
            <textarea id="'.$this->name.'" name="'.$this->element_name.'" '.$this->getAttributes($this->attributes).'>'.$this->value.'</textarea></div>';
        }
		$html .= $this->suffix;
		
		return $html;
	}
    function br2nl($text)
    {
        return  preg_replace('/<br\\\\s*?\\/??>/i', "\\n", $text);
    }
}
?>

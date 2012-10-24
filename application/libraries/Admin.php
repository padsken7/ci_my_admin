<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Admin {

    public function __construct($tables)
    {
        $this->tables = $tables;
		$CI =& get_instance();
		$CI->load->helper('inflector');
    }

    public function create_add_links($table_name='')
    {
		$CI =& get_instance();
		$result = '<ul class="nav nav-tabs nav-stacked">';
		foreach ($this->tables as $table => $val) {
			$mode = $CI->uri->segment(3);
			$result .= ($table == $table_name && $mode=='add') ? '<li class="active">' : '<li>';
			$result .= '<a href="/admin/panel/add/' . $table .'">' . $val['add'] . '</a></li>' . "\n";
		}
		$result = $result . '</ul>';
		echo $result;
    }
	
	public function create_show_links($table_name='')
    {
		
		$result =	'<ul class="nav">';
		foreach ($this->tables as $table => $val) {
			$result .=  ($table == $table_name) ? '<li class="active">' : '<li>';
			$result .= '<a href="/admin/panel/show/' . $table .'">' . $val['show']. '</a></li>' . "\n";
		}	
		$result .= '</ul>';		
		echo $result;
    }
	
	public function return_input_for_add($field, $content='', $comment=''){
		switch($field->type) {
			case 'varchar':
				$result = '';
				$result .=  '<div class="control-group">'. "\n";
				$result .=  '<label class="control-label" for="'. $field->name .'">'. $this->translate_to_rus($field->name) .'</label>'. "\n";
				$result .=  '<div class="controls"><input type="text" id="'. $field->name .'" name="'. $field->name .'" value="'.$content.'"/>'. "\n";				
				if($comment!='') $result .=	'<span class="help-block">'. $comment. '</span>'. "\n";
				$result .=  '</div></div>';
				return $result;
				break;
				
			case 'int':
				$result = '';
				$result .=  '<div class="control-group">'. "\n";
				$result .=  '<label class="control-label" for="'. $field->name .'">'. $this->translate_to_rus($field->name) .'</label>'. "\n";
				$result .=  '<div class="controls"><input type="text" id="'. $field->name .'" name="'. $field->name .'" value="'.$content.'"/>'. "\n";				
				if($comment!='') $result .=	'<span class="help-block">'. $comment. '</span>'. "\n";
				$result .=  '</div></div>';
				return $result;
				break;
				
			case 'text':
				$result = '';
				$result .=  '<div class="control-group">'. "\n";
				$result .=  '<label class="control-label" for="'. $field->name .'">'. $this->translate_to_rus($field->name) .'</label>'. "\n";
				$result .=  '<div class="controls"><textarea class="textarea" style="width: 700px;" id="'. $field->name .'" name="'. $field->name .'" value="" rows="5">'.$content.'</textarea>'. "\n";				
				if($comment!='') $result .=	'<span class="help-block">'. $comment. '</span>'. "\n";
				$result .=  '</div></div>';
				return $result;
				break;
				
			default:
				return '';
				break;
		}
	}
	
	public function return_select_for_has_one($field, $has_one, $fields_names, $comment='', $current='')
	{
		$table = plural($has_one);
		$CI =& get_instance();
		$query_result = $CI->Super_model->get_all($table);
		
		$result =  '<div class="control-group">'. "\n";
		$result .=  '<label class="control-label" for="'. $field->name .'">'. $this->translate_to_rus($field->name) .'</label>'. "\n";
		$result .=  '<div class="controls">';
		$result .= '<select name="'.$field->name.'">';
		if($comment!='') $result .=	'<span class="help-block">'. $comment. '</span>'. "\n";
		$result .=  '</div></div>';
		foreach($query_result as $item) {
			$current == $item->id ? $selected = 'selected' : $selected = '';
			$result .= '<option '.$selected.' value="'.$item->id.'">';
			$i=0;
			foreach($fields_names as $field_name) {
				$i>0 ? $result .= " | " : "";
				$result .= $item->$field_name;
				$i++;
			}
			$result .= '</option>';
		}
		$result .= '</select>';
		$result .=  '</div></div>';
		
		return $result;
		
	}
	
	public function translate_to_rus($string) 
	{
		$words = array('text'=>'текст', 'img'=>'изображение', 'title'=>'заголовок', 'textcut'=>'краткое содержание',
		'date'=>'дата', 'name'=>'наименование', 'cat'=>'категория', 'category'=>'категория', 'sub_cat'=>'подкатегория', 'cid' => 'id категории'
		);
		foreach ($words as $word => $translation) {
			if($string == $word) return $translation;
		}
		return $string;
	}
}

/* End of file Admin.php */
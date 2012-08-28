<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| ADMIN CONFIG
| -------------------------------------------------------------------------
*/
		$tables = array();
		$comments = array();
		$validation = array();
		$relations = array();
		
/*
| -------------------------------------------------------------------------
| Config examples
| -------------------------------------------------------------------------
|
|		// таблицы с которыми будем работать
|		$tables['sub_cats']['add'] = 'Добавить подкатегорию';
|		$tables['sub_cats']['show'] ='Подкатегории';
|		$tables['sub_cats']['edit'] ='Редактировать подкатегорию';
|
|		// поясняющие комментарии к полям
|		$comments['products']['img'] ='пример: /uploads/1.jpg';
|		$comments['products']['cat'] = 'число 1 (для легкового транспорта), 2 (для коммерческого транспорта) или 3 (для оборудования и спецтехники)';
|
|		// валидация
|		$validation['products']['title'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
|
|		// связи между базами данных продукт принадлежит к одной из подкатегорий, т.е. таблица products имеет поле sub_cat
|		$relations['products']['has_one'] = 'sub_cat';
|		
|		// nicedit
|		$config['is_nicedit'] = true;
|		// массив id полей, для которых применяем текстовый редактор
|		$config['nicedit_for'] = array('text');
|
*/	
	
		// таблицы с которыми будем работать
		$tables['sub_cats']['add'] = 'Добавить подкатегорию';
		$tables['sub_cats']['show'] ='Подкатегории';
		$tables['sub_cats']['edit'] ='Редактировать подкатегорию';
		
		$tables['products']['add'] = 'Добавить продукт';
		$tables['products']['show'] ='Продукты';
		$tables['products']['edit'] ='Редактировать продукт';

		// поясняющие комментарии к полям
		$comments['products']['img'] ='пример: /uploads/1.jpg';
		$comments['products']['cat'] = 'число 1 (для легкового транспорта), 2 (для коммерческого транспорта) или 3 (для оборудования и спецтехники)';
		$comments['sub_cats']['name'] = 'на латинице (отображается в адресной строке) напр.: motoroils';
		$comments['sub_cats']['cid'] = 'число 1 (для легкового транспорта), 2 (для коммерческого транспорта) или 3 (для оборудования и спецтехники)';


/*

Rule				Parameter		Description

required	        No	    		Returns FALSE if the form element is empty.
matches	            Yes	    		Returns FALSE if the form element does not match the one in the parameter.	matches[form_item]
is_unique	        Yes	    		Returns FALSE if the form element is not unique to the table and field name in the parameter.	is_unique[table.field]
min_length	        Yes	    		Returns FALSE if the form element is shorter then the parameter value.	min_length[6]
max_length	        Yes	    		Returns FALSE if the form element is longer then the parameter value.	max_length[12]
exact_length	    Yes	    		Returns FALSE if the form element is not exactly the parameter value.	exact_length[8]
greater_than	    Yes	    		Returns FALSE if the form element is less than the parameter value or not numeric.	greater_than[8]
less_than	        Yes	    		Returns FALSE if the form element is greater than the parameter value or not numeric.	less_than[8]
alpha	            No	    		Returns FALSE if the form element contains anything other than alphabetical characters.	 
alpha_numeric	    No	    		Returns FALSE if the form element contains anything other than alpha-numeric characters.	 
alpha_dash	        No	    		Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.	 
numeric	            No	    		Returns FALSE if the form element contains anything other than numeric characters.	 
integer	            No	    		Returns FALSE if the form element contains anything other than an integer.	 
decimal	            Yes	    		Returns FALSE if the form element is not exactly the parameter value.	 
is_natural	        No	    		Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc.	 
is_natural_no_zero	No	    		Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.	 
valid_email	        No	    		Returns FALSE if the form element does not contain a valid email address.	 
valid_emails	    No	    		Returns FALSE if any value provided in a comma separated list is not a valid email.	 
valid_ip	        No	    		Returns FALSE if the supplied IP is not valid. Accepts an optional parameter of "IPv4" or "IPv6" to specify an IP format.	 
valid_base64	    No	    		Returns FALSE if the supplied string contains anything other than valid Base64 characters.

xss_clean	    	No	            Runs the data through the XSS filtering function, described in the Input Class page.
prep_for_form	    No	            Converts special characters so that HTML data can be shown in a form field without breaking it.
prep_url	        No	            Adds "http://" to URLs if missing.
strip_image_tags	No	            Strips the HTML from image tags leaving the raw URL.
encode_php_tags	    No	            Converts PHP tags to entities.

*/
		
		// валидация
		$validation['products']['title'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
		$validation['products']['text'] = 'required|xss_clean';
		$validation['products']['textcut'] = 'xss_clean';
		$validation['products']['cat'] = 'required|integer';
		$validation['products']['sub_cat'] = 'required|integer';
		
		$validation['sub_cats']['cid'] = 'required|integer';
		$validation['sub_cats']['title'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
		$validation['sub_cats']['name'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
		
		// связи между базами данных
		$relations['products']['has_one'] = 'sub_cat';
		
		// nicedit
		$config['is_nicedit'] = true;
		$config['nicedit_for'] = array('text');
		

/*
| -------------------------------------------------------------------------
| CONFIG LOADING
| -------------------------------------------------------------------------
*/		
		
		// загрузка опций
		$config['tables'] = $tables;
		$config['comments'] = $comments;
		$config['validation'] = $validation;
		$config['relations'] = $relations;
		
		

		
/* End of file admin.php */
/* Location: ./application/config/admin.php */
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

		// валидация
		$validation['products']['title'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
		$validation['products']['text'] = 'required|xss_clean';
		$validation['products']['textcut'] = 'xss_clean';
		$validation['products']['cat'] = 'required|integer';
		$validation['products']['sub_cat'] = 'required|integer';
		
		$validation['sub_cats']['cid'] = 'required|integer';
		$validation['sub_cats']['title'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
		$validation['sub_cats']['name'] = 'required|min_length[3]|xss_clean|htmlspecialchars';
		
		// связи между таблицами
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
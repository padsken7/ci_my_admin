<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->helper(array('url', 'form', 'htmlpurifier', 'path', 'super'));
		$this->load->model('Super_model');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->lang->load('form_validation', 'rus');
		
		$this->config->load('admin', true);
		
		// таблицы с которыми будем работать		
		$this->tables = $this->config->item('tables', 'admin');

		// поясняющие комментарии к полям
		$this->comments = $this->config->item('comments', 'admin');
		
		// валидация
		$this->validation= $this->config->item('validation', 'admin');
		
		// связи между базами данных
		$this->relations= $this->config->item('relations', 'admin');
		
		// nicedit
		$this->data['is_nicedit'] = $this->config->item('is_nicedit', 'admin');
		$this->data['nicedit_for'] = $this->config->item('nicedit_for', 'admin');
		
	
		
		if(isset($this->tables)) {
			$this->load->library('admin', $this->tables);
		} else {
			show_404();
		}

		
    }

	public function index()
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		$this->data['table_name'] = '';
		$this->load->view('admin/admin_index_view', $this->data);
	}
	
	public function login() 
	{
		$params['login'] = $this->input->post('login', TRUE);
		$params['password'] = md5($this->input->post('password'));
		
		if($this->Super_model->get_one('users', $params)) {
		
			$this->session->set_userdata('is_admin', TRUE);
			$this->data['is_admin'] = $this->session->userdata('is_admin');
			$this->data['table_name'] = '';
			$this->data['success'] = 'Авторизация прошла успешно!';
			$this->load->view('admin/admin_index_view', $this->data);
			
		} else {
		
			$this->data['error'] = 'Ошибка авторизации. Логин или пароль неверны.';
			$this->data['is_admin'] = $this->session->userdata('is_admin');
			$this->data['table_name'] = '';
			$this->load->view('admin/admin_index_view', $this->data);
			
		}
	}
	
	public function add()
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		if($table_name = $this->uri->segment(4) and isset($this->tables[$table_name])) {
		
			if($fields = $this->Super_model->get_field_data($table_name)) {
				$result = '';
				foreach ($fields as $field) {
					
					$relation = isset($this->relations[$table_name]);
					
					if($relation) {
					
						if(!$field->primary_key && $this->relations[$table_name]['has_one']!=$field->name) {
						
							$result = $this->_do_validate_and_return_input($field, $table_name, $result);
							
						} elseif(!$field->primary_key) {
						
							$result .= $this->admin->return_select_for_has_one($field, $this->relations[$table_name]['has_one'], array('cid', 'title'));
						
						}
					
					} else {
					
						if(!$field->primary_key) {
						
							$result = $this->_do_validate_and_return_input($field, $table_name, $result);
							
						}	
					
					}
					
					if(!$field->primary_key && $this->input->post($field->name)) {
					
						$this->data_to_insert[$field->name] = $this->input->post($field->name, true);
						
					}
				}
				
				$result .= '<input type="hidden" value="foobar" name="foobar "/>';
				
				$this->data['table_name'] = $table_name;
				$this->data['fields'] = $result;
				$this->load->view('admin/admin_add_view', $this->data);				
			}
			
		} else {
			$this->data['error'] = 'Неправильный запрос';
			$this->load->view('admin/admin_index_view', $this->data);
		}
	}
	
	
	public function edit()
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		$id = $this->uri->segment(5);
		$this->data['id'] = $id;

		if($table_name = $this->uri->segment(4) and $id and $row = $this->Super_model->get_one($table_name, array('id'=>$id))) {
		
			if($fields = $this->Super_model->get_field_data($table_name)) {
				$result = '';
				foreach ($fields as $field) {
					
					$relation = isset($this->relations[$table_name]);
					
					if($relation) {
					
						if(!$field->primary_key && $this->relations[$table_name]['has_one']!=$field->name) {
						
							$result = $this->_do_validate_and_return_input_for_edit($field, $table_name, $result, $row);
							
						} elseif(!$field->primary_key) {
						
							$has_one = $this->relations[$table_name]['has_one'];
							$result .= $this->admin->return_select_for_has_one($field, $this->relations[$table_name]['has_one'], array('cid', 'title'),'',$row->$has_one);
						
						}
					
					} else {
					
						if(!$field->primary_key) {
						
							$result = $this->_do_validate_and_return_input_for_edit($field, $table_name, $result, $row);
							
						}	
					
					}
					
					if(!$field->primary_key && $this->input->post($field->name)) {
					
						$this->data_to_insert[$field->name] = $this->input->post($field->name, true);
						
					}
				}
				
				$result .= '<input type="hidden" value="foobar" name="foobar "/>';
				
				$this->data['table_name'] = $table_name;
				$this->data['fields'] = $result;
				$this->load->view('admin/admin_edit_view', $this->data);		
			}
			
		} else {
			$this->data['error'] = 'Неправильный запрос';
			$this->data['table_name'] = '';
			$this->load->view('admin/admin_index_view', $this->data);
		}
	}
	
	public function create()
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		if($table_name = $this->uri->segment(4)) {
			
			$this->data['table_name'] = $table_name;
			if($fields = $this->Super_model->get_field_data($table_name)) {
				$result = '';
				foreach ($fields as $field) {
					
					$relation = isset($this->relations[$table_name]);
					
					if($relation) {
					
						if(!$field->primary_key && $this->relations[$table_name]['has_one']!=$field->name) {
						
							$result = $this->_do_validate_and_return_input($field, $table_name, $result);
							
						} elseif(!$field->primary_key) {
						
							$result .= $this->admin->return_select_for_has_one($field, $this->relations[$table_name]['has_one'], array('cid', 'title'));
						
						}
					
					} else {
					
						if(!$field->primary_key) {
						
							$result = $this->_do_validate_and_return_input($field, $table_name, $result);
							
						}	
					
					}
					
					if(!$field->primary_key && $this->input->post($field->name)) {
					
						$this->data_to_insert[$field->name] = $this->input->post($field->name, true);
						
					}
				}
				
				$result .= '<input type="hidden" value="foobar" name="foobar "/>';
				$this->form_validation->set_rules('foobar', '', 'exact_length[6]');
				
				$this->data['fields'] = $result;
				
				if($this->form_validation->run() and isset($this->data_to_insert)) {
					$this->db->insert($table_name, $this->data_to_insert);
					$this->data['success'] = 'Материал успешно добавлен!';
					$this->load->view('admin/admin_index_view', $this->data);
				} else {
					$this->data['error'] = '<b>Ошибка при заполнении формы:</b> ';
					if(!isset($this->data_to_insert)) $this->data['error'] .= '<br/> Все поля пусты!';
					$this->load->view('admin/admin_add_view', $this->data);
				}
				
			}
			
		} else {
			$this->data['table_name'] = '';
			$this->data['error'] = 'Неправильный запрос';
			$this->load->view('admin/admin_index_view', $this->data);
		}
		
	}
	
	
	
	public function update()
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
		$id = $this->uri->segment(5);
		$this->data['id'] = $id;
		
		if($table_name = $this->uri->segment(4) and $id) {
			
			$this->data['table_name'] = $table_name;
			if($fields = $this->Super_model->get_field_data($table_name)) {
				$result = '';
				foreach ($fields as $field) {
					
					$relation = isset($this->relations[$table_name]);
					
					if($relation) {
					
						if(!$field->primary_key && $this->relations[$table_name]['has_one']!=$field->name) {
						
							$result = $this->_do_validate_and_return_input($field, $table_name, $result);
							
						} elseif(!$field->primary_key) {
						
							$has_one = $this->relations[$table_name]['has_one'];
							$result .= $this->admin->return_select_for_has_one($field, $this->relations[$table_name]['has_one'], array('cid', 'title'),'', $this->input->post($has_one));
						
						}
					
					} else {
					
						if(!$field->primary_key) {
						
							$result = $this->_do_validate_and_return_input($field, $table_name, $result);
							
						}	
					
					}
					
					if(!$field->primary_key && $this->input->post($field->name)) {
					
						$this->data_to_insert[$field->name] = $this->input->post($field->name, true);
						
					}
				}
				
				$result .= '<input type="hidden" value="foobar" name="foobar "/>';
				$this->form_validation->set_rules('foobar', '', 'exact_length[6]');
				
				$this->data['fields'] = $result;
				
				if($this->form_validation->run()) {
					$this->db->where('id', $id);
					$this->db->update($table_name, $this->data_to_insert);
					$this->data['success'] = 'Материал успешно обновлен!';
					$this->load->view('admin/admin_edit_view', $this->data);
				} else {
					$this->data['error'] = '<b>Ошибка при заполнении формы:</b> ';
					if(!isset($this->data_to_insert)) $this->data['error'] .= '<br/> Все поля пусты!';
					$this->load->view('admin/admin_edit_view', $this->data);
				}
				
			}
			
		} else {
			$this->data['table_name'] = '';
			$this->data['error'] = 'Неправильный запрос';
			$this->load->view('admin/admin_index_view', $this->data);
		}
		
	}
	
	
	public function delete() 
	{

		$this->data['is_admin'] = $this->session->userdata('is_admin');
		$this->form_validation->set_error_delimiters('<li>', '</li>');
		
		$id = $this->uri->segment(5);
		$this->data['id'] = $id;
		
		if($table_name = $this->uri->segment(4) and $id) {
		
			if($this->db->delete($table_name, array('id'=>$id))) {
					$this->data['success'] = 'Запись успешно удалена!';
					$this->load->view('admin/admin_index_view', $this->data);
			} else {			
			$this->data['error'] = 'Не удалось удалить запись!';
			$this->load->view('admin/admin_index_view', $this->data);
			}
			
		} else {
			$this->data['table_name'] = '';
			$this->data['error'] = 'Неправильный запрос';
			$this->load->view('admin/admin_index_view', $this->data);
		}
	
	}
	
	public function logout() 
	{
		$this->session->set_userdata('is_admin', FALSE);
		$this->data['is_admin'] = FALSE;
		$this->data['success'] = 'Вы успешно вышли!';
		$this->data['table_name'] = '';
		$this->load->view('admin/admin_index_view', $this->data);		
	}
	
	
	private function _do_validate_and_return_input($field, $table_name, $result)
	{
		if(isset($this->comments[$table_name][$field->name])) {
			$result = $result . $this->admin->return_input_for_add($field, htmlspecialchars($this->input->post($field->name, true)), $this->comments[$table_name][$field->name]);
		} else {
			$result = $result . $this->admin->return_input_for_add($field, htmlspecialchars($this->input->post($field->name, true)));
		}

		if(isset($this->validation[$table_name][$field->name]) ) {					
			$this->form_validation->set_rules($field->name, $this->admin->translate_to_rus($field->name), $this->validation[$table_name][$field->name]);
		}
		
		return $result;
	}
	
	private function _do_validate_and_return_input_for_edit($field, $table_name, $result, $row)
	{
		$fieldname = $field->name;
		if(isset($this->comments[$table_name][$field->name])) {
			$result = $result . $this->admin->return_input_for_add($field, htmlspecialchars($row->$fieldname), $this->comments[$table_name][$field->name]);
		} else {
			$result = $result . $this->admin->return_input_for_add($field, htmlspecialchars($row->$fieldname));
		}

		if(isset($this->validation[$table_name][$field->name]) ) {					
			$this->form_validation->set_rules($field->name, $this->admin->translate_to_rus($field->name), $this->validation[$table_name][$field->name]);
		}
		
		return $result;
	}
	
	public function upload() 
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		if($this->session->userdata('is_admin')) 
		{
			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'gif|jpg|png|pdf';
			$config['max_size']	= '1000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);

			$this->upload->do_upload('fileToUpload');
		
		$upload_data = $this->upload->data();
		if(!$this->upload->display_errors()) {
			$error = "";
		} else {
			$error = $this->upload->display_errors('', '');
		}
		$msg = "";
		$fileElementName = 'fileToUpload';
		if(!empty($_FILES[$fileElementName]['fileToUpload']))
		{
			switch($_FILES[$fileElementName]['fileToUpload'])
			{

				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;

				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
		{
			$error = 'No file was uploaded..';
		} else 
		{
				$msg .= '<p>Путь к файлу:</p><p><input type="text" value="/uploads/'. $upload_data['file_name'] . '" /></p>';
		}		
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "'\n";
		echo "}";		
			
		} else {
			show_404();
		}
	}
	
	public function show() 
	{
		$this->data['is_admin'] = $this->session->userdata('is_admin');
		$table_name = $this->uri->segment(4);
		$offset = $this->uri->segment(5);
		$limit = 10;
		
		if($table_name) {
			
			if($this->data[$table_name] = $this->Super_model->get_with_limit_and_offset($table_name, $limit, $offset))
			{
				$config['uri_segment'] = 5;
				// путь к веб-странице на которой делается пагинация
				$config['base_url'] = base_url().'admin/panel/show/'.$table_name;
				// получаем общее кол-во записей в таблице ex_cars
				$config['total_rows'] = $this->Super_model->count_all($table_name);
				// кол-во элементов, которое мы хотим показать на странице
				$config['per_page'] = $limit;
				
				$config['cur_tag_open'] = '<li class="disabled"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['prev_tag_open'] = '<li>';
				$config['prev_tag_close'] = '</li>';
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				// инициализация пагинации на основании заданных условий
				$this->pagination->initialize($config);
				$this->data['pag_links'] = $this->pagination->create_links();
				$this->data['table_name'] = '';
				$this->data['table_name_show'] = $table_name;
				$this->load->view('admin/admin_show_view', $this->data);
			} else {
			$this->data['table_name'] = '';
			$this->data['table_name_show'] = $table_name;
			$this->data['error'] = 'В таблице нет данных';
			$this->load->view('admin/admin_index_view', $this->data);
			}
			
			
			
		} else {
			$this->data['table_name'] = '';
			$this->data['error'] = 'Неправильный запрос';
			$this->load->view('admin/admin_index_view', $this->data);
		}
	
	}

}
/* End of file panel.php */
/* Location: ./application/controllers/admin/panel.php */
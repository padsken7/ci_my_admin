<?php

class Super_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	/* format: $table = 'string'; */
	function count_all($table) 
	{ 
		return $this->db->count_all($table);
	}
	
	/* format: $table = 'string'; $where = array() */	
	function count_all_where($table, $where) 
	{ 
		$this->db->where($where);
		return $this->db->count_all_results($table);
	}
	
	/* format: $table = 'string'; */
	function get_all($table) 
	{
		$query = $this->db->get($table);
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	/* format: $table = 'string'; $params = array(); */
	function get_all_where($table, $params) 
	{
		$query = $this->db->get_where($table, $params);
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	/* format: $table = 'string'; $params = array('id'=>num, 'title'=>'string'); */
	function get_one($table, $params)
	{
		$query = $this->db->get_where($table, $params);
		if($query->num_rows() > 0) 
		{
			return $query->row();
		}
	}
	
	/* format: $table = 'string'; $limit = num; $offset = num; */
	function get_with_limit_and_offset($table, $limit, $offset)
	{
		$this->db->limit($limit, $offset);
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/* format: $table = 'string'; $limit = num; $offset = num; $where = array();*/
	function get_with_limit_and_offset_where($table, $limit, $offset, $where)
	{
		$this->db->limit($limit, $offset);
		$this->db->where($where);
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/* format: $table = 'string'; */
	function get_field_data($table) 
	{
		if($fields = $this->db->field_data($table))
		{
			return $fields;
		}
	
	}
	
}
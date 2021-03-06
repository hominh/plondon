<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Post_model extends CI_Model {
    protected $_table = 'post';
    
    public function __construct() { 
        $this->load->database();
        parent::__construct();
    }
    
    public function getList() {
        $this->db->select('a.id,a.title,a.description,a.content,a.meta_keyword as postkeyword,a.meta_description as postdescription,a.image,a.slug as slugpost,a.name as namepost,a.categorypost_id,b.name as namecategory,b.slug,b.meta_keyword,b.meta_description')
            ->from('post as a')
            ->join('categorypost as b','a.categorypost_id = b.id','INNER');
            
        $query = $this->db->get();
        return $query->result();
    }
    public function getListAll() {
        $this->db->select('a.id,a.title,a.description,a.content,a.meta_keyword as articlekeyword,a.meta_description as articledescription,a.image,a.slug as slugarticle,a.name as namearticle,a.categoryfooter_id,b.name as namecategory,b.slug,b.meta_keyword,b.meta_description')
            ->from('post as a')
            ->join('categorypost as b','a.categorypost_id = b.id','INNER');
            
        $query = $this->db->get();
        return $query->result();
    }
    public function getByCateId($id) {

    }
    public function getListInHome() {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('showhome','1');
        $this->db->order_by('id', 'ASC');
        $this->db->limit('6');
        $query = $this->db->get();
        return $query->result();
    }
    public function getTop() {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('top','1');
        $this->db->order_by('date_created', 'ASC');
        $this->db->limit('10');
        $query = $this->db->get();
        return $query->result();
    }
    public function countAll() {
        return $this->db->count_all($this->_table);
    }
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_table);
    }
    public function insert($data_insert) {
        $this->db->insert($this->_table, $data_insert);
    }
    public function getById($id) {
        $this->db->where("id", $id);
        return $this->db->get($this->_table)->row_array();
    }
    public function get_gioithieuById($slug) {
         $this->db->select('a.id,a.title,a.description,a.content,a.image,a.slug as slugpost,a.name as namepost,a.meta_keyword as metakeywordpost,a.meta_description as metadescriptionpost,a.categorypost_id,b.title as titlecategory,b.name as namecategory,b.slug,b.meta_keyword,b.meta_description')
            ->from('post as a')
            ->join('categorypost as b','a.categorypost_id = b.id','RIGHT')
            ->where('b.slug',$slug);
        $query = $this->db->get();
        return $query->result();;
    }
    public function get_gioithieuByslug($slug) {
        $query = $this->db->get_where($this->_table, array('slug' => $slug));
        return $query->row_array();
    }
    public function update($data_update, $id) {
        $this->db->where("id", $id);
        $this->db->update($this->_table, $data_update);
    }
    public function getByCategoryId($slug) {
        /*$this->db->select('post.*,categoryfooter.*')
            ->from($this->_table)
            ->join('categoryfooter','post.categoryfooter_id = categoryfooter.id')
            ->where('slug',$slug);
        $query = $this->db->get();*/
        $this->db->select('a.id,a.title,a.description,a.content,a.image,a.slug as slugpost,a.name as namepost,a.categorypost_id,b.title as titlecategory,b.name as namecategory,b.slug,b.meta_keyword,b.meta_description')
            ->from('post as a')
            ->join('categorypost as b','a.categorypost_id = b.id','INNER')
            ->where('b.slug_parent',$slug);
        $query = $this->db->get();
        return $query->result();

    }
    
    public function checkName($new) {
        $this->db->where('name', $new);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
        
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_model {

	public $nama_barang;
	public $merk;
	public $stok;
	public $active;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function getdata()
	{
		$this->db->select("*");
		$this->db->from("barang");
		$this->db->where("active",1);
		$temp = $this->db->get();
		return $temp->result_array();
	}
	public function insert()
	{		
		$data=(array)$this;
		$this->db->insert("barang",$data);
	}
	public function getonedata($id)
	{
		$this->db->select("*");
		$this->db->from("barang");
		$this->db->where("barang_id",$id);
		$temp = $this->db->get();
		return $temp->result_array();
	}

	public function update($barang_id)
	{
		
		$data=(array)$this;
		$this->db->update("barang",$data,array("barang_id"=>$barang_id));
	}

	public function delete_barang($barang_id)
	{

		$this->db->update("barang",array("active"=> 0),array("barang_id"=>$barang_id));
	}


	
	
}

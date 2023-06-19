<?php
ob_start();
class Web_model extends CI_Model{
	// public function getmenuListByid($wher='')
	// {
	// 	$this->db->select('`prod_id`, `prod_title`, `prod_category`, `prod_sub_category`, `prod_brand`, `prod_mesurements`, `prod_status`, `prod_available_locations`, `prod_created_date`, `prod_updated_date`, `orders_count`, `prod_description`, `sub_cat_id`, `is_popular`, `available_subscraibe`, `prod_slug`'); 
	// 	$this->db->from('products');
	// 	if($wher!=''){
	// 	$this->db->where($wher);
	// 	}
	// 	 return $this->db->get()->result_array();
	// }
	public function getmenuListByid($wher='')
	{
		$this->db->select('t1.`prod_id`, t1.`prod_title`, t1.`prod_category`, t1.`prod_sub_category`,t1. `prod_brand`, t1.`prod_mesurements`, t1.`prod_status`, t1.`prod_available_locations`,t1. `prod_created_date`, t1.`prod_updated_date`, t1.`orders_count`, t1.`prod_description`, t1.`sub_cat_id`, t1.`is_popular`, t1.`available_subscraibe`, t1.`prod_slug`,t1.`combo_products`,t2.`brand_id`,t2.`brand_title`,t3.`id`, t3.`prod_id`, t3.`mes_id`, t3.`prod_image`, t3.`prod_image_name`, t3.`prod_org_price`, t3.`prod_offered_price`, t3.`prod_available_qty`'); 
			$this->db->from('products t1');
		if($wher!=''){
			$this->db->where($wher);
		}
		$this->db->join('category_brands t2', 't1.prod_brand = t2.brand_id', 'left'); 
		$this->db->join('product_mesurments t3', 't1.prod_id = t3.prod_id', 'left'); 
		return $this->db->get()->result_array();
		 // echo $this->db->last_query();exit;
	}
	public function getmenuidByidTitles($wher='')
	{
		$this->db->select('t1.`prod_id`, t1.`prod_title`, t1.`prod_category`, t1.`prod_sub_category`,t1. `prod_brand`, t1.`prod_mesurements`, t1.`prod_status`, t1.`prod_available_locations`,t1. `prod_created_date`, t1.`prod_updated_date`, t1.`orders_count`, t1.`prod_description`, t1.`sub_cat_id`, t1.`is_popular`, t1.`available_subscraibe`, t1.`prod_slug`,t3.`id`, t3.`prod_id`, t3.`mes_id`, t3.`prod_image`, t3.`prod_image_name`, t3.`prod_org_price`, t3.`prod_offered_price`, t3.`prod_available_qty`,t4.`mes_id`,t4.`title`'); 
			$this->db->from('products t1');
		if($wher!=''){
			$this->db->where($wher);
		}
		
		$this->db->join('product_mesurments t3', 't1.prod_id = t3.prod_id', 'left'); 
		$this->db->join('mesurements t4', 't3.mes_id = t4.mes_id', 'left');
		$this->db->group_by('t4.title'); 
		return $this->db->get()->result_array();
		 // echo $this->db->last_query();exit;
	}
	public function getmenuidByidPrices($wher='')
	{
		$this->db->select('t1.`prod_id`, t1.`prod_title`, t1.`prod_category`, t1.`prod_sub_category`,t1. `prod_brand`, t1.`prod_mesurements`, t1.`prod_status`, t1.`prod_available_locations`,t1. `prod_created_date`, t1.`prod_updated_date`, t1.`orders_count`, t1.`prod_description`, t1.`sub_cat_id`, t1.`is_popular`, t1.`available_subscraibe`, t1.`prod_slug`,t3.`id`, t3.`prod_id`, t3.`mes_id`, t3.`prod_image`, t3.`prod_image_name`, t3.`prod_org_price`, t3.`prod_offered_price`, t3.`prod_available_qty`'); 
			$this->db->from('products t1');
		if($wher!=''){
			$this->db->where($wher);
		}
		
		$this->db->join('product_mesurments t3', 't1.prod_id = t3.prod_id', 'left'); 
		// $this->db->join('mesurements t4', 't3.mes_id = t4.mes_id', 'left');
		$this->db->group_by('t3.prod_offered_price'); 
		return $this->db->get()->result_array();
		 // echo $this->db->last_query();exit;
	}
	public function getBrands($wher='')
	{
		$this->db->select('t1.prod_brand,b.brand_id,b.brand_title');
		$this->db->from('products t1');
		if($wher!=''){
		$this->db->where($wher);
		 }
		$this->db->join('category_brands b', 't1.prod_brand = b.brand_id', 'left');
		$this->db->group_by('t1.prod_brand');
		return $this->db->get()->result_array();
	}
	public function search_blog($title)
	{
        // $this->db->like('prod_title', $title);
        // $this->db->order_by('prod_title', 'ASC');
        // $this->db->limit(10);
        // return $this->db->get('products')->result();

		$this->db->select('t1.`prod_id`, t1.`prod_title`, t1.`prod_status`,`id`, t2.`prod_id`, t2.`prod_image`,t2.`prod_image_name`');
		$this->db->from('products as t1');
		$this->db->like('t1.prod_title', $title);
		$this->db->join('product_mesurments as t2', 't1.prod_id = t2.prod_id', 'LEFT');
		$this->db->order_by('t1.prod_title', 'ASC');
		$this->db->where('t1.prod_status', 1);
		$this->db->group_by('t1.prod_id',);
        $this->db->limit(10);
		return $this->db->get()->result();
	}
	public function fetch_data($limit, $start,$wher='')
 	{
 		$this->db->select('t1.`prod_id`, t1.`prod_title`, t1.`prod_category`, t1.`prod_sub_category`,t1. `prod_brand`, t1.`prod_mesurements`, t1.`prod_status`, t1.`prod_available_locations`,t1. `prod_created_date`, t1.`prod_updated_date`, t1.`orders_count`, t1.`prod_description`, t1.`sub_cat_id`, t1.`is_popular`, t1.`available_subscraibe`, t1.`prod_slug`,t1.`combo_products`,t2.`brand_id`,t2.`brand_title`,t3.`id`, t3.`prod_id`, t3.`mes_id`, t3.`prod_image`, t3.`prod_image_name`, t3.`prod_org_price`, t3.`prod_offered_price`, t3.`prod_available_qty`'); 
			$this->db->from('products t1');
			$this->db->group_by('t1.prod_id');
		if($wher!=''){
			$this->db->where($wher);
		}
		$this->db->limit($limit, $start);
		$this->db->join('category_brands t2', 't1.prod_brand = t2.brand_id', 'left'); 
		$this->db->join('product_mesurments t3', 't1.prod_id = t3.prod_id', 'left'); 

		return $this->db->get()->result_array();
		// return $this->db->last_query();
 	}
 	public function getOfferMenuListByid($wher='')
	{
		$this->db->select('t1.`prod_id`, t1.`prod_title`, t1.`prod_category`, t1.`prod_sub_category`,t1. `prod_brand`, t1.`prod_mesurements`, t1.`prod_status`, t1.`prod_available_locations`,t1. `prod_created_date`, t1.`prod_updated_date`, t1.`orders_count`, t1.`prod_description`, t1.`sub_cat_id`, t1.`is_popular`, t1.`available_subscraibe`, t1.`prod_slug`,t1.`combo_products`,t2.`brand_id`,t2.`brand_title`,t3.`id`, t3.`prod_id`, t3.`mes_id`, t3.`prod_image`, t3.`prod_image_name`, t3.`prod_org_price`, t3.`prod_offered_price`, t3.`prod_available_qty`'); 
			$this->db->from('products t1');
		if($wher!=''){
			$this->db->where($wher);
		}
		$this->db->join('category_brands t2', 't1.prod_brand = t2.brand_id', 'left'); 
		$this->db->join('product_mesurments t3', 't1.prod_id = t3.prod_id', 'left');
		$this->db->group_by('t1.prod_id'); 
		return $this->db->get()->result_array();
		 // echo $this->db->last_query();exit;
	}
}

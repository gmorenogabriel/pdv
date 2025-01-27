<?php namespace App\Models;
use CodeIgniter\Model;

class DatatablesModel extends Model{
    var $column_order = array('user_id','username','first_name','last_name','gender','password','status');
    var $order = array('user_id' => 'asc');

    function get_datatables(){
        // search
        if(isset($_POST['search']['value'])){
            $search = $_POST['search']['value'];
//            $kondisi_search = "NamaTeman LIKE '%$search%' OR Alamat LIKE '%$search%' OR JenisKelamin LIKE '%$search%'";
$kondisi_search = " username LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR gender LIKE '%$search%'";
        } else {
            $kondisi_search = "user_id != ''";
        }

        // order
        if(isset($_POST['order'])){
            $result_order = $this->column_order[$_POST['order']['0']['column']];
            $result_dir = $_POST['order']['0']['dir'];
        } else if ($this->order){
            $order = $this->order;
            $result_order = key($order);
            $result_dir = $order[key($order)];
        }


		if(isset($_POST['length']) !=-1);
		$db = db_connect();
		$builder = $db->table('user_table');
		$query = $builder->select('*')
				->where($kondisi_search)
				->orderBy($result_order, $result_dir)
				->limit($_POST['length'], $_POST['start'])
				->get();
		return $query->getResult();
    }


    function totalRegistros(){
        $sQuery = "SELECT COUNT(user_id) as cantRegTotales FROM user_table";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        return $query;
    }

    function totalFiltros(){
        // kondisi_search
        if(isset($_POST['search']['value'])){
            $search = $_POST['search']['value'];
            $kondisi_search = " AND (first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR username LIKE '%$search%' OR status LIKE '%$search%')";
        } else {
            $kondisi_search = "";
        }
        $sQuery = "SELECT COUNT(user_id) as jml FROM user_table WHERE user_id != '' $kondisi_search";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        return $query;
    }
    

}
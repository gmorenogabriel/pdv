<?php namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\DatatablesModel;
class Datatables extends BaseController{

    public function index(){
        return view('datatables/datatables');
    }

    public function table_data(){
        $model = new DatatablesModel();
        
        $listing       = $model->get_datatables();
        $recordsTotal  = $model->totalRegistros();
        $recordsFiltered = $model->totalFiltros();
     //   $totalHombres = $model->totalHombres();
     //   $cantidadMujeres = $model->totalMujeres();

        $data = array();
        $no   = $_POST['start'];
        foreach ($listing as $key){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->username;
            $row[] = $key->first_name;
            $row[] = $key->last_name;
            $row[] = $key->gender=='Male' ? "<span style='color:#1acc2b;'><i class='fa fa-user'></i> &nbsp; Hombre </span>" : "<span style='color:#FF1493;'><i class='fa fa-female'></i> &nbsp; Mujer </span>";
            $row[] = $key->password;
            $row[] = $key->status==1 ? "<span style='color:#1acc2b;'><i class='fa fa-check'></i> &nbsp; Activo" : "<span style='color:#FF1493;'><i class='fa fa-user-times'> Inactivo";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $recordsTotal->cantRegTotales,
            "recordsFiltered" => $recordsFiltered->jml,
            // "cantHombres"     => $totalHombres->cantRegHombres,
            // "cantMujeres"     => $cantidadMujeres->cantRegMujeres,
            "data" => $data
        );
        echo json_encode($output);
    }
    public function totalHombres(){
		header('Access-Control-Allow-Origin: *'); // Permite todas las solicitudes de origen
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');
        $sQuery = "SELECT COUNT(user_id) as cantRegHombres FROM user_table WHERE gender = 'Male'";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        return $query->cantRegHombres;
    }
    public function totalMujeres(){
        $sQuery = "SELECT COUNT(user_id) as cantRegMujeres FROM user_table WHERE gender = 'Female'";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        return $query->cantRegMujeres;
    }
    public function totalActivos(){
        $sQuery = "SELECT COUNT(user_id) as cantActivos FROM user_table WHERE status = '1'";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        return $query->cantActivos;
    }
    public function totalInactivos(){
        $sQuery = "SELECT COUNT(user_id) as cantInactivos FROM user_table WHERE status = '0'";
        $db = db_connect();
        $query = $db->query($sQuery)->getRow();
        return $query->cantInactivos;
    }
}

?>
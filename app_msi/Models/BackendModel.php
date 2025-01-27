<?php

namespace  App\Models;
use CodeIgniter\Model;
use App\Models\MenusModel;

class BackendModel extends Model{

    public function __construct(){
        $this->menus = new MenusModel();
    }

    public function getID($link){
        //Recibo la direccion perteneciente al módulo
        
        $this->like('link', $link);
        $resultado = $this->menus->get($this->menus);
        return $resultado->row();

    }
    public function getPermisos($menu, $rol){
        $resultado = $this->menus->where("menu_id",$menu)
            ->where("rol_id",$rol)
            ->first();
        return $resultado;
    }
}   

?>
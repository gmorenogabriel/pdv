<?php namespace App\Libraries;
use App\Models\MenusModel;
use App\Models\BackendModel;


class Backend_lib {

	protected $backend, $miNombre;

	public function __construct(){       
		// Instanciamos los Modelos y Librerias de Codeigniter
        	// $url = $this->request->uri;
	        $this->menus = new MenusModel();
	        $backendM = new BackendModel();
	}	

	public function control(){
		// Preguntamos si es falso y lo relogueamos al Login
	//	echo "Backend_lib -> control()";
		$this->miNombre = "Gabriel hola desde Backend_lib control()";
		return $this->miNombre;

		if(!session()->get('login')){

//  Habilitar            redirect(base_url());
			echo "Id_Caja: " . session()->get('id_caja');
			echo "<br>";
			echo "Id_usuario: " . session()->get('id_usuario');
			echo "<br>";
			echo "Nombre : ";
			print_r($_SESSION['nombre']);
		}
     
		if ($this->request->uri->getSegments(2)){
			$url = $this->request->uri->getSegments(1)."/".$this->request->uri->getSegments(2);
        }
        // va a BackendModel;
		$infomenu = $this->backend->getID($url);

		$permisos = $this->backend->getPermisos($infomenu->id,session()->get("rol"));
		print_r($permisos);
		die();
		if ($permisos->read == 0 ){
			redirect(base_url()."inicio"); //dashboard
		}else {
			return $permisos;
		}
	}
}
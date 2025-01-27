<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pdv;

class Home extends BaseController{
	
	//public $empresa;
	protected $helpers = array('date','matematica');

	public function __construct(){	
	//	echo $this->empresa->empresaRuc . "<br/>";;		
	}
	public function nuevoCliente(){
		if($this->request->getMethod() !== 'post'){
			return redirect()->to(site_url('Home/index'));
		}
		$val = $this->validate([
			'nombre' => 'required',
			'email' => 'required',
		]);
		if(!$val){
			//Error
			return redirect()->back()->withInput()->with('error', $this->validator);
		}else {
			//Form ok
		}

		// Datos recibidos desde el Formulario
		$nombre = $this->request->getPost('nombre');
		$email = $this->request->getPost('email');
		
		// Validar datos
		$params = [
			'nombre' => $nombre,
			'email' => $email,
		];
		$db = db_connect();
		$db->query("
		insert  into clientes
		values(0,
			:nombre:,
			:email:
		)
		", $params);
		$db->close();
		echo "Terminado ...";
		
	}
	//public function _remap($metodo){
	 	// 	if(method_exists($this, $metodo)){
	// 		return $this->$metodo();
	// 	}else{
	// 		// Si no Existe el Metodo lo manda al Index
	// 		return $this->index();
	// 	}
	 //}

	 public function index(){
		 $data = [];
		 if(session()->has('error')){
			 $data['error'] = session('error');
		 }
		return view('formulario', $data);
	 }
	 public function index2(){
		return view('formulario');
		// Usando Helper Matematica
		helper('date');
		echo now() . "<br/>";
		echo " ===================== <br/>";
		echo sumar(10, 30);
		echo "<br/>";
		echo restar(30, 3);
		echo "<br/>";
		echo restar(30, 3);
		echo "<br/>";
		echo dividir(30, 3);
		echo "<br/>";
		
		// Usando Library Matematica
		// $v = new Pdv();
		$v = new Pdv();		
		$v->producto = "Automovil";
		$v->precio = 10000;
		echo "<br/>";
		//echo $v->producto;
		echo "<br/>";
		//echo $v->precio;
		echo $v->info();
		echo "<br/>";
		echo $v->hash();
		echo "<br/>";		

		$empresa = $this->configEmpresa();
		echo " ===================== <br/>";
		echo ($empresa->empresaTitulo) . "<br/>";
		echo ($empresa->empresaDireccion) . "<br/>";
		echo ($empresa->empresaRuc) . "<br/>";
		echo ($empresa->empresaEmail) . "<br/>";
		echo " ===================== <br/>";

		$p = \Config\Services::parser();
		$data = [
			'frase' => 'Frase desde parser',
			];
		$p->setData($data = [
			'frase' => 'Frase desde parser',
			'nomes' =>  [
				 ['nome' => 'joao'],
				 ['nome' => 'carlos'],
				 ['nome' => 'ana'],
			],
			'admin' => false,
			]);
		echo $p->render('pagina');
		// echo view('pagina');

	}
	
	public function sss(){
	// Modo tradicional
		// $ses = \Config\Services::session();
		// $ses->set('usuario', 'GabrielM');
		// echo "<pre>";
		// print_r($_SESSION);

		// Session pertenece a un Helper
		session()->set('email','gmoreno@sinapsis.com.uy');
		echo "<pre>";
		print_r(session()->get());
		$this->test();
	}
	public function test(){
		// $ses = \Config\Services::session();
		//echo $ses->get('usuario');
		echo 'E-mail: ' . session()->get('email');
		echo "<br/>";
		// o asi es igual, se accede a esa propiedad
		echo 'Usuario: ' . session()->usuario;
	}
	

	//-----------------------------------------------------------------
  private function index_lang(){
	/* prueba mensajes en distintos idiomas */
	echo 'index_lang';
	//echo view ('welcome_message');
  }
  public function insertar(){
	  // Verificamos que lo recibmos por Post y que paso las reglas de Validacion
	//   if ($this->request->getMethod() == "post" && $this->validate($this->reglas()){
		//   $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
		//   $this->usuarios->save([
		// 	'usuario' => $this->request->getPost('usuario'),
		// 	'password' => $hash,
		// 	'nombre' => $this->request->getPost('nombre'), 
		// 	'id_caja' => $this->request->getPost('id_caja'),
		// 	'id_rol' => $this->request->getPost('id_rol'),
		// 	'activo' => 1
			// ]);
		//   return redirect()->to(base_url() . '/usuarios');
	//   }else{
	// 	  // a $data se deben agregar todos los arrays por ejemplo Cajas y Roles
	// 	  $cajas = $this->cajas->where('activo', 1)->findAll();
	// 	  $roles = $this->roles->where('activo', 1)->findAll();
	// 	  $data = ['titulo' => 'Agregar Unidad', 'validation' => $this->validator,
	// 		'cajas' => $cajas,
	// 		'roles' => $roles,
	// 	];
	// 	  echo view('header');
	// 	  echo view('usuarios/nuevo', $data);
	// 	  echo view('footer');
	//   }
	}
}
<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\Config\Services;

class BaseController extends Controller{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url'];
	protected $session, $headers, $body, $ch, $res, $logger;
	protected $empresa;


	// mis configuraciones
	//                     config->custom.php	
	//   = [
	// 	'empresaTitulo'    => 'Mi titulo de página',
	// 	'empresaDireccion' => 'Luis Alberto de Herrera 1247 piso 22',
	// 	'empresaRuc'       => '216.857.2200.11',
	// 	'$empresaEmail'    => 'webmaster@example.com',
	// ];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		// $uri = service('uri');
		// $this->session = \Config\Services::session();
		// $language = \Config\Services::language();
		// $language->setLocale($this->session->lang);
		
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		// Ensure that the session is started and running
		if (session_status() == PHP_SESSION_NONE){
			$this->session = Services::session();
		}
	}
	public function sendNotification($title, $body){
		$headers = [
			//'Authorization: key=';
		];
		$body = [];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

		$res = curl_exec($ch);
		curl_close($ch);

	}
	protected function configEmpresa(){
		$empresa = config('Config\Custom');
		return $empresa;
	}
	public function ejemploReflection(){
		$reflection = new \ReflectionClass($this);
		$refClass = $reflection->getShortName();
	
		//ho "<br>" . "===============================" . "</br>";
	    // Obtener el nombre completo del método (clase + método)
        $metodoCompleto = __METHOD__; // Devuelve "App\Controllers\MiControlador::miMetodo"

        // Obtener solo el nombre del método
        $metodoSolo = __FUNCTION__; // Devuelve "miMetodo"

        // Obtener el nombre de la clase
        $nombreClase = __CLASS__; // Devuelve "App\Controllers\MiControlador"
		// echo "<br>" . "===============================" . "</br>";

			//	echo "Clase: $nombreClase<br>";
			//	echo "Método completo: $metodoCompleto<br>";
			//	echo "Método: $metodoSolo<br>";

			//  echo "<br>" . "===============================" . "</br>";

		   // Crear una instancia de ReflectionClass
				$reflection = new \ReflectionClass($this);

				// Obtener todos los métodos de la clase actual
				$metodos = $reflection->getMethods();

				foreach ($metodos as $metodo) {
				//	echo $metodo->name . "<br>"; // Imprime el nombre de cada método
				}
		//echo "<br>" . "===============================" . "</br>";		
		//d($refClass);
		}
}

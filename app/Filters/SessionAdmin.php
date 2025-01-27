<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionAdmin implements FilterInterface
{
    //private $i;
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        if (session('id_rol') != 1 && session('id_rol') != 2 && session('id_rol') != 3) {
            log_message('info','Cheque del Rol : {id_rol}');
            return redirect()->to(base_url('/'));
        }                
        // Traza
        $config = config('Logger');
        if ($config->threshold === 8) {

            
            log_message('info','threshold {$config->threshold}');

            log_message('debug', "SessionAdmin {$config->threshold} ");
            switch ($config->threshold) {
                case "1":
                    $nivel = 'emergency';
                    break;
                case "2":
                    $nivel = 'alert';
                    break;
                case "3":
                    $nivel = 'critical';
                    break;
                case "4":
                    $nivel = 'runtime';
                    break;
                case "5":
                    $nivel = 'warning';
                    break;
                case "6":
                    $nivel = 'notice';
                    break;
                case "7":
                    $nivel = 'info';
                    break;
                case "8":
                    $nivel = 'debug';
                    break;
                default:
                    $nivel = 'Deshabilitado';
            };
           
                // Obtenemos el nombre del Controlador/Metodo
                $router = \Config\Services::router();
                $_method = $router->methodName();
                $_controller = $router->controllerName();
                $controlador = explode('\\', $_controller);
                $this->clase = $controlador[max(array_keys($controlador))];
                log_message("{$nivel}", "SessionAdmin Controlador {$this->clase} ");
           
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

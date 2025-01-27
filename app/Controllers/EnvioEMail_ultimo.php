<?php 
namespace App\Controllers;
use CodeIgniter\Images\Exceptions\ImageException;

class EnvioEMail extends BaseController{

    protected $email;
    protected $clase;
    protected $reglas;
    protected $adjuntos;

    public function __construct(){

        $router = \Config\Services::router();
        $_method = $router->methodName();
        $_controller = $router->controllerName();         
        $controlador = explode('\\', $_controller) ;
        $this->clase = $controlador[max(array_keys($controlador))] ;

		// Encripta/Desencripta
        // $this->CI->load->library('encryption');        helper(['form']);

        helper(['form', 'url']);
        // Variables para nuestras reglas de validac.del Form
        $this->reglas = [
            'codigo' =>  [
                'rules' => 'required|is_unique[productos.codigo]',
                'errors' => [
                    'required'=> 'El campo {field} es obligatorio.',
                    'is_unique'=> 'El campo {field} debe ser único.'
                ]
            ],
            'nombre' => [               
                'rules' => 'required',
                'errors' =>  [
                    'required'=> 'El campo {field} es obligatorio.'
                    ]
                ]
            ];
    }

    public function index(){
        if($this->session->has('id_usuario') === false) { 
            return redirect()->to(base_url()); 
        }
  
        $data = [ 
            'titulo' => 'Datos para envío de EMail'
        ];
		echo view('header');
		echo view('envioemail/envioemail', $data);
		echo view('footer');
		//echo view('dashboard');
    }
    public function enviaremail(){

        if($this->request->getMethod() == "post" ){ //&& $this->validate($this->reglas)){    
            $para    = $this->request->getPost('para');
            $asunto  = $this->request->getPost('asunto');
            $mensaje = $this->request->getPost('mensaje');
            $this->adjuntos=$this->request->getFileMultiple('images');
            
            // Load Services in Controller
            $email= \Config\Services::email();
            $email->setFrom($email->SMTPUser, 'Info');
            $email->setTo($para);
            $email->setBCC('');
            $email->setCC('');
            if($asunto){
                $email->setSubject($asunto);
            }
            $email->setMessage($mensaje);
            
            // $database = \Config\Database::connect();
            // $db = $database->table('users');
            $msg = 'Please select a valid files';

            if ($this->request->getFileMultiple('images')) {

                foreach($this->request->getFileMultiple('images') as $file)
                {   
                    $file->move(WRITEPATH . 'uploads');

                    $email->attach(WRITEPATH . 'uploads/' . $file->getClientName());   

                    $data = [
                    'name' =>  $file->getClientName(),
                    'type'  => $file->getClientMimeType()
                ];
            //   $save = $db->insert($data);
                $msg = 'Files have been successfully uploaded';
                $hayAdjuntos = true;
                }

            }
             if($email->send()){       
                 $data = [
                     'titulo' => 'Envío de E-Mail',
                     'titulo2' => 'E-Mail enviado correctamente',
                 ];
                 $msgToast = [
                     's2Titulo' => $this->clase, 
                     's2Texto' => 'E-Mail enviado correctamente',
                     's2Icono' => 'success',
                     's2Toast' => 'true'
                 ];
                 echo "<br>";
                 echo view('header');
                 echo view('sweetalert2', $msgToast);            
                 return redirect()->to(base_url('inicio'));
                 echo view('footer');             
             }else{
                 $data = $email->printDebugger(['headers']);
                 print_r($data);
             }

          //  $customvalues = new \Config\Email();
          //  $this->envioEMailNuevo($para, $asunto, $mensaje, $this->adjuntos=null );
        }
    }

//     function uploadFiles($email) {
//         helper(['form', 'url']);
 
//         $database = \Config\Database::connect();
//         $db = $database->table('users');
 
//         $msg = 'Please select a valid files';
        
//         if ($this->request->getFileMultiple('images')) {
 
//              foreach($this->request->getFileMultiple('images') as $file)
//              {   
 
//                 $file->move(WRITEPATH . 'uploads');
 
//                 // $this->adjuntos =  $this->adjuntos . $file->getClientName() . ', ';
//                 $email->attach($file->getClientName(), 'inline');   

//                 $data = [
//                 'name' =>  $file->getClientName(),
//                 'type'  => $file->getClientMimeType()
//               ];
 
//            //   $save = $db->insert($data);
//               $msg = 'Files have been successfully uploaded';
//              }
//         }
//         return $email;
// //        return redirect()->to( base_url('/uploadmultiplefiles') )->with('msg', $msg);        
//     }

    public function envioEMailNuevo($para, $asunto, $mensaje, $adjuntos=null ){
  
     // Load Services in Controller
     $email= \Config\Services::email();
     $email->setFrom($email->SMTPUser, 'Info');
     $email->setTo($para);
     $email->setBCC('');
     $email->setCC('');
     if($asunto){
         $email->setSubject($asunto);
     }
     $email->setMessage($mensaje);
    //  $file_data = $this->upload_file();
    //  if(is_array($file_data)){
    //     $message = '
    //     <h3 align="center">Archivos adjuntos</h3>
    //     <table border="1" width="100%" cellpadding="5">
    //         <tr>
    //             <td width="30%">Nombre</td>
    //             <td width="70%">'.$this->input->post("name").'</td>
    //         </tr>
    //     </table>
    //     ';
    //  }else{
    //     $msgToast = [
    //         's2Titulo' => $this->clase, 
    //         's2Texto' => "Error al adjuntar los archivos",
    //         's2Icono' => 'error',
    //         's2ConfirmButtonText' => true,
    //         's2ShowConfirmButton' => true,            
    //         's2Toast' => false,
    //         's2Footer' => 'Error en los adjuntos',
    //     ];
    //     echo view('header');
    //     echo view('sweetalert2', $msgToast);                    

    //  }
     if($adjuntos){

         $email->setAttach($adjuntos);    
         echo "<pre>";
         print_r($adjuntos);
         echo "</pre>";
         die();
    
     }        
     if($email->send()){       
         $data = [
             'titulo' => 'Envío de E-Mail',
             'titulo2' => 'E-Mail enviado correctamente',
         ];
         $msgToast = [
             's2Titulo' => $this->clase, 
             's2Texto' => 'E-Mail enviado correctamente',
             's2Icono' => 'success',
             's2Toast' => 'true'
         ];
         echo "<br>";
         echo view('header');
         echo view('sweetalert2', $msgToast);            
         echo view('enviomail/enviomail', $data);
         echo view('footer');             
     }else{
         $data = $email->printDebugger(['headers']);
         print_r($data);
     }
 }

    public function envioEMail(){
        // Load Services in Controller
        $email= \Config\Services::email();
        $email->setTo('gmorenogabriel@gmail.com');
        $email->setFrom('scf3487@gmail.com', 'Info');
       // $email->setBCC('1961gamt@gmail.com');
       // $email->setCC('1961gamt@gmail.com');
        $email->setSubject('EMail desde Codeigniter 4, Test');
        $email->setMessage('Texto del Mensaje enviado como prueba desde Codeigniter 4 /productos/envioEMail' );
        $filepath= base_url() . '/uploads/';
        $email->attach($filepath.$adjuntos);
        if($email->send()){       
            $data = [
                'titulo' => 'Envío de E-Mail',
                'titulo2' => 'E-Mail enviado correctamente',
            ];
            $msgToast = [
                's2Titulo' => $this->clase, 
                's2Texto' => 'E-Mail enviado correctamente',
                's2Icono' => 'success',
                's2Toast' => 'true'
            ];
            echo "<br>";
            echo view('header');
            echo view('sweetalert2', $msgToast);            
            echo view('enviomail/enviomail', $data);
            echo view('footer');             
        }else{
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
    public function imagenManipulacion(){
        helper('filesystem');
        try{
        $ruta = './images/productos/30/';
        $salida= './images/';
        if(!file_exists($salida)){
             mkdir($salida, 0777, true);
        }
        //dd($salida);
        $files = get_filenames($ruta);
        $arcUno  = $this->request->getFiles($ruta);
        $arcMul  = $this->request->getFileMultiple($ruta);
        $ord = 0;
        $data = [
            'titulo' => $this->clase,
            'ruta'   => $ruta,
            'salida' => $salida,
        ];
        // obtener la informacion de la imagen        
            foreach($files as $img){
                $info=\Config\Services::image()
                ->withFile($ruta . $img)
                ->getFile()
                ->getProperties(true);
                $ancho = $info['width'];
                $alto  = $info['height'];
                // echo "<br>";
                 echo "Procesando : " . $ruta . $img . " de ancho original " . $ancho . " y Alto Original : ".$alto;
                 echo "<br>";
                 echo "Procesado  : " . $salida . $img . " de ancho original " . $ancho . " y Alto Original : ".$alto;
                 echo "<br>";
                // Invocamos la librería
                $imagen=\Config\Services::image()
                ->withFile($ruta.$img)
                //->reorient()
                //->rotate(180)
                // fit recorta la imagen
                ->fit(100,100) 
                //->resize($ancho/2, $alto/2)
                //->crop(48,48,10,0)
                ->save($salida . $img);
                $data['img'][$ord] = $img;
                $ord++;
            } 
            echo view('header');          
            echo view('productos/imagen', $data);
            echo view('footer');        
        }catch (ImageException $e){
                    echo $e->getMessage();
        }
        //->reorient()
        //->rotate(180)
        // fit recorta la imagen
        //->fit(48,48,'left') 
        //->resize($ancho/2, $alto/2)
        //->crop(48,48,10,0)
        //->save('images/logo_pequeño.png');
//dd($data);    
    }
}
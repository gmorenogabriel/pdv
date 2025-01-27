<?php

use Config\Services;

Class Emails {

    protected $email;

    public function __construct(){
        $email= \Config\Services::email();
        $email->setTo('gmorenogabriel@gmail.com');

    }
    public function envioEMail($para, $asunto, $mensaje, $adjunto=null ){
        // Load Services in Controller
        // $email= \Config\Services::email();       
        //$email->setFrom('1961gamt@gmail.com');
        $this->email->setTo($para);
        $this->email->setSubject($asunto);
        $this->email->setMessage($mensaje);
        if($adjunto){
            $adjunto= base_url() . '/images/logo.png';
            $this->email->attach($adjunto);    
        }        
        if($this->email->send()){       
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
            $data = $this->email->printDebugger(['headers']);
            print_r($data);
        }
    }
}
<?php 
namespace App\Controllers;
use CodeIgniter\Controller;

class UploadMultipleFiles extends Controller
{

    public function index() {
        $data = [
            'titulo' => 'Subir imágenes'
         ];
        echo view('header');          
        echo view('uploadmultiplefiles/uploadmultiplefiles', $data);
        echo view('footer');          
    }

    function uploadFiles() {
        helper(['form', 'url']);
 
        $database = \Config\Database::connect();
        $db = $database->table('users');
 
        $msg = 'Please select a valid files';
  
        if ($this->request->getFileMultiple('images')) {
 
             foreach($this->request->getFileMultiple('images') as $file)
             {   
 
                $file->move(WRITEPATH . 'uploads');
 
              $data = [
                'name' =>  $file->getClientName(),
                'type'  => $file->getClientMimeType()
              ];
 
           //   $save = $db->insert($data);
              $msg = 'Files have been successfully uploaded';
             }
        }
 
        return redirect()->to( base_url('/uploadmultiplefiles') )->with('msg', $msg);        
    }

}
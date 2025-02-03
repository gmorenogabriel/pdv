<?php

namespace App\Models;

use CodeIgniter\Model;

class SweetMessageModel extends Model
{
    protected $table            = 'sweet_message';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['clase','accion','s2Icono','s2Titulo','s2Texto','s2Toast','showConfirmButton','confirmButtonColor','s2Footer','background','timer'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
	
	
	public function obtenerUnModelo($clase, $accion){
		//$model = new \App\Models\SweetMessageModel();
		$message = $this->where('clase', $clase)
						->where('accion', $accion)
						 ->get()   // Usamos get() para obtener los resultados
						 ->getRowArray();
						 //->getRowArray();  // Convertimos el primer resultado a un array
						// Tanto row() y first(), devuelven un Objeto, acceder con $msg->clase 
						// pero yo preciso un Array
						// ->row();
						// ->first(); 
		// dd($this->db->getLastQuery());

	  // Verificamos si el mensaje fue encontrado
		if (!$message) {
			return null;  // Si no se encuentra, retornamos null o puedes manejar el caso como prefieras
		}						  
		//$data = [];
		//foreach ($message as $msg){
			$data = [
				'clase'             => $message['clase'],
				'accion' 			=> $message['accion'],
				's2Icono' 			=> $message['s2Icono'],
				's2Titulo' 			=> $message['s2Titulo'],
				's2Texto' 			=> $message['s2Texto'],
				's2Toast' 			=> $message['s2Toast'],
				'showConfirmButton' => $message['showConfirmButton'],
				'confirmButtonColor'=> $message['confirmButtonColor'],
				'background' 		=> $message['background'],
				'timer'				=> $message['timer'],
				];		
		//}
		//dd($data);
		return $data;
	}
}

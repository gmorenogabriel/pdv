<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sweet_message extends Migration
{
    public function up()
    {
        // Definir la estructura de la tabla aquí
        $this->forge->addField([
            'id'          => [
                'type'          => 'INT',
				'constraint'	=> '11',
                'unsigned'      => true,
                'auto_increment'=> true,
            ],
            'clase'          => [
                'type'       => 'VARCHAR',
                'constraint' => '25',
            ],
            'accion'         => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],			
            's2Icono'        => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            's2Titulo'       => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            's2Texto'       => [
                'type'       => 'VARCHAR',
                'constraint' => '35',
            ],
            's2Toast'       => [
                'type'       => 'TINYINT',
                'constraint' => '1',
				'null'		 => false,	
            ],
            'showConfirmButton' => [
                'type'       => 'TINYINT',
                'constraint' => '1',
				'null'		 => false,				
            ],			
            'confirmButtonColor'=> [
                'type'       => 'VARCHAR',
                'constraint' => '10',
				'null'		 => false,
            ],
            's2Footer'       => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'background'     => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'timer'       => [
                'type'       => 'INT',
                'constraint' => '4',
            ],			
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
			'deleted_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
		$this->forge->addKey('id', true); // Clave primaria
        $this->forge->createTable('sweet_message'); // Crear la tabla
    }

    public function down()
    {
        //
		// Eliminar la tabla si se revierte la migración
        $this->forge->dropTable('sweet_message');
    }
}

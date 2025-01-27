<?php namespace Config;

/**
 * Database Configuration
 *
 * @package Config
 */

class Database extends \CodeIgniter\Database\Config
{

	/**
	 * This database connection is used when
	 * running PHPUnit database tests.
	 *
	 * @var array
	 */
	public $empresa2  = [
        'empresaTitulo'    => 'Mi titulo de página',    
        'empresaDireccion' => 'Luis Alberto de Herrera 1247 piso 22',
        'empresaRuc'       => '216.857.2200.11',
        '$empresaEmail'    => 'webmaster@example.com',
	];

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

	}

	//--------------------------------------------------------------------

}

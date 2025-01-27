<?php

namespace App\Controllers;

// Asegúrate de que el autoloader se carga si no está funcionando automáticamente
require_once ROOTPATH . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Xslx extends BaseController
{
    public function index()
    {
        // Crear una nueva hoja de cálculo
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Establecer algunos valores en la hoja
        $sheet->setCellValue('A1', 'Hola Mundo!');

        // Guardar el archivo como XLSX
        $writer = new Xlsx($spreadsheet);
        $writer->save('hello_world.xlsx');

        return 'Archivo Excel generado correctamente!';
    }
}

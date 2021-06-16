<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcel {
    private $header;
    private $data;
    private $filename;

    public function __construct($data,$header,$filename)
    {
        $this->data = $data;
        $this->header = $header;
        $this->filename = $filename;
    }
    public function setCellHeader($sheet)
    {
        $rowExcel = 1;
        $columnExcel = 1;
        foreach ($this->header as $name => $header) {
            if (strpos($name, '.') !== false){
                [$relationship,$column] = explode('.',$name);
                $sheet->setCellValueByColumnAndRow($columnExcel,$rowExcel,$header);
            }else{
                $sheet->setCellValueByColumnAndRow($columnExcel,$rowExcel,$header);
            }
            $columnExcel += 1;
        }
    }
    public function setCellData($sheet)
    {
        $rowExcel = 2;
        foreach($this->data as $key => $value){
            $columnExcel = 1;
            foreach ($this->header as $name => $header) {
                if (strpos($name, '.') !== false){
                    [$relationship,$column] = explode('.',$name);
                    $sheet->setCellValueByColumnAndRow($columnExcel,$rowExcel,$value->{$relationship}->{$column});
                }else{
                    $sheet->setCellValueByColumnAndRow($columnExcel,$rowExcel,$value->{$name});
                }
                $columnExcel += 1;
            }
            $rowExcel += 1;
        }
    }
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $this->setCellHeader($sheet);
        $this->setCellData($sheet);
        $response = response()->streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.urlencode($this->filename).'.xlsx"');
        $response->send();
    }
}

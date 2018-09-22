<?php

use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Created by PhpStorm.
 * User: nenad
 * Date: 20.9.18.
 * Time: 14.32
 */

class generateTimesheetReporteAction extends sfAction
{
    public function execute ($request)
    {
        $data = json_decode($request->getContent(), true);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $root = $this->getContext()->getConfiguration()->getRootDir() . '/web/reports';

        $spreadsheet = $reader->load($root . '/template/orange_test_template.xlsx'); //Excel as 2007-2013 xlsx
        $spreadsheet->setActiveSheetIndex(0);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");


        $styleArray = array(
            'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKYELLOW )
                //'background-color' => array('rgb' => 'FF9900' )
            ),
            'font' => array(
                'name' => 'Arial',
                'bold' => true,
//                'color' => array(
//                    'rgb' => 'white'
//                )
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    //'color' => array('rgb' => 'FF9900'),
                ),
            ),




//            'font' => [
//                'color' => 'FFFFFFFF',
//            ],
//            'borders' => [
//                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//                'color' => 'FFFFFFFF'
//            ],
//            'fill' => [
//                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                'color' => 'ED7D31'
//            ],
        );

        foreach($data['headers'] as $k => $v)
        {


            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, 10)->applyFromArray($styleArray);


//            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, 10)
//                ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#ED7D31');

            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($k + 1, 10, $v);
        }

        $filename = 'RMA-Report_' . time() . '.xlsx';
        $fileLocation = $root . '/' . $filename;
        $writer->save( $fileLocation);

        var_dump($spreadsheet); die;


        return $this->renderJson(array('postData' => $data));
    }
}
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

        $uri = $request->getUri();
        $webRoot = explode('index', $uri)[0];

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $root = $this->getContext()->getConfiguration()->getRootDir() . '/web/reports';

        $spreadsheet = $reader->load($root . '/template/orange_test_template.xlsx'); //Excel as 2007-2013 xlsx
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(8);
        $spreadsheet->getActiveSheet()->getStyle('B3')
            ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
        $spreadsheet->getActiveSheet()->getStyle('B3')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

        $headerRow = 3;
        switch($data['timesheetType'])
        {
            case 'Employee Report':

                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace(' ', '_', strtolower($data['employee']));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['employee']);
                break;
            case 'Project Report':

                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace('-', '_', str_replace(' ', '', strtolower($data['projectName'])));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['projectName']);

                if (isset($data['dateRangeFrom']))
                {
                    $headerRow++;
                    $headerDateFrom = 'Project report from: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $headerDateFrom);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['dateRangeFrom']);
                }
                if (isset($data['dateRangeTo']))
                {
                    $headerRow++;
                    $headerDateTo = 'Project report to: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $headerDateTo);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['dateRangeTo']);
                }

                break;
            case 'Attendance Report':

                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace(' ', '_', strtolower($data['employee']));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['employee']);

                if (isset($data['dateRangeFrom']))
                {
                    $headerRow++;
                    $headerDateFrom = 'Attendance report from: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $headerDateFrom);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['dateRangeFrom']);
                }
                if (isset($data['dateRangeTo']))
                {
                    $headerRow++;
                    $headerDateTo = 'Attendance report to: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $headerDateTo);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['dateRangeTo']);
                }

                if (isset($data['employeeStatus']))
                {
                    $headerRow++;
                    $status = 'Employee status: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $status);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['employeeStatus']);
                }

                if (isset($data['jobTitle']))
                {
                    $headerRow++;
                    $jobTitle = 'Employee job title: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $jobTitle);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['jobTitle']);
                }

                if (isset($data['subUnit']))
                {
                    $headerRow++;
                    $subUnit = 'Employee subunit: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $subUnit);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['subUnit']);
                }

                break;
            default:

                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace(' ', '_', strtolower($data['employee']));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['employee']);

                if (isset($data['timePeriod']))
                {
                    $headerRow++;
                    $timePeriod = 'Timesheet for period: ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $timePeriod);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $data['timePeriod']);
                }

                if (isset($data['status']))
                {
                    $headerRow++;
                    $statusData = explode(':', $data['status']);
                    $statusFor = $statusData[0] . ': ';
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $headerRow, $statusFor);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, trim($statusData[1]));
                }

                break;

        }

        $headerRow += 3;

        foreach($data['headers'] as $k => $v)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($k + 1, $headerRow, $v);
        }
        $headerRow++;

        foreach($data['rows'] as $k => $v)
        {
            foreach($v as $key => $column)
            {
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($key + 1, $headerRow, $column);
            }
            $headerRow ++;
        }

        foreach($data['footer'] as $k => $v)
        {
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($k + 1, $headerRow, $v);
        }


//        $styleArray = array(
//            'fill' => array(
//                'type' => Fill::FILL_SOLID,
//                'color' => array('rgb' => \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_DARKYELLOW )
//                //'background-color' => array('rgb' => 'FF9900' )
//            ),
//            'font' => array(
//                'name' => 'Arial',
//                'bold' => true,
////                'color' => array(
////                    'rgb' => 'white'
////                )
//            ),
//            'borders' => array(
//                'outline' => array(
//                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
//                    //'color' => array('rgb' => 'FF9900'),
//                ),
//            ),
//
//
//
//
////            'font' => [
////                'color' => 'FFFFFFFF',
////            ],
////            'borders' => [
////                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
////                'color' => 'FFFFFFFF'
////            ],
////            'fill' => [
////                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
////                'color' => 'ED7D31'
////            ],
//        );
//
//        foreach($data['headers'] as $k => $v)
//        {
//
//
//            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, 10)->applyFromArray($styleArray);
//
//
////            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, 10)
////                ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('#ED7D31');
//
//            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($k + 1, 10, $v);
//        }

        $newFileName = $fileName . '_' . time() . '.xlsx';
        $fileLocation = $root . '/' . $newFileName;
        $writer->save($fileLocation);

        return $this->renderJson(array('link' => $webRoot . 'reports/' . $newFileName, 'name' => $newFileName));
    }
}
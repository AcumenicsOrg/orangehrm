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

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $spreadsheet->getActiveSheet()->getStyle('B3:C3')
            ->getFont()->setBold(true);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");

        $headerRow = 3;
        switch($data['timesheetType'])
        {
            case 'Employee Report':

                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace(' ', '_', strtolower($data['employee']));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['employee']);
                //$headerRow++;
                break;
            case 'Project Report':

                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace('-', '_', str_replace(' ', '', strtolower($data['projectName'])));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['projectName']);
                $headerRow++;

                if (isset($data['dateRangeFrom']))
                {
                    $headerRow++;
                    $headerDateFrom = 'Project report from: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $headerDateFrom)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['dateRangeFrom'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $headerDateFrom);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['dateRangeFrom']);
                }
                if (isset($data['dateRangeTo']))
                {
                    $headerRow++;
                    $headerDateTo = 'Project report to: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $headerDateTo)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['dateRangeTo'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $headerDateTo);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['dateRangeTo']);
                }

                break;
            case 'Attendance Report':

                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace(' ', '_', strtolower($data['employee']));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['employee']);
                $headerRow++;

                if (isset($data['dateRangeFrom']))
                {
                    $headerRow++;
                    $headerDateFrom = 'Attendance report from: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $headerDateFrom)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['dateRangeFrom'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $headerDateFrom);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['dateRangeFrom']);
                }
                if (isset($data['dateRangeTo']))
                {
                    $headerRow++;
                    $headerDateTo = 'Attendance report to: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $headerDateTo)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['dateRangeTo'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $headerDateTo);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['dateRangeTo']);
                }

                if (isset($data['employeeStatus']))
                {
                    $headerRow++;
                    $status = 'Employee status: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $status)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['employeeStatus'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $status);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['employeeStatus']);
                }

                if (isset($data['jobTitle']))
                {
                    $headerRow++;
                    $jobTitle = 'Employee job title: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $jobTitle)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['jobTitle'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $jobTitle);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['jobTitle']);
                }

                if (isset($data['subUnit']))
                {
                    $headerRow++;
                    $subUnit = 'Employee subunit: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $subUnit)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $data['subUnit'])
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $subUnit);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['subUnit']);
                }

                break;
            default:

                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $spreadsheet->getActiveSheet()->getColumnDimension('D:K')->setWidth(8);

                $fileName = str_replace(' ', '_', strtolower($data['timesheetType'])) . '_' . str_replace(' ', '_', strtolower($data['employee']));

                $title = $data['timesheetType'] . ' for ';
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $title);
                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['employee']);
                $headerRow++;

                if (isset($data['timePeriod']))
                {
                    $headerRow++;
                    $timePeriod = 'Timesheet for period: ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $timePeriod)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, $timePeriod)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $timePeriod);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, $data['timePeriod']);
                }

                if (isset($data['status']))
                {
                    $headerRow++;
                    $statusData = explode(':', $data['status']);
                    $statusFor = $statusData[0] . ': ';
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(2, $headerRow, $statusFor)
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->getStyleByColumnAndRow(3, $headerRow, trim($statusData[1]))
                        ->getFont()->setBold(true);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $headerRow, $statusFor);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $headerRow, trim($statusData[1]));
                }

                break;

        }

        $headerRow += 2;

        foreach($data['headers'] as $k => $v)
        {
            $k++;
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, $headerRow)
                ->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, $headerRow)
                ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCE6F1');

            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($k + 1, $headerRow, $v);
        }
        $headerRow++;

        foreach($data['rows'] as $k => $v)
        {
            if ($data['timesheetType'] === 'Attendance Report')
            {
                $v[0] = $data['employee'];
            }

            if ($data['timesheetType'] != 'Attendance Report' && $data['timesheetType'] != 'Project Report' && $data['timesheetType'] != 'Employee Report')
            {
                $z = 1;
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($z + 10, $headerRow)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF9C373');
            }

            foreach($v as $key => $column)
            {
                $key++;
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($key + 3, $headerRow, $column)
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($key + 10, $headerRow, $column)
                    ->getFont()->setBold(true);

                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($key + 1, $headerRow, $column);
            }
            $headerRow ++;
        }

        foreach($data['footer'] as $k => $v)
        {
            $k++;
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, $headerRow)
                ->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 1, $headerRow)
                ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF9C373');
            $spreadsheet->getActiveSheet()->getStyleByColumnAndRow($k + 3, $headerRow)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

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
<?php
/**
 * Created by PhpStorm.
 * User: nenad
 * Date: 21.9.18.
 * Time: 14.17
 */

class TimesheetReportService
{
    private $headers;

    private $rows;

    private $footer;

    private $timeService = null;


    public function prepareIndividualTimesheetReport($dates, $rows, $timeService = null)
    {
        $this->timeService = $timeService;
        $this->setIndividualHeaders($dates);
        $tmpDates = $this->getTmpDays($dates);
        $this->getRowsWithDays($rows, $tmpDates);

        return array(
            'headers' => $this->headers,
            'rows' => $this->rows,
            'footer' => $this->footer
        );
    }



    private function getRowsWithDays ($rows, $tmpDates)
    {
        $totalByColumnArr = array();
        foreach($rows as $row)
        {
            $fields = array();
            $totalByRow = 0;
            foreach($this->headers as $k => $v)
            {
                if (isset($row[lcfirst(str_replace(' ','', $v))]))
                {
                    $fields[$k] = str_replace('##', '', $row[lcfirst(str_replace(' ','', $v))]);
                }
                if (array_key_exists($v, $tmpDates))
                {
                    if (!isset($totalByColumnArr[$v]))
                    {
                        $totalByColumnArr[$v] = 0;
                    }
                    $hours = ($row['timesheetItems'][$tmpDates[$v]]->getDuration() !== null) ? $row['timesheetItems'][$tmpDates[$v]]->getConvertTime() : '00:00';
                    $duration = ($row['timesheetItems'][$tmpDates[$v]]->getDuration() !== null) ? $row['timesheetItems'][$tmpDates[$v]]->getDuration() : 0;
                    $fields[$k] = $hours;
                    $totalByRow += (int)$duration;

                    $totalByColumnArr[$v] += (int)$duration;
                }
                if ($v === 'Total')
                {
                    if (!isset($totalByColumnArr[$v]))
                    {
                        $totalByColumnArr[$v] = 0;
                    }
                    $fields[$k] = ($this->timeService !== null) ? $this->timeService->convertDurationToHours($totalByRow) : $totalByRow;
                    $totalByColumnArr[$v] += $totalByRow;
                }
            }
            $this->rows[] = $fields;
        }
        $this->footer = array('Total','');
        foreach($totalByColumnArr as $elem)
        {
            $this->footer[] = ($this->timeService !== null) ? $this->timeService->convertDurationToHours($elem) : $elem;
        }
    }


    private function getTmpDays ($rowDates)
    {
        $tmpDates = array();
        foreach($rowDates as $rowDate)
        {
            $tmpDates[ __(date('D', strtotime($rowDate))) . ' ' . date('j', strtotime($rowDate))] = $rowDate;
        }
        return $tmpDates;
    }

    private function setIndividualHeaders($rowDates)
    {
        $this->headers = array('Project Name', 'Activity Name');
        foreach($rowDates as $rowDate)
        {
            $this->headers[] = __(date('D', strtotime($rowDate))) . ' ' . date('j', strtotime($rowDate));
        }
        $this->headers[] = 'Total';
    }
}
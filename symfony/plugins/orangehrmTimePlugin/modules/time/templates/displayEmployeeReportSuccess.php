<?php

if ($employeeReportsPermissions->canRead()) {
    include_component('core', 'ohrmList', $parmetersForListComponent);
}

//var_dump($parmetersForListComponent['listElementsData']->getRawValue()); die;

//var_dump(json_encode($parmetersForListComponent['listElementsData']->getRawValue())); die;

?>

<button id="generateReport">Report</button>


<script>

    $('#generateReport').on('click', function()
    {
        $.ajax({
            type: 'POST',
            url: '<?php echo url_for('time/generateTimesheetReporte'); ?>',
            data: JSON.stringify(<?php echo json_encode($parmetersForListComponent['listElementsData']->getRawValue()); ?>),
            headers: { 'Content-Type': 'application/json' },
            success: function (response)
            {
                // console.log(response.postData.employee);
                // console.log(response.postData.reportTitle);
                // console.log(response.postData.totalHours);
                // console.log(response.postData.headers);
                // console.log(response.postData.rows);

                console.log(response);

                alert('Uspesno')
            },
            error: function ()
            {
                alert('Neuspesno')
            },
        })
    })

</script>
$(document).ready(function() {



    $('#generateReport').on('click', function()
    {
        if (reportData.timesheetType === 'Employee Timesheet')
        {
            var timePeriod = null;
            var timeOptions = $('#startDates').find('OPTION');
            var timePeriodId = $('#startDates').val();

            $.each(timeOptions, function(k, v)
            {
                if ($(v).val() == timePeriodId)
                {
                    timePeriod = $(v).html();
                }
            });
            reportData.timePeriod = timePeriod;
        }

        $.ajax({
            type: 'POST',
            url: reportDataUrl,
            data: JSON.stringify(reportData),
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

});
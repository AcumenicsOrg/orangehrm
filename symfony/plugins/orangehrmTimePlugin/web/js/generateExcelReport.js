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
            var status = $('#timesheet_status').find('H2');
            if (status)
            {
                reportData.status = status.html();
            }
        }

        $.ajax({
            type: 'POST',
            url: reportDataUrl,
            data: JSON.stringify(reportData),
            headers: { 'Content-Type': 'application/json' },
            success: function (response)
            {
                var link = document.createElement("a");
                link.download = response.name;
                link.href = response.link;
                link.click();
            },
            error: function ()
            {
                alert('An error occurred while generating report. Please try later. ')
            },
        })
    })

});
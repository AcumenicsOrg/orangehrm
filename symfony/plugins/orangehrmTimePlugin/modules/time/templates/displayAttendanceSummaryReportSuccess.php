<?php echo javascript_include_tag(plugin_web_path('orangehrmTimePlugin', 'js/generateExcelReport')); ?>
<?php

if ($attendancePermissions->canRead()) {
    include_component('core', 'ohrmList', $parmetersForListComponent);
}
?>
<button id="generateReport">Report</button>

<script>

    var reportData = <?php echo json_encode($parmetersForListComponent['listElementsData']->getRawValue()); ?>;
    var reportDataUrl = '<?php echo url_for('time/generateTimesheetReporte'); ?>';

</script>

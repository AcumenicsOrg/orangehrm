<?php

if ($projectReportPermissions->canRead()) {
    include_component('core', 'ohrmList', $parmetersForListComponent);
}

//var_dump($parmetersForListComponent['listElementsData']->getRawValue()); die;

?>


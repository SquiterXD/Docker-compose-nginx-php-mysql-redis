<?php

if (! function_exists('get_locator_desc')) {
    function get_locator_desc($locatorId, $locators) {

        $locatorDesc = "";
        foreach($locators as $locator){
            if($locator->inventory_location_id == $locatorId){
                $locatorDesc = $locator->building_desc . ' ' . $locator->location_desc;
            }
        }

        return $locatorDesc;

    }
}
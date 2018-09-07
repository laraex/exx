<?php

namespace App\Traits;

trait LogActivity
{
    /**
     * Function to log activity
     * 
     * @param type $performed_on
     * @param type $caused_by
     * @param type $properties
     * @param type $message
     */
    public function doActivityLog($performed_on, $caused_by, $properties, $logname, $message) 
    {
        activity()
            ->performedOn($performed_on)
            ->causedBy($caused_by)
            ->withProperties($properties)
            ->useLog($logname)
            ->log($message);
    }
}
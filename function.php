<?php

function validateDate($strDate)
{
    date_default_timezone_set('UTC');
    $d = DateTime::createFromFormat("d-m-Y H:i:s", $strDate);
    
    return $d && ($d->format("d-m-Y H:i:s") == $strDate);
}

?>
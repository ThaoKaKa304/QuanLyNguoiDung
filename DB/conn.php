<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    
    $serverName = "THAOKAKA\SQL2012";
    $connectionInfo = array( "Database"=>"ChamCong", "UID"=>"sa", "PWD"=>"thaohihi304",  "CharacterSet"=>"UTF-8");
    $conn = sqlsrv_connect($serverName, $connectionInfo) or die("<div align='center'><a href='index.php'>Không kết nối được đến máy chủ, hãy thử lại sau ít phút >></a><br>Thanks!</div>"); 
?>

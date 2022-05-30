<?php
include 'DB/conn.php';
include 'function.php';
$imgFileName = "";
date_default_timezone_set('Asia/Ho_Chi_Minh');
if(isset($_POST["btnUploadImg"])) {
    $imgFileName = $_FILES['fUpload']["tmp_name"];
    $filename = date("ymdHisv").".";
    $filetype = pathinfo ($_FILES['fUpload']['name'], PATHINFO_EXTENSION);
    $target_dir = "uploads/";
    $target_file = $target_dir.$filename.$filetype;

    move_uploaded_file($_FILES['fUpload']["tmp_name"], $target_file);
}


function uploadimage($_images){
    $target_dir = "uploads/"; //đưa vào thư mục uploads của máy chủ
    $target_file = $target_dir . basename($_images["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["btnUploadImg"])) {
        $check = getimagesize($_images["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_images["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return FALSE;
    } 
    else {
        if (move_uploaded_file($_images["tmp_name"], $target_file)) {
            return $_images["name"];
        } else {
            return FALSE;
            }
        }
    
}

$msgError = "";

$pagerows=10;
$pagenum=1;
$dtTimeBegin = "00:00:01";
$dtTimeEnd = "23:59:00";
$dtdaybegin = date("Y-m-d")." ".$dtTimeBegin;
$dtdayend = date("Y-m-d")." ".$dtTimeEnd;
$dtbegin = DateTime::createFromFormat('Y-m-d H:i:s', $dtdaybegin)->format('d-m-Y');
$dtend = DateTime::createFromFormat('Y-m-d H:i:s', $dtdayend)->format('d-m-Y');

if(isset($_REQUEST["btnRead"])){
    $pagerows = (int)$_POST["txtRows"];
    $pagenum = (int)$_POST["txtNum"];

    $dtTimeBegin = isset($_POST["dtTimeBegin"])?$_POST["dtTimeBegin"]:time("H:i:s");
    if (substr($dtTimeBegin, 0, 2) == "0:") {
        $dtTimeBegin = "0".$dtTimeBegin;

    }
    $dtTimeEnd = isset($_POST["dtTimeEnd"])?$_POST["dtTimeEnd"]:time("H:i:s");
    if (substr($dtTimeEnd, 0, 2) == "0:") {
        $dtTimeEnd = "0".$dtTimeEnd;

    }
    
    $dtdaybegin = isset($_POST["dtDayBegin"])?$_POST["dtDayBegin"]:date("d-m-Y");
    $dtbegin = $dtdaybegin;
    $dtdaybegin = $dtdaybegin." ".$dtTimeBegin;
    
    $dtdayend = isset($_POST["dtDayEnd"])?$_POST["dtDayEnd"]:date("d-m-Y");
    $dtend = $dtdayend;
    $dtdayend = $dtdayend." ".$dtTimeEnd;
    
    if(validateDate($dtdaybegin) == false) {
            
        $msgError =  "$msgError<br>Bạn đã nhập sai ngày ở Day From" ;
        //$dtbegin = $dtdaybegin;
        $dtdaybegin = date("Y-m-d")." ".$dtTimeBegin;
    }
    else {
        
        $dtdaybegin = DateTime::createFromFormat('d-m-Y H:i:s', $dtdaybegin)->format('Y-m-d H:i:s');
        $dtbegin = DateTime::createFromFormat('Y-m-d H:i:s', $dtdaybegin)->format('d-m-Y');
    }
    if(validateDate($dtdayend) == false) {
        $msgError =  "$msgError<br>Bạn đã nhập sai ngày ở To " ;
        //$dtend = $dtdayend;
        $dtdayend = date("Y-m-d")." ".$dtTimeEnd;

    }
    else {
        $dtdayend = DateTime::createFromFormat('d-m-Y H:i:s', $dtdayend)->format('Y-m-d H:i:s');
        $dtend = DateTime::createFromFormat('Y-m-d H:i:s', $dtdayend)->format('d-m-Y');
    }
       
    
    

    
}
$rownum1= $pagerows * ($pagenum - 1) + 1;
$rownum2 = $rownum1 + $pagerows -1;




?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>Chấm Công</title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/theme.css" />
    <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES --> 

    <!-- PAGE LEVEL STYLES -->
    
<link href="assets/css/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/plugins/uniform/themes/default/css/uniform.default.css" />
<link rel="stylesheet" href="assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
<link rel="stylesheet" href="assets/plugins/chosen/chosen.min.css" />
<link rel="stylesheet" href="assets/plugins/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="assets/plugins/tagsinput/jquery.tagsinput.css" />
<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" href="assets/plugins/datepicker/css/datepicker.css" />
<link rel="stylesheet" href="assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="assets/plugins/switch/static/stylesheets/bootstrap-switch.css" />
<link rel="stylesheet" href="assets/css/bootstrap-fileupload.min.css" />
   
    <!-- END PAGE LEVEL  STYLES -->
     <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }
        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }
    </style>
</head>

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<form action="" method="post" enctype="multipart/form-data">

<body class="padTop53 " >

<div class="row">
    <div class="col-md-2">
        
    </div>
    <div class="col-md-8" style ="text-align: center;">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?act=update">Update</a></li>
            <li><a href="index.php?act=contact">Contact</a></li>
            <li><a href="index.php?act=login">Login</a></li>
        </ul>
    </div>
    <div class="col-md-2">

    </div> 
</div>
<br><br>
<div class = "row">
    <div >        
        <div class="col-lg-12" style="text-align: center;">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                
                <div>
                    <span class="btn btn-file btn-success"><span class="fileupload-new" > <i class="icon-camera"></i></span>
                    <span class="fileupload-exists"><i class="icon-refresh"></i></span>
                        <input type="file" name ="fUpload" id ="fUpload" />
                    </span>
                    <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-trash"></i></a>
                </div>
                <br>
                <div>
                    <button class="btn btn-primary" name='btnUploadImg'><i class="icon-ok"> </i>Upload</button>

                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $imgFileName; ?>

<br><br><hr>
<div class ="row">
        <div class="col-md-4">
            <div class="form-group">
                    <div class="col-md-9" style="text-align: right;">
                        Page Rows
                    </div>
                    <div class="col-md-3" style="text-align: left;">
                        <input type="text" name='txtRows'  style="text-align: center;" value="<?php echo $pagerows; ?>" class="form-control">
                    </div>
                    
                    
            </div>
            
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="col-md-9" style="text-align: right;">
                    Page Num
                </div>
                <div class="col-md-3" style="text-align: left;">
                    <input type="text" name='txtNum' style="text-align: center;" value="<?php echo $pagenum; ?>" class="form-control" >
                </div>
                
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12" style="text-align: center;">
                <button class="btn btn-primary" name='btnRead'><i class="icon-ok"></i> Read</button>

            </div>
        </div>
</div> 


<div class ="row"> 
        <div class ="col-md-3"> 
            <div id="datePickerBlock" class="body collapse in">

                    <div class="form-group">
                        <label class="control-label col-lg-6" style="text-align: right;" >Day From</label>

                        <div class="col-lg-6">
                            <div class="input-group input-append date" id="dp3" data-date="<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $dtdaybegin)->format('d-m-Y H:i:s'); ?>"
                                        data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" name="dtDayBegin" value="<?php echo $dtbegin; ?>"  />
                                        <span class="input-group-addon add-on"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                    </div>
            </div>        
        </div>

        <div class = "col-md-2">
            <div class="form-group">
                <br>
                <div class="input-group bootstrap-timepicker" data-time-format="H:m:s">
                    <input class="timepicker-24 form-control" type="text" name = "dtTimeBegin" value ="<?php echo $dtTimeBegin; ?>" />
                    <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                </div>
            </div>
        </div>
        <div class = "col-md-1"></div>
        
        <div class ="col-md-3"> 
        <div id="datePickerBlock" class="body collapse in">
                <div class="form-group">
                    <label class="control-label col-lg-6" style="text-align: right;" >To</label>

                    <div class="col-lg-6">
                            <div class="input-group input-append date" id="dp4" data-date="<?php echo DateTime::createFromFormat('Y-m-d H:i:s', $dtdayend)->format('d-m-Y H:i:s'); ?>"
                                        data-date-format="dd-mm-yyyy">
                                        <input class="form-control" type="text" name="dtDayEnd" value="<?php echo $dtend; ?>"  />
                                        <span class="input-group-addon add-on"><i class="icon-calendar"></i></span>
                            </div>
                        </div>
                </div>
        </div>
        </div>
        <div class ="col-md-3">
            <div class="form-group">  
                <br>                      
                <div class="col-lg-6">
                    <div class="input-group bootstrap-timepicker" data-time-format="HH:mm:ss">
                        <input class="timepicker-24 form-control" type="text" name = "dtTimeEnd" value = "<?php echo $dtTimeEnd; ?>" />
                        <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                    </div>
                </div>
            </div>
        </div>
</div>
<br>
<div class = "row">
    
        <div class="col-md-12" style="text-align: center;font-weight: bold; color:Red; "  >
            <?php echo $msgError; ?>
        </div>
    
</div>
<br><br>
 
<?php
$sql = "exec spChamCong7  '$dtdaybegin', '$dtdayend', $rownum1, $rownum2";
$rs = sqlsrv_query($conn, $sql);

?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>TT</th>
                                            <th>Mã số</th>
                                            <th>Thời gian</th>
                                            <th>Mã máy</th>
                                            <th>Họ tên</th>
                                            <th>Mã đơn vị</th>
                                            <th>Tên máy</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $tt = 0;
                                        while($rs && $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
                                            $tt = $tt+1;


                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $tt; ?></td>
                                            <td><?php echo $row["MaSo"]; ?></td>
                                            <td><?php echo $row["ThoiGian"]->format('d-m-Y H:i:s'); ?></td>
                                            <td class="center"><?php echo $row["MaMay"]; ?></td>
                                            <td class="center"><?php echo $row["HoTen"]; ?></td>
                                            <td><?php echo $row["MaDonVi"]; ?></td>
                                            <td><?php echo $row["TenMay"]; ?></td>
                                            
                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
    </div>
            
    
    
     <!-- GLOBAL SCRIPTS -->
     <script src="assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->


      <!-- PAGE LEVEL SCRIPT-->
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/plugins/uniform/jquery.uniform.min.js"></script>
<script src="assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="assets/plugins/chosen/chosen.jquery.min.js"></script>
<script src="assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script src="assets/plugins/validVal/js/jquery.validVal.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/daterangepicker/moment.min.js"></script>
<script src="assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/plugins/timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>
<script src="assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js"></script>
<script src="assets/plugins/autosize/jquery.autosize.min.js"></script>
<script src="assets/plugins/jasny/js/bootstrap-inputmask.js"></script>
       <script src="assets/js/formsInit.js"></script>
        <script>
            $(function () { formInit(); });
        </script>
        

     <script>
         $(document).ready(function () {
             $('#tabContacts').dataTable();
         });
    </script>
<script src="assets/plugins/jasny/js/bootstrap-fileupload.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->


</body>
</form> 

    <!-- END BODY -->
</html>
<?php
include_once 'DB/conn_close.php'
?>
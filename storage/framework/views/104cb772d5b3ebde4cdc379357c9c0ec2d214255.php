<!DOCTYPE html>
<html>
<head>
	<title>Okapi</title>
	<meta charset="UTF-8">
	<meta name="keywords" content="cleaning, home">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--css-->
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public')); ?>/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public')); ?>/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public')); ?>/css/responsive.css">
	<!--font awesome 4-->
	<link rel="stylesheet" type="text/css" href="fonts/fontawesome/css/all.min.css">
	<!--data table-->
	<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.css">
</head>
<body>
	<?php $__env->startSection('content'); ?><?php echo $__env->yieldSection(); ?>
<!--script-->
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/bootstrap.min.js"></script>
<!--data table-->
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/custom.js"></script>

<script type="text/javascript">
	$('[data-toggle="tooltip"]').tooltip();
</script>
<script type="text/javascript">
	    $( document ).ready(function() {
        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){
              //console.log(position);
              var currentLatitude = position.coords.latitude;
              var currentLongitude = position.coords.longitude;
              $('body form [name="latitude"]').val(currentLatitude);
              $('body form [name="longitude"]').val(currentLongitude);
              //position[0].address_components[0]
                 if(addressData == ''){
                   initializeCurrent(currentLatitude,currentLongitude)
                 }
            });
        }else{
            console.log("i am not acivate");
        }
        });
</script>
</body>
</html>
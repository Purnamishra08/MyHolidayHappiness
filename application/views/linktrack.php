<!DOCTYPE html>
<html>
    <head>
       <?php include("head.php"); ?>
    </head>
    <body>

        <?php include("header.php"); ?>
		
		<div class="container mt60 mb100 text-center">
			<div class="row text-center">
				<div class="col-sm-12 text-center "><h4 class="successmsg"><?php echo $message; ?></h4></div>
				<?php
					if($message == "success")
					{
				?>
						<div class="col-sm-12 text-center "><h4 class="successmsg"><i class="fa fa-check"></i> Your email id has been verified successfully.</h4></div>
				<?php
					}
					else if($message == "error")
					{
				?>
					<div class="col-sm-12 text-center "><h4 class="errormsg"><i class="fa fa-times"></i> Unable to process your request.</h4></div>
				<?php
					}
				?>
				<div class="col-sm-12 controls text-center "><a href="https://myholidayhappiness.com/login" class="sign-up-btm">Click Here To Login</a></div>
			</div>
		</div>			

        <?php include("footer.php"); ?> 

    </body>
</html>


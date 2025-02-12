<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("head.php"); ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <?php include("header.php"); ?>

            <?php include("sidemenu.php"); ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="header-icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                    <div class="header-title">
                        <h1>Admin Dashboard</h1>
                        <small>Dashboard</small>
                    </div>
                </section>

             
                <section class="content"> 
                    <div class="admin-panel-txt"> Welcome to Holidays</div>
                    <div class="row">
                     
                    </div>
                </section>             
            </div>
            <?php include("footer.php"); ?>

            <script>
				$(function () {
					$('.datepicker').datepicker({
						format: 'dd/mm/yyyy',
						todayHighlight: true,
						autoclose: true,
					});
				});
			</script>
    </body>
</html>


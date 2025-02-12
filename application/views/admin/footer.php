<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">Holidays</a>.</strong> All rights reserved.
</footer>
</div>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery-1.12.4.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.slimscroll.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<!--script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script--> 
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dashboard.js" type="text/javascript"></script>
<!-- <script src="<?php //echo base_url(); ?>assets/admin/js_validation/additional-methods.min.js"></script> -->
<script>var base_url = "<?php echo base_url(); ?>"; </script>
<script type="text/javascript">
$('#search_form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
</script>



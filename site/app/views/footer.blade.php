<!-- BEGIN FOOTER -->
<div class="page-footer" style="text-align:center">
  <div class="page-footer-inner">
     2015 &copy; Avyay Technologies.
  </div>
  <div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
  </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script type="text/javascript">
  var base_url = '{{URL::to('/')}}';
</script>
{{HTML::script("assets/global/plugins/jquery-migrate.min.js")}}
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
{{HTML::script("assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js")}}
{{HTML::script("assets/global/plugins/bootstrap/js/bootstrap.min.js")}}
<!-- {{HTML::script("assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js")}} -->
{{HTML::script("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")}}
<!-- {{HTML::script("assets/global/plugins/jquery.blockui.min.js")}} -->
<!-- {{HTML::script("assets/global/plugins/jquery.cokie.min.js")}} -->
{{HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")}}
{{HTML::script("assets/global/plugins/bootbox/bootbox.min.js")}}
<!-- END CORE PLUGINS -->
{{HTML::script("assets/global/scripts/metronic.js")}}
{{HTML::script("assets/admin/scripts/layout.js")}}
{{HTML::script("assets/admin/scripts/quick-sidebar.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.pager.js")}}
{{HTML::script("assets/admin/scripts/jquery.tablesorter.widgets.js")}}
{{HTML::script("assets/admin/scripts/jquery.validate.js")}}
{{HTML::script("assets/admin/scripts/additional-methods.min.js")}}
{{HTML::script("assets/admin/scripts/jquery.floatThead.min.js")}}
{{HTML::script("assets/admin/scripts/dropzone.js")}}
{{HTML::script("assets/admin/scripts/custom.js")}}
<script>
jQuery(document).ready(function() {   
   // initiate layout and plugins
  Metronic.init(); // init metronic core components
  Layout.init(); // init current layout
  QuickSidebar.init(); // init quick sidebar
});
</script>

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
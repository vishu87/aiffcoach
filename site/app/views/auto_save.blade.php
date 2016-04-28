<script type="text/javascript">
var auto_save = 0;

$("textarea").keyup(function(){
  auto_save = 1;
});

setInterval(AutoSave, 15000);

function AutoSave(){
  if(auto_save == 1){
    var d = new Date();
    $(".auto-save").trigger("click");
    $(".auto-save-result").html('Last auto saved at '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds());
    auto_save = 0;
  }
}
</script>
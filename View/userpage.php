<?php require_once "../libraries/constant.php";?>
<script src="<?php echo WEBSITEPATH; ?>js/jquery.tools.min.js"></script>
<script src="<?php echo WEBSITEPATH; ?>js/functions.js"></script>
<script>
var struser;
var strrole;
$(document).ready(function() {
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=findusers',
        //data: $("#idForm").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#output").html($.trim(data));
            //alert(data); // show response from the php script.
        }
      });

	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=rolefetch',
        //data: $("#idForm").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#output1").html($.trim(data));
            //alert(data); // show response from the php script.
        }
      });
});

/*
function submituser()
{
	struser = $("#user option:selected").val();
	strrole = $("#role option:selected").val();
	
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=adduser&user='+struser+'&role='+strrole,
        data: $("#frmid").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#output2").html($.trim(data));
            //alert(data); // show response from the php script.
        }
      });
}
*/

</script>
<html>
<div id="output1"></div>
<br/>
<br/>
<br/>
<div id="output"></div>
<br/>
<br/>
<br/>
<div id="output2"></div>
<br/>
<br/>
<br/>
<div id="output3"></div>
</html>

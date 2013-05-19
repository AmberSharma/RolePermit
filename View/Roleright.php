<?php require_once "../libraries/constant.php";?>
<script src="<?php echo WEBSITEPATH; ?>js/jquery.tools.min.js"></script>
<script src="<?php echo WEBSITEPATH; ?>js/functions.js"></script>

<script>
var strUser;

$(document).ready(function() {
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=findrole',
        //data: $("#idForm").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#output").html($.trim(data));
            //alert(data); // show response from the php script.
        }
      });
});




</script>

<html>
<div id="output"></div>
<br/>
<br/>
<br/>
<div id="output1"></div>
<br/>
<br/>
<br/>
<div id="output2"></div>
</html>

function findscreens()
{
	strUser = $("#role option:selected").val();
	
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=findscreen&role='+strUser,
        //data: $("#idForm").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#output1").html($.trim(data));
            //alert(data); // show response from the php script.
        }
      });
}
function assign()
{
	
	
	$.ajax({
        type: "POST",
        url: '../controller/controller.php?method=assignselection',
        data: $("#frmid").serialize(), // serializes the form's elements.
        success: function(data)
        {
            $("#output2").html($.trim(data));
            //alert(data); // show response from the php script.
        }
      });
}



function fetchrole()
{
	$.ajax
	({
	        type: "POST",
	        url: '../controller/controller.php?method=fetchroles&user='+struser,
	        //data: $("#frmid").serialize(), // serializes the form's elements.
	        success: function(data)
	        {
			$("#output2").html($.trim(data));
			//alert(data); // show response from the php script.
	        }
	});
}


function addrole()
{
	$.ajax
	({
	        type: "POST",
	        url: '../controller/controller.php?method=addrole&user='+struser+"&role="+strrole,
	        //data: $("#frmid").serialize(), // serializes the form's elements.
	        success: function(data)
	        {
			$("#output2").html($.trim(data));
			//alert(data); // show response from the php script.
	        }
	});
}

function deleterole()
{
	$.ajax
	({
	        type: "POST",
	        url: '../controller/controller.php?method=deleterole&user='+struser,
	        //data: $("#frmid").serialize(), // serializes the form's elements.
	        success: function(data)
	        {
			$("#output2").html($.trim(data));
			//alert(data); // show response from the php script.
	        }
	});
}

function deletedefault()
{
	$.ajax
	({
	        type: "POST",
	        url: '../controller/controller.php?method=deletedefault&user='+struser,
	        //data: $("#frmid").serialize(), // serializes the form's elements.
	        success: function(data)
	        {
			$("#output2").html($.trim(data));
			//alert(data); // show response from the php script.
	        }
	});
}


function setuser()
{
	struser = $("#user option:selected").val();
	//fetchscreen();
	
}
function setrole()
{
	strrole = $("#role option:selected").val();
}

function addpermissionform()
{
	$.ajax
	({
	        type: "POST",
	        url: '../controller/controller.php?method=addpermissionform',
	        success: function(data)
	        {
			$("#output3").html($.trim(data));
	        }
	});
	
}

function addpermission()
{
	$.ajax
	({
	        type: "POST",
	        url: '../controller/controller.php?method=addpermission&user='+struser+"&role="+strrole,
	        data: $("#frmid").serialize(), // serializes the form's elements.
	        success: function(data)
	        {
			$("#output3").html($.trim(data));
			//alert(data); // show response from the php script.
	        }
	});
}

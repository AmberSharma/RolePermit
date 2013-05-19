<?php
		echo "<form id='frmid' method='post' action='assign.php'>";
		echo "<table border='1'>";
		echo "<tr>";
		echo "<td>Screen Name</td>";
		echo "<td><input type='checkbox'  id='addall' class='case'/>ADD</td>";
		echo "<td><input type='checkbox'  id='editall'/>EDIT</td>";
		echo "<td><input type='checkbox'  id='deleteall'/>DELETE</td>";
		echo "<td><input type='checkbox'  id='viewall'/>VIEW</td>";
		echo "</tr>";
		echo "<input type='hidden' value='".$_REQUEST['role']."' name='role' />";
		$j=0;
		 for($i =0 ; $i < count($fetch['screens']) ; $i++)
		{
			$k=0;
			if(isset($fetch['permission'][$i]))
			{
			$permission=explode(",", $fetch['permission'][$i]['permit']);
			
			
			}
			else 
			{
				$permission = array('','','','');
			}
			echo "<br/>";
			$j++;
			echo "<tr>";
			echo "<td>".$fetch['screens'][$i]['name']."</td>";
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='add[".$i."]' value=".$j." class='case1' checked='checked'/></td>";
				$k++;		
			}
			else
			{
				if(isset($permission[$k]))
				{
					echo "<td><input type='checkbox' name='add[".$i."]' value=".$j." class='case1' /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='edit[".$i."]' value=".$j." class='case2' checked='checked'/></td>";
				$k++;
			}
			else
			{
				if(isset($permission[$k]))
				{
				echo "<td><input type='checkbox' name='edit[".$i."]' value=".$j." class='case2' /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='delete[".$i."]' value=".$j." class='case3' checked='checked'/></td>";
				$k++;
			}
			else
			{
				if(isset($permission[$k]))
				{
					echo "<td><input type='checkbox' name='delete[".$i."]' value=".$j." class='case3'/></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				
				echo "<td><input type='checkbox' name='view[".$i."]' value=".$j." class='case4' checked='checked'/></td>";
				$k++;
			}
			else 
			{
				if(isset($permission[$k]))
				{
				echo "<td><input type='checkbox' name='view[".$i."]' value=".$j." class='case4' /></td>";
				}
				$k++;
			}
				echo "</tr>";
		} 
		echo "<tr>";
		echo "<td colspan='5' style='border:0px;'>";
		echo "<input type='button' value='Assign' onclick='assign()' />";
		echo "</td>";
		echo "</tr>";
		echo "</form>";
		
		
		echo "</table>";
?>
<SCRIPT language="javascript">
$(function()
{
	
	$("#addall").click(function ()
	{
		$('.case1').attr('checked', this.checked);
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".case1").click(function()
	{
		if($(".case1").length == $(".case1:checked").length) 
		{
			$("#addall").attr("checked", "checked");
		}
		else 
		{
			$("#addall").removeAttr("checked");
		}
	});


	$("#editall").click(function ()
	{
		$('.case2').attr('checked', this.checked);
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".case2").click(function()
	{
		if($(".case2").length == $(".case2:checked").length) 
		{
			$("#editall").attr("checked", "checked");
		}
		else 
		{
			$("#editall").removeAttr("checked");
		}
	});


	$("#deleteall").click(function ()
	{
		$('.case3').attr('checked', this.checked);
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".case3").click(function()
	{
		if($(".case3").length == $(".case3:checked").length) 
		{
			$("#deleteall").attr("checked", "checked");
		}
		else 
		{
			$("#deleteall").removeAttr("checked");
		}
	});

	
	$("#viewall").click(function ()
	{
		$('.case4').attr('checked', this.checked);
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".case4").click(function()
	{
		if($(".case4").length == $(".case4:checked").length) 
		{
			$("#viewall").attr("checked", "checked");
		}
		else 
		{
			$("#viewall").removeAttr("checked");
		}
	});
});
</SCRIPT>

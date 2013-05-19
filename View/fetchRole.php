<?php
echo "Select Role:<select name='rolename' id='role' onchange='findscreens()'>";
echo "<option value='-1'>---Select---</option>";
for($i =0 ; $i < count($fetch) ; $i++)
{
   	echo "<option value='" . $fetch[$i]['id'] ."'>" . $fetch[$i]['role'] ."</option>";
}
echo "</select>";


?>

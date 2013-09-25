<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h3>User Approval</h3>
<form name="User_Approval" method="post" action="/Admin/approval" class="form-horizontal">
	<select name="UserApproval" id="UserApproval">
		<option value="All" <?php if($UserApproval=='All'){echo " selected";}?>>All</option>
		<optgroup label="Verified">		
		<option value="VEmail" <?php if($UserApproval=='VEmail'){echo " selected";}?>>Email</option>
		<option value="VPhone" <?php if($UserApproval=='VPhone'){echo " selected";}?>>Mobile/Phone</option>		
		<option value="VBank" <?php if($UserApproval=='VBank'){echo " selected";}?>>Bank Account</option>				
		<option value="VGovernment" <?php if($UserApproval=='VGovernment'){echo " selected";}?>>Government ID</option>				
		<option value="VUtility" <?php if($UserApproval=='VUtility'){echo " selected";}?>>Utility Bill</option>				
		</optgroup>
		<optgroup label="Not Verified">		
		<option value="NVEmail" <?php if($UserApproval=='NVEmail'){echo " selected";}?>>Email</option>
		<option value="NVPhone" <?php if($UserApproval=='NVPhone'){echo " selected";}?>>Mobile/Phone</option>		
		<option value="NVBank" <?php if($UserApproval=='NVBank'){echo " selected";}?>>Bank Account</option>				
		<option value="NVGovernment" <?php if($UserApproval=='NVGovernment'){echo " selected";}?>>Government ID</option>				
		<option value="NVUtility" <?php if($UserApproval=='NVUtility'){echo " selected";}?>>Utility Bill</option>				
		</optgroup>
		<optgroup label="Waiting Verification">		
		<option value="WVEmail" <?php if($UserApproval=='WVEmail'){echo " selected";}?>>Email</option>
		<option value="WVPhone" <?php if($UserApproval=='WVPhone'){echo " selected";}?>>Mobile/Phone</option>		
		<option value="WVBank" <?php if($UserApproval=='WVBank'){echo " selected";}?>>Bank Account</option>				
		<option value="WVGovernment" <?php if($UserApproval=='WVGovernment'){echo " selected";}?>>Government ID</option>				
		<option value="WVUtility" <?php if($UserApproval=='WVUtility'){echo " selected";}?>>Utility Bill</option>				
		</optgroup>
	</select>
		<input type="text" name="UserSearch" id="UserSearch" placeholder="Username" value="" class="span2">
		<input type="text" name="EmailSearch" id="EmailSearch" placeholder="Email" value="" class="span2">		
	<input type="submit" value="Go..." class="btn btn-primary ">
</form>
<table class="table table-condensed table-bordered table-hover" style=" ">
	<tr>
		<th style="text-align:center;"><?=$t("Username")?></th>
		<th style="text-align:center "><?=$t("Email")?></th>
		<th style="text-align:center "><?=$t("Mobile")?></th>
		<th style="text-align:center "><?=$t("Bank")?></th>		
		<th style="text-align:center "><?=$t("Government ID")?></th>				
		<th style="text-align:center "><?=$t("Proof of address")?></th>				
	</tr>
<?php 
if(count($details)!=0){
	foreach($details as $detail){
?>
	<tr>
		<td><a href="/Admin/detail/<?=$detail['username']?>" target="_blank"><?=$detail['username']?></a></td>
		<td style="text-align:center "><?=$detail['email.verified']?></td>		
		<td style="text-align:center "><?=$detail['phone.verified']?></td>				
		<td style="text-align:center "><a href="/Admin/detail/<?=$detail['username']?>"><?=$detail['bank.verified']?></a></td>						
		<td style="text-align:center "><a href="/Admin/approve/government/<?=$detail['_id']?>" target="_blank"><?=$detail['government.verified']?></a></td>						
		<td style="text-align:center "><a href="/Admin/approve/utility/<?=$detail['_id']?>" target="_blank"><?=$detail['utility.verified']?></a></td>								
	</tr>
<?php 	}
} ?>
</table>

</div>
<?php   
$searchUser = '';
$totalUsers = $iN->iN_TotalUsers();
$totalPages = ceil($totalUsers / $paginationLimit); 
if (isset($_GET["page-id"])) { 
    $pagep  = mysqli_real_escape_string($db, $_GET["page-id"]); 
    if(preg_match('/^[0-9]+$/', $pagep)){
        $pagep = $pagep;
    }else{
        $pagep = '1';
    }
}else{
    $pagep = '1';
} 
if(isset($_GET['sr'])){
   $searchUser = mysqli_real_escape_string($db, $_GET['sr']);
}
?>
<div class="i_contents_container">
    <div class="i_general_white_board border_one column flex_ tabing__justify">
        <!---->
        <div class="i_general_title_box">
          <?php echo filter_var($LANG['manage_users'], FILTER_SANITIZE_STRING).'('.$totalUsers.')';?>
        </div>
        <!----> 
        <!---->
        <div class="i_general_row_box column flex_" id="general_conf" style="padding-top:30px;">  
        <!--NewColumns-->
        <!---->
        <div class="i_contents_section flex_ tabing" style="margin-bottom:30px;">
            <!---->
            <div class="row_wrapper">
                <div class="row_item flex_ column border_one c1">
                    <div class="chart_row_box_title flex_ tabing_non_justify"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('12'));?><?php echo filter_var($LANG['male'], FILTER_SANITIZE_STRING);?></div>
                    <div class="chart_row_box_sum"><span class="count-num"><?php echo filter_var($iN->iN_GetTotalUserByGender($userID,'male'), FILTER_SANITIZE_STRING);?></span></div>
                </div>
            </div>
            <!---->
            <!---->
            <div class="row_wrapper">
                <div class="row_item flex_ column border_one c2">
                    <div class="chart_row_box_title flex_ tabing_non_justify"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('13'));?><?php echo filter_var($LANG['female'], FILTER_SANITIZE_STRING);?></div>
                    <div class="chart_row_box_sum"><span class="count-num"><?php echo filter_var($iN->iN_GetTotalUserByGender($userID,'female'), FILTER_SANITIZE_STRING);?></span></div>
                </div>
            </div>
            <!---->
            <!---->
            <div class="row_wrapper">
                <div class="row_item flex_ column border_one c3">
                    <div class="chart_row_box_title flex_ tabing_non_justify"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('15'));?><?php echo filter_var($LANG['active_users'], FILTER_SANITIZE_STRING);?></div>
                    <div class="chart_row_box_sum"><span class="count-num"><?php echo filter_var($iN->iN_GetTotalEmailVerifiedUsers($userID,'yes'), FILTER_SANITIZE_STRING);?></span></div>
                </div>
            </div>
            <!---->
            <!---->
            <div class="row_wrapper">
                <div class="row_item flex_ column border_one c4">
                    <div class="chart_row_box_title flex_ tabing_non_justify"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('129'));?><?php echo filter_var($LANG['inactive_users'], FILTER_SANITIZE_STRING);?></div>
                    <div class="chart_row_box_sum"><span class="count-num"><?php echo filter_var($iN->iN_GetTotalEmailVerifiedUsers($userID,'no'), FILTER_SANITIZE_STRING);?></span></div>
                </div>
            </div>
            <!---->
        </div>
        <!---->
        <div class="i_contents_section flex_" style="margin-bottom:30px;">
        
            <div class="irow_box_right" style="width:auto;padding-left:0px;">
                <div class="rec_not" style="padding-left:10px;padding-bottom:10px;"><?php echo filter_var($LANG['search_for_user'], FILTER_SANITIZE_STRING);?></div>
                <input type="text" class="i_input flex_" id="srcMe" value="<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>">
            </div>
            <div class="irow_box_right flex_ tabing" style="width:auto;padding-top: 25px;padding-left: 13px;">
                <div class="i_nex_btn_btn search_vl"><?php echo filter_var($LANG['search'], FILTER_SANITIZE_STRING);?></div>
            </div>
        </div>
        <!--/NewColumns-->

        <div class="warning_"><?php echo filter_var($LANG['noway_desc'], FILTER_SANITIZE_STRING);?></div>
        <?php 
        $allUsers = $iN->iN_AllTypeOfUsersList($userID, $paginationLimit, $pagep,$searchUser);
        if($allUsers){ 
        ?> 
        <div style="overflow-x:auto;">
            <table class="border_one">
                <tr>
                    <th><?php echo filter_var($LANG['id'], FILTER_SANITIZE_STRING);?></th>
                    <th><?php echo filter_var($LANG['user'], FILTER_SANITIZE_STRING);?></th> 
                    <th><?php echo filter_var($LANG['user_type'], FILTER_SANITIZE_STRING);?></th> 
                    <th><?php echo filter_var($LANG['registered_time'], FILTER_SANITIZE_STRING);?></th> 
                    <th><?php echo filter_var($LANG['user_creator_type'], FILTER_SANITIZE_STRING);?></th> 
                    <th><?php echo filter_var($LANG['verification_status'], FILTER_SANITIZE_STRING);?></th>   
                    <th><?php echo filter_var($LANG['actions'], FILTER_SANITIZE_STRING);?></th>   
                </tr>
        <?php 
        foreach($allUsers as $uData){
            $iuID = $uData['iuid']; 
            $userUserName = $uData['i_username'];
            $userUserFullName = $uData['i_user_fullname'];
            $userAvatar = $iN->iN_UserAvatar($iuID, $base_url); 
            $userRegisteredTime = $uData['registered'];
            $crTime = date('Y-m-d H:i:s',$userRegisteredTime);  
            $userUserType = $uData['userType'];
            $userGender = $uData['user_gender'];
            $userStatus = $uData['uStatus'];
            $checkFakeUserStatus = isset($uData['fake_user_status']) ? $uData['fake_user_status'] : NULL;
            $userCreatorCategory = isset($uData['profile_category']) ? $uData['profile_category'] : NULL;
            $seeEditProfile = $base_url.'admin/manage_users?user='.$iuID;
            $seeProfile = $base_url.$userUserName;
            $userFeeStatus = isset($uData['validation_status']) ? $uData['validation_status'] : NULL;
            $userCertificationStatus = isset($uData['certification_status']) ? $uData['certification_status'] : NULL;
            $utyp = '<div class="ut tabing flex_ forNormalUser">'.$iN->iN_SelectedMenuIcon('83').$LANG['normal_user'].'</div>';
            if($userUserType == '2'){
                $utyp = '<div class="ut tabing flex_ forpremiums">'.$iN->iN_SelectedMenuIcon('121').$LANG['admin'].'</div>';
            }
            $cType =  '-';
            if($userCreatorCategory){
              $cType = '<div class="i_creator_category flex_ tabing">'.$iN->iN_SelectedMenuIcon('65').$PROFILE_CATEGORIES[$userCreatorCategory].'</div>';
            }
            $verificationStat = '';
            if($userCertificationStatus == '2'){
              $verificationStat = '<div class="ut tabing flex_ forsubs">'.$iN->iN_SelectedMenuIcon('9').$LANG['premium_user'].'</div>';
            }else if($userFeeStatus == '1'){
              $verificationStat = '<div class="ut tabing flex_ forpending" style="background-color:blue;">'.$iN->iN_SelectedMenuIcon('115').$LANG['verification_pending'].'</div>';
            }
            $vRData = $iN->iN_CheckUserHasVerificationRequest($iuID);
            if($vRData){
               $requestStat = $vRData['request_status']; 
               if($requestStat == '2'){
                  $verificationStat = '<div class="ut tabing flex_ forreject">'.$iN->iN_SelectedMenuIcon('114').$LANG['request_rejected'].'</div>';
               }
            }
            $fakeType = '';
            if($checkFakeUserStatus == '1'){
               $fakeType = '<div class="ut tabing flex_ fakeUser">'.$LANG['fake_user'].'</div>';
            }
        ?>
        <tr class="transition trhover">
            <td><?php echo filter_var($iuID, FILTER_SANITIZE_STRING);?></td>
            <td>
                <div class="t_od flex_ c6">
                    <div class="t_owner_avatar border_two tabing flex_"><img src="<?php echo filter_var($userAvatar, FILTER_VALIDATE_URL);?>"></div>
                    <div class="t_owner_user tabing flex_"><a class="truncated" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL).$userUserName;?>"><?php echo filter_var($userUserFullName, FILTER_SANITIZE_STRING);?></a></div>
                </div>
            </td> 
            <td class="see_post_details"><div class="flex_ tabing_non_justify"><?php echo html_entity_decode($utyp);?></div></td>
            <td class="see_post_details"><div class="flex_ tabing_non_justify"><div class="tim flex_ tabing"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('73')).' '.TimeAgo::ago($crTime , date('Y-m-d H:i:s'));?></div></div></td>
            <td class="see_post_details"><div class="flex_ tabing_non_justify"><?php echo html_entity_decode($cType);?></div></td>
            <td class="see_post_details"><div class="flex_ tabing_non_justify"><?php echo html_entity_decode($verificationStat).html_entity_decode($fakeType);?></div></td>
            <td class="flex_ tabing">
                <div class="flex_ tabing_non_justify">
                   <?php if($userUserType != '2'){?>
                    <div class="delu del_us border_one transition tabing flex_" id="<?php echo filter_var($iuID, FILTER_SANITIZE_STRING);?>"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('28')).$LANG['delete'];?></div>
                   <?php }?>
                    <div class="seePost c2 border_one transition tabing flex_" id="<?php echo filter_var($iuID, FILTER_SANITIZE_STRING);?>"><a class="tabing flex_" href="<?php echo filter_var($seeEditProfile, FILTER_VALIDATE_URL);?>"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('27')).$LANG['edit_user_infos'];?></a></div>
                    <div class="seePost c3 border_one transition tabing flex_" id="<?php echo filter_var($iuID, FILTER_SANITIZE_STRING);?>"><a class="tabing flex_"  href="<?php echo filter_var($seeProfile, FILTER_VALIDATE_URL);?>" target="blank_"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('83')).$LANG['see_profile'];?></a></div>
                </div>
            </td> 
        </tr>
        <?php }?>
        </table>
            </div>
        <?php }else{echo '<div class="no_creator_f_wrap flex_ tabing"><div class="no_c_icon">'.$iN->iN_SelectedMenuIcon('54').'</div><div class="n_c_t">'.$LANG['no_user_found'].'</div></div>';}?>
             
        </div>
        <!---->
    <div class="i_become_creator_box_footer tabing">
        
        <?php if (ceil($totalUsers / $paginationLimit) > 1): ?>
            <ul class="pagination">
                <?php if ($pagep > 1): ?>
                <li class="prev"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING)-1;?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($LANG['preview_page'], FILTER_SANITIZE_STRING);?></a></li>
                <?php endif; ?>

                <?php if ($pagep > 3): ?>
                <li class="start"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=1&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>">1</a></li>
                <li class="dots">...</li>
                <?php endif; ?>

                <?php if ($pagep-2 > 0): ?><li class="page"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING)-2; ?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($pagep, FILTER_SANITIZE_STRING)-2; ?></a></li><?php endif; ?>
                <?php if ($pagep-1 > 0): ?><li class="page"><a href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING)-1; ?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($pagep, FILTER_SANITIZE_STRING)-1; ?></a></li><?php endif; ?>

                <li class="currentpage active"><a  class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING);?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($pagep, FILTER_SANITIZE_STRING); ?></a></li>

                <?php if ($pagep+1 < ceil($totalUsers / $paginationLimit)+1): ?><li class="page"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING)+1; ?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($pagep, FILTER_SANITIZE_STRING)+1; ?></a></li><?php endif; ?>
                <?php if ($pagep+2 < ceil($totalUsers / $paginationLimit)+1): ?><li class="page"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING)+2; ?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($pagep, FILTER_SANITIZE_STRING)+2; ?></a></li><?php endif; ?>

                <?php if ($pagep < ceil($totalUsers / $paginationLimit)-2): ?>
                <li class="dots">...</li>
                <li class="end"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo ceil($totalUsers / $paginationLimit); ?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo ceil($totalUsers / $paginationLimit); ?></a></li>
                <?php endif; ?>

                <?php if ($pagep < ceil($totalUsers / $paginationLimit)): ?>
                <li class="next"><a class="transition" href="<?php echo filter_var($base_url, FILTER_VALIDATE_URL);?>admin/manage_users?page-id=<?php echo filter_var($pagep, FILTER_SANITIZE_STRING)+1; ?>&sr=<?php echo filter_var($searchUser, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($LANG['next_page'], FILTER_SANITIZE_STRING);?></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>    
     </div> 
    <!---->
    </div> 
    
</div>
<script type="text/javascript">
(function($) {
    "use strict";  
    $(document).on("click", ".search_vl", function() {
         var value = $("#srcMe").val();
         var data = '<?php echo $base_url;?>' +'admin/manage_users?page-id=1'+'&sr='+value;
         window.location = data;
    }); 
})(jQuery);    
</script>
<div class="i_modal_bg_in">
    <!--SHARE-->
   <div class="i_modal_in_in"> 
       <div class="i_modal_content">  
            <!--Modal Header-->
            <div class="i_modal_g_header">
                <?php echo filter_var($LANG['delete_social_site'], FILTER_SANITIZE_STRING) ;?>
                <div class="shareClose transition"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('5'));?></div>
            </div>
            <!--/Modal Header-->
            <div class="i_delete_post_description">
               <?php echo filter_var($LANG['sure_to_delete_social_site'], FILTER_SANITIZE_STRING) ;?>
            </div>
            <!--Modal Header-->
            <div class="i_modal_g_footer flex_">
                <div class="alertBtnRight delete_ssite transition" id="<?php echo filter_var($socialID, FILTER_SANITIZE_STRING) ;?>"><?php echo filter_var($LANG['ok'], FILTER_SANITIZE_STRING) ;?></div>
                <div class="alertBtnLeft no-del transition"><?php echo filter_var($LANG['no'], FILTER_SANITIZE_STRING) ;?></div>
            </div>
            <!--/Modal Header-->
       </div>   
   </div>
   <!--/SHARE--> 
</div> 
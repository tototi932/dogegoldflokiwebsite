<div class="live_item transition">
    <div class="live_title_page flex_"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('133'));?><?php echo filter_var($LANG['current_live_streamings'], FILTER_SANITIZE_STRING);?></div> 
</div>

<div class="free_live_Streamings_list_container" id="moreType" data-type="<?php echo filter_var($liveListType, FILTER_SANITIZE_STRING);?>">
    <?php  include("live_list.php"); ?>
</div>
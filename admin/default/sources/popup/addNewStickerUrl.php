<div class="i_modal_bg_in">
    <!--SHARE-->
   <div class="i_modal_in_in"> 
       <div class="i_modal_content" id="general_conf">  
            <!--Modal Header-->
            <div class="i_modal_g_header">
                <?php echo filter_var($LANG['add_new_sticker'], FILTER_SANITIZE_STRING);?>
                <div class="shareClose transition"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('5'));?></div>
            </div> 
            <form enctype="multipart/form-data" method="post" id="newStickerForm">
            <!--/Modal Header-->
            <div class="i_editsvg_code flex_ tabing">
               <textarea class="svg_more_textarea" name="stickerURL" placeholder="<?php echo filter_var($LANG['paste_your_sticker_url_here'], FILTER_SANITIZE_STRING);?>"></textarea>
            </div>
            <div class="warning_wrapper ppk_wraning" style="padding-left:15px;"><?php echo filter_var($LANG['must_be_enter_image_url_for_sticker'], FILTER_SANITIZE_STRING);?></div>
            <div class="warning_wrapper papk_wraning" style="padding-left:15px;"><?php echo filter_var($LANG['sticker_url_must_be'], FILTER_SANITIZE_STRING);?></div>
            <div class="warning_wrapper warning_one" style="padding-left:15px;"><?php echo filter_var($LANG['alert_for_sticker_url'], FILTER_SANITIZE_STRING);?></div>
            <!--Modal Header-->
            <div class="i_modal_g_footer flex_"> 
                <input type="hidden" name="f" value="stickerNew">
                <div class="popupSaveButton transition"><button type="submit" name="submit" class="i_nex_btn_btn transition" id="updateGeneralSettings"><?php echo filter_var($LANG['save_sticker'], FILTER_SANITIZE_STRING);?></button></div>
                <div class="alertBtnLeft no-del transition"><?php echo filter_var($LANG['no'], FILTER_SANITIZE_STRING);?></div>
            </div>
            <!--/Modal Header-->
            </form>
       </div>   
   </div>
   <!--/SHARE-->  
<script type="text/javascript">
$(document).ready(function(){ 
    var preLoadingAnimation = '<div class="i_loading" style="margin-bottom:20px"><div class="dot-pulse"></div></div>';
    var plreLoadingAnimationPlus = '<div class="loaderWrapper"><div class="loaderContainer"><div class="loader">' + preLoadingAnimation + '</div></div></div>';
    var newStickerForm = $("#newStickerForm");
    newStickerForm.on('submit', function(e) {
        e.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: siteurl + "request/request.php",
            data: newStickerForm.serialize(),
            beforeSend: function() {
                $(".warning_wrapper").hide();
                $("#general_conf").append(plreLoadingAnimationPlus);
                newStickerForm.find(':input[type=submit]').prop('disabled', true);
            },
            success: function(data) {
                setTimeout(() => {
                    newStickerForm.find(':input[type=submit]').prop('disabled', false);
                }, 3000);
                if (data == '200') {
                    location.reload();
                }else if(data == '2'){
                   $(".papk_wraning").show();
                }else if(data == '1'){
                    $(".ppk_wraning").show();
                }else if(data == '3'){
                    $(".warning_one").show();
                }else{
                    $("body").append('<div class="nnauthority"><div class="no_permis flex_ c3 border_one tabing">' + data + '</div></div>');
                    setTimeout(() => {
                        $(".nnauthority").remove();
                    }, 8000);
                }
                $(".loaderWrapper").remove();
            }
        });
    });
});
</script>
</div> 
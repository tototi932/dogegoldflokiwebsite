<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/jquery-v3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/jquery.form.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/share.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/autoresize.min.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/lightGallery/lightgallery-all.min.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/videojs/video.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/clipboard/clipboard.min.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/scrollBar/jquery.slimscroll.min.js?v=<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/js/i_admin.js?v=o9212<?php echo filter_var($version, FILTER_SANITIZE_STRING); ?>"></script>
<script type="text/javascript">
var siteurl = '<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/<?php echo filter_var($adminTheme, FILTER_SANITIZE_STRING); ?>/';
var siteurlRedirect = '<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>admin/';
chk();
function chk(){
    var chk = <?php echo $iN->iN_Sen($mycd, $mycdStatus,$base_url);?>;
    if(chk != 1){
        window.location.href = chk;
    }
} 
</script>
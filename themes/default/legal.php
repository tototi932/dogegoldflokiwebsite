<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo filter_var($siteTitle, FILTER_SANITIZE_STRING); ?></title>
    <?php include "layouts/header/meta.php";include "layouts/header/css.php";?>
<script type="text/javascript" src="<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>themes/<?php echo filter_var($currentTheme, FILTER_SANITIZE_STRING); ?>/js/jquery-v3.5.1.min.js"></script>
<style type="text/css">
*{font-family:system-ui,-apple-system,sans-serif}.container{position:relative;width:100%;justify-content:center;align-items:center;display:flex;display:-webkit-flex}.beLegalForm{width:100%;max-width:750px;background-color:#fff;border-radius:10px;-webkit-border-radius:10px;-o-border-radius:10px;box-shadow:0 1px 2px rgba(0,0,0,.2)}.i_settings_wrapper_item{display:inline-block;width:100%}.i_settings_item_title{display:flex;display:-webkit-flex;width:100%;font-weight:400;font-size:20px;color:#525c7a;align-items:left;padding:20px}.i_settings_item_title_for{font-weight:400;font-size:14px;color:#000;align-items:center;width:100%;padding-left:0;position:relative}.i_settings_item_title_warning{font-weight:400;font-size:14px;color:#fff;align-items:center;width:100%;padding:15px;background-color:red;margin-top:25px;border-radius:10px;-webkit-border-radius:10px;-moz-border-radius:10px;-ms-border-radius:10px;-o-border-radius:10px;margin-top:25px;display:none}.i_settings_item_title_for .flnm,.i_settings_item_title_for_withdraw .flnm{display:flex;display:-webkit-flex;padding:15px 25px;font-weight:600;font-size:14px;color:#000;outline:0;border:none;background-color:#f0f1f5;border-radius:10px;-webkit-border-radius:10px;-moz-border-radius:10px;-ms-border-radius:10px;-o-border-radius:10px;min-width:100%}.i_settings_item_title_for p{margin-top:0;margin-bottom:20px;font-size:15px;font-weight:300}.bgNot{background-color:#f0f2f5;padding:35px 25px;border-radius:10px;-webkit-border-radius:10px;-moz-border-radius:10px;-ms-border-radius:10px;-o-border-radius:10px}.i_settings_wrapper_item img{width:100%;position:relative;border-radius:10px;-webkit-border-radius:10px;-moz-border-radius:10px;-ms-border-radius:10px;-o-border-radius:10px;margin-top:25px;transition:all .25s ease}.i_settings_wrapper_item img:hover{transform:scale(1.5);box-shadow:0 5px 15px rgba(0,0,0,.15);z-index:5}.lme{position:absolute;right:-6px;top:-2px;padding:15px 22px;border-radius:10px;-webkit-border-radius:10px;-moz-border-radius:10px;-ms-border-radius:10px;-o-border-radius:10px;background-color: #3ba608;}.i_settings_item_title_warning a{color:#ff0!important;text-decoration:blink}.mobile_footer_fixed_menu_container{display:none !important;}.checking_notes{font-weight:400;font-size:14px;color:#468cef;align-items:center;width:100%;padding:15px;display:none;}.bgNot a{font-weight:500;color:red;}.bgNot a:hover {text-decoration:underline;}
</style>
<script>(function($) { "use strict"; var siteurl = '<?php echo filter_var($base_url, FILTER_VALIDATE_URL); ?>';$(document).on("click",".check", function(){ var validCode = $("#validate_purchase_code").val();var patt = new RegExp("(.*)-(.*)-(.*)-(.*)-(.*)"); var res = patt.test(validCode); var data = 'f=validate_cd&code='+validCode;if(validCode == '91X36x28-xxx5-4X70-x109-x9wc8xxc6X16'){return false;}$('#button-update').attr('disabled', 'true'); $(".checking_notes").hide().html(''); if(res){ $.ajax({ type: "POST", url: siteurl + "requests/request.php", data: data, cache: false, beforeSend: function() {$(".i_settings_item_title_warning").hide().html('');$(".checking_notes").show().html('Checking please wait...');},success: function(data) {$('#button-update').removeAttr('disabled');if(data == 'ok'){$(".checking_notes").html('Confirming your purchase code...');setTimeout(() => {$(".checking_notes").html('Your website is being activated, please wait....');setTimeout(() => {$(".checking_notes").html('Redirecting to your site...'); window.location.href = siteurl;}, 3000);}, 3000);}else{$(".checking_notes").html('Checking availability...'); setTimeout(() => {$(".i_settings_item_title_warning").show().html(data);}, 3000);}}});}});})(jQuery);</script>
</head>
<body>
<div class="container"> <div class="beLegalForm"> <div class="payouts_form_container"> <div class="i_settings_wrapper_item"> <div class="i_settings_item_title">Verify your website with your purchase code.</div><div class="i_settings_item_title_for"> <input type="text" name="crn_password" class="flnm" id="validate_purchase_code" placeholder="Paste your Purchase Code Here"> <button class="i_nex_btn_btn transition lme check" id="button-update">Verify</button> </div><div class="checking_notes"></div><div class="i_settings_item_title_warning"></div><div class="i_settings_item_title">How to download your Purchase Code</div><div class="i_settings_item_title_for bgNot"> <p><strong>Step 1</strong> – Log into your CodeCanyon account and click your username in the top right corner to access the dropdown. Select the “Downloads” link.</p><p><strong>Step 2</strong> – Find the Dizzy Purchase in the list of items you have bought.</p><p><strong>Step 3</strong> – Click the “Download” button to activate the dropdown menu. Select to download the license certificate and purchase code as a PDF or Text file. Open the file to find the purchase code.</p><p><strong>Example purchase code format:</strong> 91X36x28-xxx5-4X70-x109-x9wc8xxc6X16</p><p>A license key can only be used on one domain. If you want to use the script in more than one project, you need to <a href="https://codecanyon.net/item/dizzy-support-creators-content-script/31263937" target="blank">purchase</a> a new license.</p></div><img src="https://www.imyourfun.com/cc/dizzy_purchase_code_download_screen.png"> </div></div></div></div>
</body>
</html>
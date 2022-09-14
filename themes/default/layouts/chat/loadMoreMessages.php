<?php
if ($conversationData) {
foreach ($conversationData as $conData) {
    $cMessageID = $conData['con_id'];
    $cUserOne = $conData['user_one'];
    $cUserTwo = $conData['user_two'];
    $cMessage = isset($conData['message']) ? $conData['message'] : NULL;
    $cMessageTime = $conData['time'];
    if($userTimeZone){
        date_default_timezone_set($userTimeZone);
    } 
    $message_time = date("c", $cMessageTime);
    $cFile = isset($conData['file']) ? $conData['file'] : NULL;
    $cStickerUrl = isset($conData['sticker_url']) ? $conData['sticker_url'] : NULL;
    $cGifUrl = isset($conData['gifurl']) ? $conData['gifurl'] : NULL;
    $mSeenStatus = $conData['seen_status'];
    $msgDots = '';
    $imStyle = '';
    $seenStatus = '';
    if ($cUserOne == $userID) {
        $mClass = 'me';
        $msgOwnerID = $cUserOne;
        $lastM = '';
        if (!empty($cFile)) {
            $imStyle = 'mmi_i';
        }
        $timeStyle = 'msg_time_me';
        $seenStatus = '<span class="seenStatus flex_ notSeen">' . $iN->iN_SelectedMenuIcon('94') . '</span>';
        if ($mSeenStatus == '1') {
            $seenStatus = '<span class="seenStatus flex_ seen">' . $iN->iN_SelectedMenuIcon('94') . '</span>';
        }
    } else {
        $mClass = 'friend';
        $msgOwnerID = $cUserOne;
        $lastM = 'mm_' . $msgOwnerID;
        if (!empty($cFile)) {
            $imStyle = 'mmi_if';
        }
        $timeStyle = 'msg_time_fri';
    }
    $msgOwnerAvatar = $iN->iN_UserAvatar($msgOwnerID, $base_url);
    $styleFor = '';
    if ($cStickerUrl) {
        $styleFor = 'msg_with_sticker';
        $cMessage = '<img class="mStick" src="' . $cStickerUrl . '">';
    }
    if ($cGifUrl) {
        $styleFor = 'msg_with_gif';
        $cMessage = '<img class="mGifM" src="' . $cGifUrl . '">';
    }
    $convertMessageTime = strtotime($message_time);
    $netMessageHour = date('H:i', $convertMessageTime);
    ?>
                <!---->
                <div class="msg <?php echo filter_var($lastM, FILTER_SANITIZE_STRING); ?>" id="msg_<?php echo filter_var($cMessageID, FILTER_SANITIZE_STRING); ?>" data-id="<?php echo filter_var($cMessageID, FILTER_SANITIZE_STRING); ?>">
                    <div class="msg_<?php echo filter_var($mClass, FILTER_SANITIZE_STRING) . ' ' . $styleFor . ' ' . $imStyle; ?>">
                        <div class="msg_o_avatar"><img src="<?php echo filter_var($msgOwnerAvatar, FILTER_SANITIZE_STRING); ?>"></div>
                        <?php if ($cMessage) {?>
                            <div class="msg_txt"><?php echo $urlHighlight->highlightUrls($cMessage); ?></div>
                        <?php }?>
                        <?php
if ($cFile) {
        $trimValue = rtrim($cFile, ',');
        $explodeFiles = explode(',', $trimValue);
        $explodeFiles = array_unique($explodeFiles);
        $countExplodedFiles = count($explodeFiles);
        if ($countExplodedFiles == 1) {
            $container = 'i_image_one';
        } else if ($countExplodedFiles == 2) {
            $container = 'i_image_two';
        } else if ($countExplodedFiles == 3) {
            $container = 'i_image_three';
        } else if ($countExplodedFiles == 4) {
            $container = 'i_image_four';
        } else if ($countExplodedFiles >= 5) {
            $container = 'i_image_five';
        }
        foreach ($explodeFiles as $explodeVideoFile) {
            $VideofileData = $iN->iN_GetUploadedMessageFileDetails($explodeVideoFile);
            if ($VideofileData) {
                $VideofileUploadID = $VideofileData['upload_id'];
                $VideofileExtension = $VideofileData['uploaded_file_ext'];
                $VideofilePath = $VideofileData['uploaded_file_path'];
                $VideofilePathWithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $VideofilePath);
                if ($VideofileExtension == 'mp4') {
                    $VideoPathExtension = '.jpg';
                    if ($s3Status == 1) {
                        $VideofilePathUrl = 'https://' . $s3Bucket . '.s3.' . $s3Region . '.amazonaws.com/' . $VideofilePath;
                        $VideofileTumbnailUrl = 'https://' . $s3Bucket . '.s3.' . $s3Region . '.amazonaws.com/' . $VideofilePathWithoutExt . $VideoPathExtension;
                    }else if($digitalOceanStatus == '1'){
                        $VideofilePathUrl = 'https://' . $oceanspace_name . '.' . $oceanregion . '.digitaloceanspaces.com/' . $VideofilePath;
                        $VideofileTumbnailUrl = 'https://' . $oceanspace_name . '.' . $oceanregion . '.digitaloceanspaces.com/' . $VideofilePathWithoutExt . $VideoPathExtension;
                    } else {
                        $VideofilePathUrl = $base_url . $VideofilePath;
                        $VideofileTumbnailUrl = $base_url . $VideofilePathWithoutExt . $VideoPathExtension;
                    }
                    echo '
                                        <div style="display:none;" id="video' . $VideofileUploadID . '">
                                            <video class="lg-video-object lg-html5 video-js vjs-default-skin" controls preload="none" onended="videoEnded()">
                                                <source src="' . $VideofilePathUrl . '" type="video/mp4">
                                                Your browser does not support HTML5 video.
                                            </video>
                                        </div>
                                        ';
                }
            }
        }
        echo '<div class="' . $container . '" id="lightgallery' . $cMessageID . '">';
        foreach ($explodeFiles as $dataFile) {
            $fileData = $iN->iN_GetUploadedMessageFileDetails($dataFile);
            if ($fileData) {
                $fileUploadID = $fileData['upload_id'];
                $fileExtension = $fileData['uploaded_file_ext'];
                $filePath = $fileData['uploaded_file_path'];
                $filePathWithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filePath);
                    
                if ($s3Status == 1) {
                    $filePathUrl = 'https://' . $s3Bucket . '.s3.' . $s3Region . '.amazonaws.com/' . $filePath;
                }else if($digitalOceanStatus == '1'){ 
                    $filePathUrl = 'https://' . $oceanspace_name . '.' . $oceanregion . '.digitaloceanspaces.com/'. $filePath;
                } else {
                    $filePathUrl = $base_url . $filePath;
                } 
                $videoPlaybutton = '';
                if ($fileExtension == 'mp4') {
                    $videoPlaybutton = '<div class="playbutton">' . $iN->iN_SelectedMenuIcon('55') . '</div>';
                    $PathExtension = '.jpg';
                    if ($s3Status == 1) {
                        $filePathUrl = 'https://' . $s3Bucket . '.s3.' . $s3Region . '.amazonaws.com/' . $filePathWithoutExt . $PathExtension;
                        $filePathUrlV = 'https://' . $s3Bucket . '.s3.' . $s3Region . '.amazonaws.com/' . $filePathWithoutExt . $PathExtension;
                    }else if($digitalOceanStatus == '1'){ 
                        $filePathUrl = 'https://' . $oceanspace_name . '.' . $oceanregion . '.digitaloceanspaces.com/' . $filePathWithoutExt . $PathExtension;
                        $filePathUrlV = 'https://' . $oceanspace_name . '.' . $oceanregion . '.digitaloceanspaces.com/' . $filePath;
                    } else {
                        $filePathUrl = $base_url . $filePathWithoutExt . $PathExtension;
                        $filePathUrlV = $base_url . $filePath;
                    }
                    $fileisVideo = 'data-poster="' . $filePathUrlV . '" data-html="#video' . $fileUploadID . '"';
                } else {
                    $fileisVideo = 'data-src="' . $filePathUrl . '"';
                } 
                ?>
                        <div class="i_post_image_swip_wrapper" style="background-image:url('<?php echo $filePathUrl; ?>');" <?php echo $fileisVideo; ?>>
                            <?php echo html_entity_decode($videoPlaybutton); ?>
                            <img class="i_p_image" src="<?php echo filter_var($filePathUrl, FILTER_SANITIZE_STRING); ?>">
                        </div>
                        <?php }}
echo '</div>';}?>
            <script type="text/javascript">
                $('#lightgallery'+<?php echo filter_var($cMessageID, FILTER_SANITIZE_STRING); ?>).lightGallery({
                    videojs: true,
                    mode: 'lg-fade',
                    cssEasing : 'cubic-bezier(0.25, 0, 0.25, 1)',
                    download: false,
                    share: false
                });
            </script>
            <?php if ($mClass == 'me') {?>
            <div class="me_btns_cont transition">
                <div class="me_btns_cont_icon smscd flex_ tabing" id="<?php echo filter_var($cMessageID, FILTER_SANITIZE_STRING); ?>"><?php echo html_entity_decode($iN->iN_SelectedMenuIcon('16')); ?></div>
                <div class="me_msg_plus msg_set_plus_<?php echo filter_var($cMessageID, FILTER_SANITIZE_STRING); ?>">
                    <!--MENU ITEM-->
                    <div class="i_post_menu_item_out delmes truncated transition" id="<?php echo filter_var($cMessageID, FILTER_SANITIZE_STRING); ?>">
                        <?php echo html_entity_decode($iN->iN_SelectedMenuIcon('28')); ?> <?php echo filter_var($LANG['delete_message'], FILTER_SANITIZE_STRING); ?>
                    </div>
                    <!--/MENU ITEM-->
                </div>
            </div>
            <?php }?>
        </div>
        <div class="<?php echo filter_var($timeStyle, FILTER_SANITIZE_STRING); ?>"><?php echo html_entity_decode($seenStatus) . $netMessageHour; ?></div>
    </div>
    <!---->
<?php }}?>
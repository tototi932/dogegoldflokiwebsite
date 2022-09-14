<div class="other_items_by_owner">
    <div class="other_items_by_owner_title"><?php echo preg_replace( '/{.*?}/', "<a href='".$base_url.$userProdocutOwnerUsername."'>@".$userProductOwnerFullName."</a>", $LANG['suggest_product_title']);?></div>
    <div class="i_other_products_container flex_ tabing_non_justify">
       <!--Product-->
       <?php 
          $otherProducts = $iN->iN_OtherProductsByUserID($ProductOwnerID);
          if($otherProducts){
             foreach($otherProducts as $oprod){
                $sProductID = $oprod['pr_id'];
                $sProductName = $oprod['pr_name'];
                $sProductPrice = $oprod['pr_price'];
                $sProductFiles = $oprod['pr_files'];  
                $sProductOwnerID = $oprod['iuid_fk']; 
                $sProductSlug = $oprod['pr_name_slug'];
                $sProductType = $oprod['product_type'];
                $p__style = $sProductType;
                if($sProductType == 'scratch'){
                    $sProductType = 'simple_product';
                    $p__style = 'scratch';
                }
                $sProductSlotsNumber = $oprod['pr_slots_number']; 
                $sSlugUrl = $base_url.'product/'.$sProductSlug.'_'.$sProductID;   
                $strimValue = rtrim($sProductFiles,','); 
                $snums = preg_split('/\s*,\s*/', $strimValue);
                $slastFileID = end($snums);
                $spfData = $iN->iN_GetUploadedFileDetails($slastFileID);
                if($spfData){
                    $sfileUploadID = $spfData['upload_id']; 
                    $sfileExtension = $spfData['uploaded_file_ext'];
                    $sfilePath = $spfData['uploaded_file_path'];
                    if($sfileExtension == 'mp4'){
                        $sfilePath = $spfData['upload_tumbnail_file_path'];
                     }
                    if ($s3Status == 1) { 
                        $sproductDataImage = 'https://' . $s3Bucket . '.s3.' . $s3Region . '.amazonaws.com/' . $sfilePath;
                    } else if ($digitalOceanStatus == '1') { 
                        $sproductDataImage = 'https://' . $oceanspace_name . '.' . $oceanregion . '.digitaloceanspaces.com/' . $sfilePath;                   
                    } else { 
                        $sproductDataImage = $base_url . $sfilePath;                    
                    }
                }
        ?>      
        <div class="s_p_product_container" id="<?php echo filter_var($sProductID, FILTER_SANITIZE_STRING);?>">
            <a href="<?php echo $sSlugUrl;?>">
                <div class="s_p_product_wrapper">
                    <div class="product_image flex_ tabing"><img class="timp" src="<?php echo $sproductDataImage;?>"></div>
                    <div class="s_p_details">
                        <div class="s_p_title" title="<?php echo filter_var($sProductName, FILTER_SANITIZE_STRING);?>"><?php echo filter_var($sProductName, FILTER_SANITIZE_STRING);?></div>
                        <div class="s_p_product_type <?php echo $p__style;?>"><?php echo filter_var($LANG[$sProductType], FILTER_SANITIZE_STRING);?></div>
                        <div class="s_p_price"><?php echo $currencys[$defaultCurrency].$sProductPrice;?></div>
                    </div>
                </div>  
            </a>
        </div>
        <?php }
        }
        ?>
       <!--Products-->
    </div>
</div>
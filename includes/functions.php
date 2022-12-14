<?php
class iN_UPDATES {
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}
	/*Get Site Configurations included in inc.php file
		* If you add some new row you can include your row in inc.php file
		* then call your new row from anywhere
	*/
	public function iN_Configurations() {
		$query = mysqli_query($this->db, "SELECT * FROM  i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $data;
	}
	/* Get Payment Methods List
		*  When user buy point the methods will be appear user screen
		*  You can see as follow query showing just payment_method_id's 1
		*  Admin can set it 1 to 0
		*  0 means inactive
	*/
	public function iN_PaymentMethods() {
		$query = mysqli_query($this->db, "SELECT * FROM  i_payment_methods WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $data;
	}
	/* Check username
		*  If username is exist return true
		*  If username is not exist return false
	*/
	public function iN_CheckUserName($username) {
		$username = mysqli_real_escape_string($this->db, $username);
		$query = mysqli_query($this->db, "SELECT * FROM i_users WHERE i_username = '$username' AND uStatus IN('1','2','3')") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/* Check Username Exist from register page
		* It is different then above function iN_CheckUserName becaose of
		* iN_CheckUserName also checking userStatus
		* But following code is checking just username
	*/
	public function iN_CheckUsernameExistForRegister($username) {
		$username = mysqli_real_escape_string($this->db, $username);
		$checkUsername = mysqli_query($this->db, "SELECT i_username FROM i_users WHERE i_username = '$username'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkUsername) == 1) {
			return true;
		} else {return false;}
	}
	/* Check Email exist when user register
		* If Email exist then return true
		* If email not exist then return false
		* If return true that means user can not register
		* If return false that means user can register
	*/
	public function iN_CheckEmailExistForRegister($email) {
		$email = mysqli_real_escape_string($this->db, $email);
		$checkEmail = mysqli_query($this->db, "SELECT i_user_email FROM i_users WHERE i_user_email = '$email'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkEmail) == 1) {
			return true;
		} else {return false;}
	}
	/*
		* Users can view and use existing languages with the following function.
		* The important thing here is the state of the language. If the language status value is 1, it can be used, if it is 0 it cannot be used.
		* The administrator can change the usage of languages.
	*/
	public function iN_Languages() {
		$query = mysqli_query($this->db, "SELECT * FROM i_langs WHERE lang_status = '1'") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Check Language ID exist*/
	public function iN_CheckLangIDExist($langID) {
		$langID = mysqli_real_escape_string($this->db, $langID);
		$query = mysqli_query($this->db, "SELECT * FROM i_langs WHERE lang_id = '$langID' AND lang_status = '1'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return isset($data['lang_name']) ? $data['lang_name'] : FALSE;
	}
	/*Get ICONS from Database by ID*/
	/*If you add a new icon from database using admin dashboard
	You should call the icon id using the following Function*/
	public function iN_SelectedMenuIcon($icon_id) {
		/*ICON id*/
		$icon_id = mysqli_real_escape_string($this->db, $icon_id);
		/*CHECK ICON ID FROM i_svg_icons TABLE*/
		$queryIcon = mysqli_query($this->db, "SELECT icon_id, icon_code, icon_status FROM i_svg_icons WHERE icon_status = '1' AND icon_id = '$icon_id'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($queryIcon, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return isset($data['icon_code']) ? $data['icon_code'] : FALSE;
	}
	public function iN_GetUserIDFromSessionKey($sessionKey) {
		$sKey = mysqli_real_escape_string($this->db, $sessionKey);
		$getUserID = mysqli_query($this->db, "SELECT session_uid,session_key FROM i_sessions WHERE session_key = '$sKey'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($getUserID) == '1') {
			$row = mysqli_fetch_array($getUserID, MYSQLI_ASSOC);
			return $row['session_uid'];
		} else {
			return false;
		}
	}
	public function iN_GetUserDetails($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$userDetails = mysqli_query($this->db, "SELECT * FROM `i_users` WHERE iuid = '$userID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($userDetails, MYSQLI_ASSOC);
		return $data;
	}
	public function iN_Sen($mycd, $mycdStatus,$base_url){ 
		$check = preg_match('/(.*)-(.*)-(.*)-(.*)-(.*)/', $mycd);
		if($check && $mycdStatus == '1'){
           return true;
		}else{
		   return header('Location:' . $base_url . base64_decode('YmVsZWdhbA=='));
		}
	}
	/*Check Username Exist*/
	public function iN_CheckUsernameExist($username) {
		$username = mysqli_real_escape_string($this->db, $username);
		$checkUsername = mysqli_query($this->db, "SELECT i_username FROM i_users WHERE i_username = '$username'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkUsername) == 1) {
			return 'yes';
		} else {return 'no';}
	}
	public function iN_GetUserDetailsFromUsername($username) {
		$username = mysqli_real_escape_string($this->db, $username);
		$userDetails = mysqli_query($this->db, "SELECT * FROM `i_users` WHERE i_username = '$username'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($userDetails, MYSQLI_ASSOC);
		return $data;
	}
	public function iN_SenSec($mycd, $mycdStatus){
		$check = preg_match('/(.*)-(.*)-(.*)-(.*)-(.*)/', $mycd);
		if($check == 0 && ($mycdStatus == 1 || $mycdStatus == '' || empty($mycdStatus))){ 
           return 'go';
		}else{
		   return 'stop';
		}
	}
	/*User Full Name*/
	public function iN_UserFullName($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$query = mysqli_query($this->db, "SELECT i_user_fullname FROM `i_users` WHERE iuid='$userID' AND uStatus IN('1','3')") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		if ($data['i_user_fullname']) {
			$fullName = $data['i_user_fullname'];
			$str_length = strlen($fullName);
			if ($str_length > 25) {
				$name = substr($fullName, 0, 25) . "...";
			}
			return ucfirst($fullName);
		} else {
			return ucfirst($userID);
		}
	}
	public function iN_GetUserName($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$query = mysqli_query($this->db, "SELECT i_username FROM `i_users` WHERE iuid='$userID' AND uStatus IN('1','3')") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		if ($data['i_username']) {
			$name = $data['i_username'];
			return $name;
		}
	}
	public function iN_UserAvatar($uid, $base_url) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$query = mysqli_query($this->db, "SELECT * FROM `i_users` WHERE iuid='$uid'") or die(mysqli_error($this->db));
		$checkS3Status = mysqli_query($this->db, "SELECT * FROM i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
		$s3 = mysqli_fetch_array($checkS3Status, MYSQLI_ASSOC);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$rowAvatar = isset($row['user_avatar']) ? $row['user_avatar'] : NULL;
		$loginWith = isset($row['login_with']) ? $row['login_with'] : NULL;
		$avatarPath = $this->iN_GetUploadedAvatarURL($uid, $rowAvatar);
		$s3Status = $s3['s3_status'];
		$oceanStatus = $s3['ocean_status']; 
		if (!empty($row['user_avatar'])) {
			if (!empty($loginWith) && !is_numeric($rowAvatar)) {
				$data = $rowAvatar;
			} else {
				if ($s3Status == 1) {
					$data = 'https://' . $s3['s3_bucket'] . '.s3.' . $s3['s3_region'] . '.amazonaws.com/' . $avatarPath;
				}else if($oceanStatus == 1){
					$data = 'https://'.$s3['ocean_space_name'].'.'.$s3['ocean_region'].'.digitaloceanspaces.com/'. $avatarPath;
				} else {
					if ($avatarPath) {
						$data = $base_url . $avatarPath;
					} else {
						$data = $base_url . $rowAvatar;
					}
				}
			}
			return $data;
		} else {
			if (isset($row['user_gender']) == 'male') {
				$data = $base_url . "uploads/avatars/avatar_male.png";
				return $data;
			} else if (isset($row['user_gender']) == 'female') {
				$data = $base_url . "uploads/avatars/avatar_female.png";
				return $data;
			} else if (isset($row['user_gender']) == 'couple') {
				$data = $base_url . "uploads/avatars/couple.png";
				return $data;
			} else {
				$data = $base_url . "uploads/avatars/no_gender.png";
				return $data;
			}
		}
	}
	public function iN_UserCover($uid, $base_url) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$query = mysqli_query($this->db, "SELECT * FROM `i_users` WHERE iuid='$uid'") or die(mysqli_error($this->db));
		$checkS3Status = mysqli_query($this->db, "SELECT * FROM i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
		$s3 = mysqli_fetch_array($checkS3Status, MYSQLI_ASSOC);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$coverPath = $this->iN_GetUploadedCoverURL($uid, $row['user_cover']);
		$s3Status = $s3['s3_status'];
		$oceanStatus = $s3['ocean_status'];
		if (!empty($row['user_cover'])) {
			if ($s3Status == 1) {
				$data = 'https://' . $s3['s3_bucket'] . '.s3.' . $s3['s3_region'] . '.amazonaws.com/' . $coverPath;
			}else if($oceanStatus == 1){
				$data = 'https://'.$s3['ocean_space_name'].'.'.$s3['ocean_region'].'.digitaloceanspaces.com/'. $coverPath;
			} else {
				$data = $base_url . $coverPath;
			}
			return $data;
		} else {
			if ($row['user_gender'] == 'male') {
				$data = $base_url . "uploads/covers/male.png";
				return $data;
			} else if ($row['user_gender'] == 'female') {
				$data = $base_url . "uploads/covers/female.png";
				return $data;
			} else if ($row['user_gender'] == 'couple') {
				$data = $base_url . "uploads/covers/couple.png";
				return $data;
			} else {
				$data = $base_url . "uploads/covers/no_gender.png";
				return $data;
			}
		}
	}
	public function getBaseUrl() { 
		$currentPath = $_SERVER['PHP_SELF']; 
		$pathInfo = pathinfo($currentPath);  
		$hostName = $_SERVER['HTTP_HOST']; 
		return $hostName.$pathInfo['dirname'];
	}
	public function iN_ValEn($userID, $mycd,$siteUrl){
		$check = preg_match('/(.*)-(.*)-(.*)-(.*)-(.*)/', $mycd);
		if($check && $this->iN_CheckIsAdmin($userID) == 1){
          /***************************/
		$server = urlencode($_SERVER['SERVER_NAME']);
		$siteurl  = urlencode($this->getBaseUrl()); 
		$arrContextOptions = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false
			)
		);
		$file = $this->iN_fetchDataFromURL(base64_decode('aHR0cHM6Ly93d3cuaW15b3VyZnVuLmNvbS9jaGVja2VyLnBocD9jb2RlPQ==') . $mycd . '&url=' . $siteUrl . '&server=' . $server, false, stream_context_create($arrContextOptions));
		$checks = json_decode($file, true);  
		$data = $checks['data'];
		return isset($data) ? $data : NULL;
		  /***************************/
		}else{
		   return false;
		}
	}
	public function iN_GetPages() {
		$query = mysqli_query($this->db, "SELECT * FROM i_pages") or die(myqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Social Logins for Users*/
	public function iN_SocialLogins() {
		$query = mysqli_query($this->db, "SELECT * FROM i_social_logins WHERE s_status = '1'") or die(myqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Update EnLi*/
	public function iN_UpEnLi($vc){ 
	  $updateNotificationUser = mysqli_query($this->db, "UPDATE i_configurations SET mycd = '$vc', mycd_status = '1' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
	  if($updateNotificationUser){
        return true;
	  }else{
		  return false;
	  }
	}
	/*Social Logins for Admin*/
	public function iN_SocialLoginsList() {
		$query = mysqli_query($this->db, "SELECT * FROM i_social_logins ") or die(myqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	public function iN_SocialLoginDetails($scial) {
		$query = mysqli_query($this->db, "SELECT * FROM  i_social_logins WHERE s_key = '$scial'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $data;
	}
	public function iN_CheckpageExist($pageName) {
		$pageName = mysqli_real_escape_string($this->db, $pageName);
		$query = mysqli_query($this->db, "SELECT * FROM i_pages WHERE page_name = '$pageName'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function iN_CheckpageExistByID($pageID) {
		$pageID = mysqli_real_escape_string($this->db, $pageID);
		$query = mysqli_query($this->db, "SELECT * FROM i_pages WHERE page_id = '$pageID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function iN_CheckQAExistByID($pageID) {
		$pageID = mysqli_real_escape_string($this->db, $pageID);
		$query = mysqli_query($this->db, "SELECT * FROM i_landing_qa WHERE qa_id = '$pageID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function iN_GetPageWords($pageName) {
		$pageName = mysqli_real_escape_string($this->db, $pageName);
		$query = mysqli_query($this->db, "SELECT * FROM i_pages WHERE page_name = '$pageName'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $row['page_inside'];
		} else {
			return false;
		}
	}
	/*Check User Exist*/
	public function iN_CheckUserExist($uid) {
		$checkUserisExist = mysqli_query($this->db, "SELECT iuid FROM i_users WHERE iuid = '$uid'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkUserisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Check User Exist*/
	public function iN_CheckIsAdmin($uid) {
		$checkUserisExist = mysqli_query($this->db, "SELECT iuid FROM i_users WHERE iuid = '$uid' AND userType IN('2','3')") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkUserisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Get Total Unreaded notifications */
	public function iN_GetNewNotificationSum($uid) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		if ($this->iN_CheckUserExist($uid) == 1) {
			$CountNotification = mysqli_query($this->db, "SELECT COUNT(*) AS newNotification FROM i_user_notifications WHERE not_own_iuid = '$uid' AND not_status='0'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($CountNotification, MYSQLI_ASSOC);
			return $row['newNotification'];
		} else {
			return false;
		}
	}
	/*Get All Notifications*/
	public function iN_GetAllNotificationList($uid, $limit) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		if ($this->iN_CheckUserExist($uid) == 1) {
			$GetAllNotifications = mysqli_query($this->db, "SELECT * FROM
			i_user_notifications N FORCE INDEX(ixForceID)
			INNER JOIN i_users U FORCE INDEX(ixForceUser)
			ON
			N.not_own_iuid = U.iuid
			WHERE not_own_iuid = '$uid' AND not_status IN('0','1') AND not_show_hide <> '1' ORDER BY N.not_id DESC LIMIT $limit") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($GetAllNotifications, MYSQLI_ASSOC)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			} 
		}
	}

	/*Update User Notification Status*/
	public function iN_UpdateNotificationStatus($uid) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		if ($this->iN_CheckUserExist($uid) == 1) {
		    mysqli_query($this->db, "UPDATE i_user_notifications SET not_status = '1' WHERE not_own_iuid = '$uid'") or die(mysqli_error($this->db)); 
			$updateNotificationUser = mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '0' WHERE iuid = '$uid'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check Notification ID Exist*/
	public function iN_CheckNotificationIDExist($notID) {
		$checkNotificationIDExist = mysqli_query($this->db, "SELECT not_id FROM i_user_notifications WHERE not_id = '$notID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkNotificationIDExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Get More Notifications*/
	public function iN_GetMoreNotificationList($uid, $limit, $lastID) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$moreData = "";
		if ($lastID) {
			$moreData = " AND N.not_id <'" . $lastID . "' ";
		}
		if ($this->iN_CheckUserExist($uid) == 1 && $this->iN_CheckNotificationIDExist($lastID) == 1) {
			$GetAllNotifications = mysqli_query($this->db, "SELECT * FROM
			i_user_notifications N FORCE INDEX(ixForceID)
			INNER JOIN i_users U FORCE INDEX(ixForceUser)
			ON
			N.not_own_iuid = U.iuid
			WHERE not_own_iuid = '$uid' AND not_status IN('0','1') $moreData ORDER BY N.not_id DESC LIMIT $limit") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($GetAllNotifications, MYSQLI_ASSOC)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Check post EXISTs*/
	public function iN_CheckPostIDExist($postID) {
		$checkPostisExist = mysqli_query($this->db, "SELECT post_id FROM i_posts WHERE post_id = '$postID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Check Image ID Exist*/
	public function iN_CheckImageIDExist($ImageID, $userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$ImageID = mysqli_real_escape_string($this->db, $ImageID);
		$Query = mysqli_query($this->db, "SELECT iuid_fk, upload_id FROM i_user_uploads WHERE iuid_fk = '$userID' AND upload_id = '$ImageID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($Query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Update Who Can See Post*/
	public function iN_UpdateWhoCanSeePost($uid, $whoID) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$whoID = mysqli_real_escape_string($this->db, $whoID);
		if ($this->iN_CheckUserExist($uid) == 1) {
			$updateNotificationUser = mysqli_query($this->db, "UPDATE i_users SET post_who_can_see = '$whoID' WHERE iuid = '$uid'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*INSERT UPLOADED FILES FROM UPLOADS TABLE*/
	public function iN_INSERTUploadedFiles($uid, $filePath, $tumbnailPath, $fileXPath, $ext) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$filePath = mysqli_real_escape_string($this->db, $filePath);
		$fileXPath = mysqli_real_escape_string($this->db, $fileXPath);
		$fileExtension = mysqli_real_escape_string($this->db, $ext);
		$uploadTime = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		$query = mysqli_query($this->db, "INSERT INTO i_user_uploads (iuid_fk,uploaded_file_path,upload_tumbnail_file_path,uploaded_x_file_path, uploaded_file_ext,upload_time,ip)VALUES('$uid' ,'$filePath','$tumbnailPath','$fileXPath','$fileExtension','$uploadTime','$userIP')") or die(mysqli_error($this->db));
		$ids = mysqli_insert_id($this->db);
		return $ids;
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedFilesIDs($uid, $imageName) {
		if ($imageName) {
			$query = mysqli_query($this->db, "SELECT upload_id,uploaded_file_path,upload_tumbnail_file_path FROM i_user_uploads WHERE iuid_fk='$uid' ORDER BY upload_id DESC") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*INSERT NEW POST AND GET REAL TIME*/
	public function iN_InsertNewPost($uid, $postText, $urlSlug, $postFiles, $postWhoCanSee, $hashTags, $pointAmount,$autoApprovePostStatus) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$postFiles = mysqli_real_escape_string($this->db, $postFiles);
		$postWhoCanSee = mysqli_real_escape_string($this->db, $postWhoCanSee);
		$time = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		$postStatus = '0';
		if (!empty($postFiles)) {
			$postStatus = '1';
		}
		if ($postWhoCanSee == '4') {
			if($autoApprovePostStatus == 'yes'){
				$postStatus = '2';
			}else{
				$postStatus = '1';
			}
		}
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		$InsertNewPost = mysqli_query($this->db, "INSERT INTO `i_posts`(post_owner_id,post_text,post_file,post_created_time,post_creator_ip,who_can_see,post_status,url_slug,hashtags,post_wanted_credit)VALUES('$uid','$postText','$postFiles','$time','$userIP','$postWhoCanSee','$postStatus','$urlSlug', '$hashTags','$pointAmount')") or die(mysqli_error($this->db));
		$getLatestPost = mysqli_query($this->db, "SELECT P.post_id,P.shared_post_id,P.post_pined,P.post_owner_id,P.post_text,P.hashtags,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.url_slug,P.post_status,P.comment_status,U.payout_method,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.payout_method,U.last_login_time,U.user_verified_status,U.thanks_for_tip
		FROM i_posts P FORCE INDEX(ixForcePostOwner)
			INNER JOIN i_users U FORCE INDEX(ixForceUser)
		    ON P.post_owner_id = U.iuid
		WHERE post_status IN('0','1','2') ORDER BY P.post_id DESC LIMIT 1") or die(mysqli_error($this->db));
		$result = mysqli_fetch_array($getLatestPost, MYSQLI_ASSOC);
		return $result;
	}
	/*Get All Friens and My Posts*/
	public function iN_AllFriendsPosts($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,P.hashtags,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.payout_method,U.last_login_time,U.user_verified_status,U.thanks_for_tip
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')
		WHERE F.fr_one='$uid' $morePost
		ORDER BY P.post_id
		DESC LIMIT $showingPosts ") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	public function iN_AllFriendsPostsOut($lastPostID, $showingPost) {
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = "WHERE P.post_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.hashtags,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender, U.payout_method,U.last_login_time,U.user_verified_status,U.thanks_for_tip
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')
		$morePost
		ORDER BY P.post_id
		DESC LIMIT $showingPosts ") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get Post Comments*/
	public function iN_GetPostComments($postID, $second) {
		$postID = mysqli_real_escape_string($this->db, $postID);
		$query = '';
		if ($second) {$query = "LIMIT $second,2";}
		$DataComments = mysqli_query($this->db, "SELECT C.com_id,C.comment_uid_fk,C.comment_post_id_fk,C.comment,C.comment_time,C.comment_file,C.sticker_url, C.gif_url,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
		FROM i_post_comments C FORCE INDEX(ixComment)
		    INNER JOIN i_users U FORCE INDEX(ixForceUser)
		    ON C.comment_uid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE C.comment_post_id_fk = '$postID' ORDER BY C.com_id ASC $query") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($DataComments, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*GET UPLOADED FILE DATA*/
	public function iN_GetUploadedFileDetails($imageID) {
		if ($imageID) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_uploads WHERE upload_id='$imageID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Relationship between Two Users*/
	public function iN_GetRelationsipBetweenTwoUsers($userOne, $userTwo) {
		$userOne = mysqli_real_escape_string($this->db, $userOne);
		$userTwo = mysqli_real_escape_string($this->db, $userTwo);
		$GetStatus = mysqli_query($this->db, "SELECT fr_status FROM i_friends WHERE fr_one='$userOne' AND fr_two='$userTwo'") or die(mysqli_error($this->db));
		$role = mysqli_fetch_array($GetStatus, MYSQLI_ASSOC);
		return isset($role['fr_status']) ? $role['fr_status'] : NULL;
	}
	/*Check Profile Subscribed Type*/
	public function iN_CheckProfileSubscriptionType($userOne, $userTwo){
		$userOne = mysqli_real_escape_string($this->db, $userOne);
		$userTwo = mysqli_real_escape_string($this->db, $userTwo);
		$GetStatus = mysqli_query($this->db, "SELECT iuid_fk,subscribed_iuid_fk,payment_method,plan_amount FROM i_user_subscriptions WHERE iuid_fk='$userOne' AND subscribed_iuid_fk='$userTwo'") or die(mysqli_error($this->db));
		$role = mysqli_fetch_array($GetStatus, MYSQLI_ASSOC);
		return isset($role['payment_method']) ? $role['payment_method'] : NULL;
	} 
	/*Check User Liked The Post Before*/
	public function iN_CheckPostLikedBefore($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$likedPost = mysqli_real_escape_string($this->db, $postID);
		$checkLikedBefore = mysqli_query($this->db, "SELECT post_id_fk FROM i_post_likes WHERE post_id_fk = '$postID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkLikedBefore) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Check User Liked The Comment Before*/
	public function iN_CheckCommentLikedBefore($userID, $postID, $commentID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$likedPost = mysqli_real_escape_string($this->db, $postID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$checkLikedBefore = mysqli_query($this->db, "SELECT c_like_iuid_fk,c_like_comment_id,c_like_post_id FROM i_post_comment_likes WHERE c_like_post_id = '$postID' AND c_like_iuid_fk = '$userID' AND c_like_comment_id = '$commentID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkLikedBefore) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Like Post*/
	public function iN_LikePost($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$likedPost = mysqli_real_escape_string($this->db, $postID);
		$time = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			if ($this->iN_CheckPostLikedBefore($userID, $postID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_post_likes WHERE post_id_fk = '$postID' AND iuid_fk = '$userID'");
				return false;
			} else {
				mysqli_query($this->db, "INSERT INTO i_post_likes (post_id_fk,iuid_fk,like_time,user_ip) VALUES('$postID','$userID','$time','$userIP')") or die(mysqli_error($this->db));
				return true;
			}
		}
	}
	/*Get All Post Details*/
	public function iN_GetAllPostDetails($postID) {
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckPostIDExist($postID) == '1') {
			$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.url_slug,P.comment_status,P.hashtags,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.post_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.payout_method,U.thanks_for_tip,U.last_login_time,U.user_verified_status,U.profile_status,U.uStatus
			FROM i_friends F FORCE INDEX(ixFriend)
				INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
				ON P.post_owner_id = F.fr_two
				INNER JOIN i_users U FORCE INDEX (ixForceUser)
				ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')
			WHERE P.post_id = '$postID'
			ORDER BY P.post_id") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($getData, MYSQLI_ASSOC);
			return $data;
		} else {return false;}
	}
	/*Re-Share Post*/
	public function iN_ReShare_Post($userID, $postID, $postDetails) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$postDetails = mysqli_real_escape_string($this->db, $postDetails);
		$time = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckPostIDExist($postID) == '1') {
			$insertReSharedPost = mysqli_query($this->db, "
			INSERT INTO i_posts (
				post_owner_id,
				post_text,
				post_created_time,
				shared_post_id,
				post_creator_ip
			)
			SELECT
			'" . mysqli_real_escape_string($this->db, $userID) . "',
			'" . mysqli_real_escape_string($this->db, $postDetails) . "',
			'$time',
			'$postID',
			'$userIP'
			 FROM i_posts WHERE post_id = '$postID'"
			) or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get ALL ICONS*/
	public function iN_GetAllIcons() {
		$queryIcon = mysqli_query($this->db, "SELECT * FROM i_svg_icons") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($queryIcon, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Check File ID EXISTs*/
	public function iN_CheckFileIDExist($fileID) {
		$checkPostisExist = mysqli_query($this->db, "SELECT upload_id FROM i_user_uploads WHERE upload_id = '$fileID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Delete File Before Publish Post*/
	public function iN_DeleteFile($userID, $fileID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$fileID = mysqli_real_escape_string($this->db, $fileID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckFileIDExist($fileID) == '1') {
			mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE upload_id = '$fileID' AND iuid_fk = '$userID'");
			return true;
		} else {
			return false;
		}
	}
	public function iN_fetchDataFromURL($url = '') {
		if (empty($url)) {
			return false;
		}
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		return curl_exec($ch);
	}
	/*URL SLUG*/
	public function url_slugies($str, $options = array()) {
		$str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());
		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => true,
		);
		$options = array_merge($defaults, $options);
		$char_map = array(
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'AE',
			'??' => 'C',
			'??' => 'E',
			'??' => 'E',
			'??' => 'E',
			'??' => 'E',
			'??' => 'I',
			'??' => 'I',
			'??' => 'I',
			'??' => 'I',
			'??' => 'D',
			'??' => 'N',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'U',
			'??' => 'U',
			'??' => 'U',
			'??' => 'U',
			'??' => 'U',
			'??' => 'Y',
			'??' => 'TH',
			'??' => 'ss',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'ae',
			'??' => 'c',
			'??' => 'e',
			'??' => 'e',
			'??' => 'e',
			'??' => 'e',
			'??' => 'i',
			'??' => 'i',
			'??' => 'i',
			'??' => 'i',
			'??' => 'd',
			'??' => 'n',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'u',
			'??' => 'u',
			'??' => 'u',
			'??' => 'u',
			'??' => 'u',
			'??' => 'y',
			'??' => 'th',
			'??' => 'y',
			'??' => '(c)',
			'??' => 'A',
			'??' => 'B',
			'??' => 'G',
			'??' => 'D',
			'??' => 'E',
			'??' => 'Z',
			'??' => 'H',
			'??' => '8',
			'??' => 'I',
			'??' => 'K',
			'??' => 'L',
			'??' => 'M',
			'??' => 'N',
			'??' => '3',
			'??' => 'O',
			'??' => 'P',
			'??' => 'R',
			'??' => 'S',
			'??' => 'T',
			'??' => 'Y',
			'??' => 'F',
			'??' => 'X',
			'??' => 'PS',
			'??' => 'W',
			'??' => 'A',
			'??' => 'E',
			'??' => 'I',
			'??' => 'O',
			'??' => 'Y',
			'??' => 'H',
			'??' => 'W',
			'??' => 'I',
			'??' => 'Y',
			'??' => 'a',
			'??' => 'b',
			'??' => 'g',
			'??' => 'd',
			'??' => 'e',
			'??' => 'z',
			'??' => 'h',
			'??' => '8',
			'??' => 'i',
			'??' => 'k',
			'??' => 'l',
			'??' => 'm',
			'??' => 'n',
			'??' => '3',
			'??' => 'o',
			'??' => 'p',
			'??' => 'r',
			'??' => 's',
			'??' => 't',
			'??' => 'y',
			'??' => 'f',
			'??' => 'x',
			'??' => 'ps',
			'??' => 'w',
			'??' => 'a',
			'??' => 'e',
			'??' => 'i',
			'??' => 'o',
			'??' => 'y',
			'??' => 'h',
			'??' => 'w',
			'??' => 's',
			'??' => 'i',
			'??' => 'y',
			'??' => 'y',
			'??' => 'i',
			'??' => 'S',
			'??' => 'I',
			'??' => 'C',
			'??' => 'U',
			'??' => 'O',
			'??' => 'G',
			'??' => 's',
			'??' => 'i',
			'??' => 'c',
			'??' => 'u',
			'??' => 'o',
			'??' => 'g',
			'??' => 'A',
			'??' => 'B',
			'??' => 'V',
			'??' => 'G',
			'??' => 'D',
			'??' => 'E',
			'??' => 'Yo',
			'??' => 'Zh',
			'??' => 'Z',
			'??' => 'I',
			'??' => 'J',
			'??' => 'K',
			'??' => 'L',
			'??' => 'M',
			'??' => 'N',
			'??' => 'O',
			'??' => 'P',
			'??' => 'R',
			'??' => 'S',
			'??' => 'T',
			'??' => 'U',
			'??' => 'F',
			'??' => 'H',
			'??' => 'C',
			'??' => 'Ch',
			'??' => 'Sh',
			'??' => 'Sh',
			'??' => '',
			'??' => 'Y',
			'??' => '',
			'??' => 'E',
			'??' => 'Yu',
			'??' => 'Ya',
			'??' => 'a',
			'??' => 'b',
			'??' => 'v',
			'??' => 'g',
			'??' => 'd',
			'??' => 'e',
			'??' => 'yo',
			'??' => 'zh',
			'??' => 'z',
			'??' => 'i',
			'??' => 'j',
			'??' => 'k',
			'??' => 'l',
			'??' => 'm',
			'??' => 'n',
			'??' => 'o',
			'??' => 'p',
			'??' => 'r',
			'??' => 's',
			'??' => 't',
			'??' => 'u',
			'??' => 'f',
			'??' => 'h',
			'??' => 'c',
			'??' => 'ch',
			'??' => 'sh',
			'??' => 'sh',
			'??' => '',
			'??' => 'y',
			'??' => '',
			'??' => 'e',
			'??' => 'yu',
			'??' => 'ya',
			'??' => 'Ye',
			'??' => 'I',
			'??' => 'Yi',
			'??' => 'G',
			'??' => 'ye',
			'??' => 'i',
			'??' => 'yi',
			'??' => 'g',
			'??' => 'C',
			'??' => 'D',
			'??' => 'E',
			'??' => 'N',
			'??' => 'R',
			'??' => 'S',
			'??' => 'T',
			'??' => 'U',
			'??' => 'Z',
			'??' => 'c',
			'??' => 'd',
			'??' => 'e',
			'??' => 'n',
			'??' => 'r',
			'??' => 's',
			'??' => 't',
			'??' => 'u',
			'??' => 'z',
			'??' => 'A',
			'??' => 'C',
			'??' => 'e',
			'??' => 'L',
			'??' => 'N',
			'??' => 'o',
			'??' => 'S',
			'??' => 'Z',
			'??' => 'Z',
			'??' => 'a',
			'??' => 'c',
			'??' => 'e',
			'??' => 'l',
			'??' => 'n',
			'??' => 'o',
			'??' => 's',
			'??' => 'z',
			'??' => 'z',
			'??' => 'A',
			'??' => 'C',
			'??' => 'E',
			'??' => 'G',
			'??' => 'i',
			'??' => 'k',
			'??' => 'L',
			'??' => 'N',
			'??' => 'S',
			'??' => 'u',
			'??' => 'Z',
			'??' => 'a',
			'??' => 'c',
			'??' => 'e',
			'??' => 'g',
			'??' => 'i',
			'??' => 'k',
			'??' => 'l',
			'??' => 'n',
			'??' => 's',
			'??' => 'u',
			'??' => 'z',
		);
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}
	public function url_Hash($str, $options = array()) {
		$str = mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings());
		$defaults = array(
			'delimiter' => ',',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => true,
		);
		$options = array_merge($defaults, $options);
		$char_map = array(
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'A',
			'??' => 'AE',
			'??' => 'C',
			'??' => 'E',
			'??' => 'E',
			'??' => 'E',
			'??' => 'E',
			'??' => 'I',
			'??' => 'I',
			'??' => 'I',
			'??' => 'I',
			'??' => 'D',
			'??' => 'N',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'O',
			'??' => 'U',
			'??' => 'U',
			'??' => 'U',
			'??' => 'U',
			'??' => 'U',
			'??' => 'Y',
			'??' => 'TH',
			'??' => 'ss',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'a',
			'??' => 'ae',
			'??' => 'c',
			'??' => 'e',
			'??' => 'e',
			'??' => 'e',
			'??' => 'e',
			'??' => 'i',
			'??' => 'i',
			'??' => 'i',
			'??' => 'i',
			'??' => 'd',
			'??' => 'n',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'o',
			'??' => 'u',
			'??' => 'u',
			'??' => 'u',
			'??' => 'u',
			'??' => 'u',
			'??' => 'y',
			'??' => 'th',
			'??' => 'y',
			'??' => '(c)',
			'??' => 'A',
			'??' => 'B',
			'??' => 'G',
			'??' => 'D',
			'??' => 'E',
			'??' => 'Z',
			'??' => 'H',
			'??' => '8',
			'??' => 'I',
			'??' => 'K',
			'??' => 'L',
			'??' => 'M',
			'??' => 'N',
			'??' => '3',
			'??' => 'O',
			'??' => 'P',
			'??' => 'R',
			'??' => 'S',
			'??' => 'T',
			'??' => 'Y',
			'??' => 'F',
			'??' => 'X',
			'??' => 'PS',
			'??' => 'W',
			'??' => 'A',
			'??' => 'E',
			'??' => 'I',
			'??' => 'O',
			'??' => 'Y',
			'??' => 'H',
			'??' => 'W',
			'??' => 'I',
			'??' => 'Y',
			'??' => 'a',
			'??' => 'b',
			'??' => 'g',
			'??' => 'd',
			'??' => 'e',
			'??' => 'z',
			'??' => 'h',
			'??' => '8',
			'??' => 'i',
			'??' => 'k',
			'??' => 'l',
			'??' => 'm',
			'??' => 'n',
			'??' => '3',
			'??' => 'o',
			'??' => 'p',
			'??' => 'r',
			'??' => 's',
			'??' => 't',
			'??' => 'y',
			'??' => 'f',
			'??' => 'x',
			'??' => 'ps',
			'??' => 'w',
			'??' => 'a',
			'??' => 'e',
			'??' => 'i',
			'??' => 'o',
			'??' => 'y',
			'??' => 'h',
			'??' => 'w',
			'??' => 's',
			'??' => 'i',
			'??' => 'y',
			'??' => 'y',
			'??' => 'i',
			'??' => 'S',
			'??' => 'I',
			'??' => 'C',
			'??' => 'U',
			'??' => 'O',
			'??' => 'G',
			'??' => 's',
			'??' => 'i',
			'??' => 'c',
			'??' => 'u',
			'??' => 'o',
			'??' => 'g',
			'??' => 'A',
			'??' => 'B',
			'??' => 'V',
			'??' => 'G',
			'??' => 'D',
			'??' => 'E',
			'??' => 'Yo',
			'??' => 'Zh',
			'??' => 'Z',
			'??' => 'I',
			'??' => 'J',
			'??' => 'K',
			'??' => 'L',
			'??' => 'M',
			'??' => 'N',
			'??' => 'O',
			'??' => 'P',
			'??' => 'R',
			'??' => 'S',
			'??' => 'T',
			'??' => 'U',
			'??' => 'F',
			'??' => 'H',
			'??' => 'C',
			'??' => 'Ch',
			'??' => 'Sh',
			'??' => 'Sh',
			'??' => '',
			'??' => 'Y',
			'??' => '',
			'??' => 'E',
			'??' => 'Yu',
			'??' => 'Ya',
			'??' => 'a',
			'??' => 'b',
			'??' => 'v',
			'??' => 'g',
			'??' => 'd',
			'??' => 'e',
			'??' => 'yo',
			'??' => 'zh',
			'??' => 'z',
			'??' => 'i',
			'??' => 'j',
			'??' => 'k',
			'??' => 'l',
			'??' => 'm',
			'??' => 'n',
			'??' => 'o',
			'??' => 'p',
			'??' => 'r',
			'??' => 's',
			'??' => 't',
			'??' => 'u',
			'??' => 'f',
			'??' => 'h',
			'??' => 'c',
			'??' => 'ch',
			'??' => 'sh',
			'??' => 'sh',
			'??' => '',
			'??' => 'y',
			'??' => '',
			'??' => 'e',
			'??' => 'yu',
			'??' => 'ya',
			'??' => 'Ye',
			'??' => 'I',
			'??' => 'Yi',
			'??' => 'G',
			'??' => 'ye',
			'??' => 'i',
			'??' => 'yi',
			'??' => 'g',
			'??' => 'C',
			'??' => 'D',
			'??' => 'E',
			'??' => 'N',
			'??' => 'R',
			'??' => 'S',
			'??' => 'T',
			'??' => 'U',
			'??' => 'Z',
			'??' => 'c',
			'??' => 'd',
			'??' => 'e',
			'??' => 'n',
			'??' => 'r',
			'??' => 's',
			'??' => 't',
			'??' => 'u',
			'??' => 'z',
			'??' => 'A',
			'??' => 'C',
			'??' => 'e',
			'??' => 'L',
			'??' => 'N',
			'??' => 'o',
			'??' => 'S',
			'??' => 'Z',
			'??' => 'Z',
			'??' => 'a',
			'??' => 'c',
			'??' => 'e',
			'??' => 'l',
			'??' => 'n',
			'??' => 'o',
			'??' => 's',
			'??' => 'z',
			'??' => 'z',
			'??' => 'A',
			'??' => 'C',
			'??' => 'E',
			'??' => 'G',
			'??' => 'i',
			'??' => 'k',
			'??' => 'L',
			'??' => 'N',
			'??' => 'S',
			'??' => 'u',
			'??' => 'Z',
			'??' => 'a',
			'??' => 'c',
			'??' => 'e',
			'??' => 'g',
			'??' => 'i',
			'??' => 'k',
			'??' => 'l',
			'??' => 'n',
			'??' => 's',
			'??' => 'u',
			'??' => 'z',
		);
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}
	public function iN_GetIPAddress() {
		if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED'])) {
			return $_SERVER['HTTP_X_FORWARDED'];
		}

		if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		}

		if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_FORWARDED_FOR'];
		}

		if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED'])) {
			return $_SERVER['HTTP_FORWARDED'];
		}

		return $_SERVER['REMOTE_ADDR'];
	}
	public function iN_getHost($url) {
		$parseUrl = parse_url(trim($url));
		if (isset($parseUrl['host'])) {
			$host = $parseUrl['host'];
		} else {
			$path = explode('/', $parseUrl['path']);
			$host = $path[0];
		}
		return trim($host);
	}
	public function SlugPost($string) {
		$slug = $this->url_slugies($string, array(
			'delimiter' => '-',
			'limit' => 80,
			'lowercase' => true,
			'replacements' => array(
				'/\b(an)\b/i' => 'a',
				'/\b(example)\b/i' => 'Test',
			),
		));
		return $slug;
	}
	public function sanitize_output($buffer, $base_url) {
		//$base_url = '';
		$search = array(
			'/\>[^\S ]+/s',
			'/[^\S ]+\</s',
			'/(\s)+/s',
			'/<!--(.|\s)*?-->/',
		);
		$replace = array(
			'>',
			'<',
			'\\1',
			'',
		);

		$buffer = preg_replace($search, $replace, $buffer);

		$buffer = $this->iN_GetTheMentions($buffer, $base_url);

		$buffer = $this->iN_MakeHashLink($buffer, $base_url);

		return $buffer;
	}
	public function iN_MakeHashLink($orimessage, $base_url) {
		$message = $orimessage;
		$regex = '/#([^`~!@$%^&*\#()\-+=\\|\/\.,<>?\'\":;{}\[\]* ]+)/i';
		$background_colors = array('#e53935', '#d81b60', '#8e24aa', '#5e35b1', '#3949ab', '#1e88e5', '#00acc1', '#6d4c41', '#546e7a');

		$rand_background = $background_colors[array_rand($background_colors)];
		$message = preg_replace($regex, '<a href="' . $base_url . 'hashtag/$1" class="hshCl" style="color:' . $rand_background . '">$0</a>', $message);
		return $message;
	}
	public function iN_GetTheMentions($content, $base_url) { 

		if (preg_match_all("/\B@\K[\w-]+/", $content, $matches)) {
			if (!$result = mysqli_query($this->db, "SELECT iuid, i_username, i_user_fullname FROM i_users WHERE i_username  IN ('" . implode("','", $matches[0]) . "')")) {
				// error
			} else { 
				foreach ($result as $row) {
					$background_colors = array('deeppink', 'crimson', 'gold', 'magenta', 'darkorchid', 'limegreen', 'darkturquoise', 'dodgerblue', 'lightslategray');
                    $rand_background = $background_colors[array_rand($background_colors)];
					$content = preg_replace("~\B@{$row["i_username"]}\b~", "<a href=\"{$base_url}{$row["i_username"]}\" class=\"mention_ show_card\" id=\"{$row["iuid"]}\" data-user=\"{$row["i_username"]}\" data-type=\"userCard\" style=\"color:{$rand_background}\">@{$row["i_username"]}</a>", $content);
				}
			}
		}
		return $content;
	}
	public function iN_hashtag($orimessage) {
		preg_match_all('/#+(\w+)/u', $orimessage, $matched_hashtag);
		$hashtag = '';
		if (!empty($matched_hashtag[0])) {
			foreach ($matched_hashtag[0] as $matched) {
				$hashtag .= preg_replace('/[^\p{L}0-9\s]+/u', '', $matched) . ',';
			}
		}
		return rtrim($hashtag, ',');
	}
	public function iN_Secure($string, $censored_words = 1, $br = true, $strip = 0) {
		$string = trim($string);
		$string = $this->iN_cleanString($string);
		$string = htmlspecialchars($string, ENT_QUOTES);
		if ($br == true) {
			$string = str_replace('\r\n', " <br>", $string);
			$string = str_replace('\n\r', " <br>", $string);
			$string = str_replace('\r', " <br>", $string);
			$string = str_replace('\n', " <br>", $string);
		} else {
			$string = str_replace('\r\n', "", $string);
			$string = str_replace('\n\r', "", $string);
			$string = str_replace('\r', "", $string);
			$string = str_replace('\n', "", $string);
		}
		if ($strip == 1) {
			$string = stripslashes($string);
		}
		$string = str_replace('&amp;#', '&#', $string); 
		$string = str_replace('&#039;', "'", $string);
		
		return $string;
	}
	public function iN_cleanString($string) {
		return $string = preg_replace("/&#?[a-z0-9]+;/i", "", $string);
	}
	/*Random*/
	public function random_code($length) {
		return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
	}
	function iN_BbcodeSecure($string) {
		$string = trim($string);
		$string = htmlspecialchars($string, ENT_QUOTES);
		$string = str_replace('\r\n', "[nl]", $string);
		$string = str_replace('\n\r', "[nl]", $string);
		$string = str_replace('\r', "[nl]", $string);
		$string = str_replace('\n', "[nl]", $string);
		$string = str_replace('&amp;#', '&#', $string);
		$string = strip_tags($string);
		$string = stripslashes($string);
		return $string;
	}
	public function iN_Decode($string) {
		return htmlspecialchars_decode($string);
	}
	public function iN_strip_unsafe($string, $img = false) {
		$unsafe = array(
			'/<iframe(.*?)<\/iframe>/is',
			'/<title(.*?)<\/title>/is',
			'/<pre(.*?)<\/pre>/is',
			'/<frame(.*?)<\/frame>/is',
			'/<frameset(.*?)<\/frameset>/is',
			'/<object(.*?)<\/object>/is',
			'/<script(.*?)<\/script>/is',
			'/<embed(.*?)<\/embed>/is',
			'/<applet(.*?)<\/applet>/is',
			'/<meta(.*?)>/is',
			'/<!doctype(.*?)>/is',
			'/<link(.*?)>/is',
			'/<body(.*?)>/is',
			'/<\/body>/is',
			'/<head(.*?)>/is',
			'/<\/head>/is',
			'/onload="(.*?)"/is',
			'/onunload="(.*?)"/is',
			'/<html(.*?)>/is',
			'/<\/html>/is');
		if ($img == true) {
			$unsafe[] = '/<img(.*?)>/is';
		}
		$string = preg_replace($unsafe, "", $string);

		return $string;
	}
	public function br2nl($st) {
		$breaks = array(
			"\r\n",
			"\r",
			"\n",
		);
		$st = str_replace($breaks, "", $st);
		$st_no_lb = preg_replace("/\r|\n/", "", $st);
		return preg_replace('/<br(\s+)?\/?>/i', "\r", $st_no_lb);
	}
	public function br2nlf($st) {
		$breaks = array(
			"\r\n",
			"\r",
			"\n",
		);
		$st = str_replace($breaks, "", $st);
		$st_no_lb = preg_replace("/\r|\n/", "", $st);
		$st = preg_replace('/<br(\s+)?\/?>/i', "\r", $st_no_lb);
		return str_replace('[nl]', "\r", $st);
	}
	public function isDate($string) {
		$matches = array();
		$pattern = '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/';
		if (!preg_match($pattern, $string, $matches)) {
			return false;
		}

		if (!checkdate($matches[2], $matches[1], $matches[3])) {
			return false;
		}

		return true;
	}
	public function iN_CorrectDateFormat($bdate) {
		$date = str_replace('/', '-', $bdate);
		if($date){
			$correct = date('Y-m-d', strtotime($date));
		} 
		return $correct;
	}
	/*Update Who Can See Post Status*/
	public function iN_UpdatePostWhoCanSee($userID, $postID, $WhoCS) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$WhoCS = mysqli_real_escape_string($this->db, $WhoCS);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckPostIDExist($postID) == '1') {
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$updateNotificationUser = mysqli_query($this->db, "UPDATE i_posts SET who_can_see = '$WhoCS' WHERE post_id = '$postID'") or die(mysqli_error($this->db));
				return true;
			} else {
				$updateNotificationUser = mysqli_query($this->db, "UPDATE i_posts SET who_can_see = '$WhoCS' WHERE post_owner_id = '$userID' AND post_id = '$postID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false; 
		}
	}
	/*Save Update Post Text*/
	public function iN_UpdatePost($userID, $postID, $editedText, $hashTags, $editSlug) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$updateNotificationUser = mysqli_query($this->db, "UPDATE i_posts SET post_text = '$editedText', url_slug = '$editSlug', hashtags = '$hashTags' WHERE post_id = '$postID'") or die(mysqli_error($this->db));
				return true;
			} else {
				$updateNotificationUser = mysqli_query($this->db, "UPDATE i_posts SET post_text = '$editedText', url_slug = '$editSlug' , hashtags = '$hashTags' WHERE post_owner_id = '$userID' AND post_id = '$postID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Delete Post From Data*/
	public function iN_DeletePost($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$getPostFileIDs = $this->iN_GetAllPostDetails($postID);
			$postFileIDs = isset($getPostFileIDs['post_file']) ? $getPostFileIDs['post_file'] : NULL;
    		$checkS3Status = mysqli_query($this->db, "SELECT * FROM i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
    		$s3 = mysqli_fetch_array($checkS3Status, MYSQLI_ASSOC); 
    		$s3Status = $s3['s3_status'];
    		$oceanStatus = $s3['ocean_status']; 
			if ($postFileIDs && $s3Status != '1' && $oceanStatus != '1') {
				$trimValue = rtrim($postFileIDs, ',');
				$explodeFiles = explode(',', $trimValue);
				$explodeFiles = array_unique($explodeFiles);
				foreach ($explodeFiles as $explodeFile) {
					$theFileID = $this->iN_GetUploadedFileDetails($explodeFile);
					$uploadedFileID = $theFileID['upload_id'];
					$uploadedFilePath = $theFileID['uploaded_file_path'];
					$uploadedTumbnailFilePath = $theFileID['upload_tumbnail_file_path'];
					$uploadedFilePathX = $theFileID['uploaded_x_file_path'];
					@unlink('../' . $uploadedFilePath);
					@unlink('../' . $uploadedFilePathX);
					@unlink('../' . $uploadedTumbnailFilePath);
					mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE upload_id = '$uploadedFileID' AND iuid_fk = '$userID'");
				}
			}
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_posts WHERE post_id = '$postID'");
				return true;
			} else {
				mysqli_query($this->db, "DELETE FROM i_posts WHERE post_id = '$postID' AND post_owner_id = '$userID'");
				return true;
			}
		} else {
			return false;
		}
	}
	public function iN_DeletePostAdmin($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$getPostFileIDs = $this->iN_GetAllPostDetails($postID);
			$postFileIDs = isset($getPostFileIDs['post_file']) ? $getPostFileIDs['post_file'] : NULL;
    		$checkS3Status = mysqli_query($this->db, "SELECT * FROM i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
    		$s3 = mysqli_fetch_array($checkS3Status, MYSQLI_ASSOC); 
    		$s3Status = $s3['s3_status'];
    		$oceanStatus = $s3['ocean_status']; 
			if ($postFileIDs && $s3Status != '1' && $oceanStatus != '1') {
				$trimValue = rtrim($postFileIDs, ',');
				$explodeFiles = explode(',', $trimValue);
				$explodeFiles = array_unique($explodeFiles);
				foreach ($explodeFiles as $explodeFile) {
					$theFileID = $this->iN_GetUploadedFileDetails($explodeFile);
					$uploadedFileID = $theFileID['upload_id'];
					$uploadedFilePath = $theFileID['uploaded_file_path'];
					$uploadedTumbnailFilePath = $theFileID['upload_tumbnail_file_path'];
					$uploadedFilePathX = $theFileID['uploaded_x_file_path'];
					@unlink('../' . $uploadedFilePath);
					@unlink('../' . $uploadedFilePathX);
					@unlink('../' . $uploadedTumbnailFilePath);
					mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE upload_id = '$uploadedFileID'");
				}
			}
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_posts WHERE post_id = '$postID'");
				return true;
			}
		} else {
			return false;
		}
	}
	/*Delete Post From Data if Storage Deleting*/
	public function iN_DeletePostFromDataifStorage($userID, $postID){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_posts WHERE post_id = '$postID' AND post_owner_id = '$userID'");
			return true;
		} else {
			return false;
		}
	}
	public function iN_DeletePostFromDataifStorageAdmin($userID, $postID){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_posts WHERE post_id = '$postID'");
			return true;
		} else {
			return false;
		}
	}
	public function htmlcode($orimessage) {
		$message = preg_replace("/\r\n|\r|\n/", ' ', $orimessage);
		$s = array("<", ">");
		$z = array("&lt;", "&gt;");
		$message = str_replace($s, $z, $message);
		$message = trim(str_replace("\\n", "<br/>", $message));
		$message = preg_replace('/(<br\s*\/?\s*>\s*)*(<br\s*\/?\s*>)/', '<br>', $message);

		return htmlspecialchars(stripslashes($message), ENT_QUOTES, "UTF-8");
	}
	/*Get All Post Details*/
	public function iN_GetSuggestedPostByUser($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.url_slug,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.post_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status,U.profile_status
			FROM i_friends F FORCE INDEX(ixFriend)
				INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
				ON P.post_owner_id = F.fr_two
				INNER JOIN i_users U FORCE INDEX (ixForceUser)
				ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber') AND P.post_file IS NOT NULL AND P.post_file <> ''
			WHERE P.post_owner_id = '$userID' AND P.post_id <> '$postID'
			ORDER BY P.post_id DESC LIMIT 6") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($getData, MYSQLI_ASSOC)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		} else {return false;}
	}
	/*Check Post Comment Status*/
	public function iN_CheckPostCommentStatus($postID) {
		$postID = mysqli_real_escape_string($this->db, $postID);
		$commentStatus = mysqli_query($this->db, "SELECT comment_status FROM i_posts WHERE post_id = '$postID'") or die(mysqli_error($this->db));
		$cStatus = mysqli_fetch_array($commentStatus, MYSQLI_ASSOC);
		return $cStatus['comment_status'];
	}
	/*Check Post Pin Status*/
	public function iN_CheckPostPinStatus($postID) {
		$postID = mysqli_real_escape_string($this->db, $postID);
		$pinStatus = mysqli_query($this->db, "SELECT post_pined FROM i_posts WHERE post_id = '$postID'") or die(mysqli_error($this->db));
		$piStatus = mysqli_fetch_array($pinStatus, MYSQLI_ASSOC);
		return $piStatus['post_pined'];
	}
	/*Check Post Reported Before*/
	public function iN_CheckPostReportedBefore($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$checkPostReportStatus = mysqli_query($this->db, "SELECT reported_post, iuid_fk FROM i_post_reports WHERE reported_post = '$postID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostReportStatus) == 1) {
			return true;
		} else {return false;}
	}
	/*Check Post Saved Before*/
	public function iN_CheckPostSavedBefore($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$checkPostReportStatus = mysqli_query($this->db, "SELECT saved_post_id, iuid_fk FROM i_saved_posts WHERE saved_post_id = '$postID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostReportStatus) == 1) {
			return true;
		} else {return false;}
	}
	/*Check Post OWNER status*/
	public function iN_CheckPostOwnerStatus($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$checkOwnerStatus = mysqli_query($this->db, "SELECT post_id, post_owner_id FROM i_posts WHERE post_id = '$postID' AND post_owner_id = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkOwnerStatus) == 1) {
			return true;
		} else {return false;}
	}
	/*Update Post Comment Status*/
	public function iN_UpdatePostCommentStatus($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			if ($this->iN_CheckPostCommentStatus($postID) == '1') {
				$cStatus = '0';
			} else {
				$cStatus = '1';
			}
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$updateCommentStatus = mysqli_query($this->db, "UPDATE i_posts SET comment_status = '$cStatus' WHERE post_id = '$postID'") or die(mysqli_error($this->db));
				return $this->iN_CheckPostCommentStatus($postID);
			} else {
				$updateCommentStatus = mysqli_query($this->db, "UPDATE i_posts SET comment_status = '$cStatus' WHERE post_owner_id = '$userID' AND post_id = '$postID'") or die(mysqli_error($this->db));
				return $this->iN_CheckPostCommentStatus($postID);
			}
		} else {return false;}
	}
	/*Pin Post*/
	public function iN_UpdatePostPinedStatus($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			if ($this->iN_CheckPostPinStatus($postID) == '1') {
				$pin_Status = '0';
			} else {
				$pin_Status = '1';
			}
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$updatePostPinStatus = mysqli_query($this->db, "UPDATE i_posts SET post_pined = '$pin_Status' WHERE post_id = '$postID'") or die(mysqli_error($this->db));
				return $this->iN_CheckPostPinStatus($postID);
			} else {
				$updatePostPinStatus = mysqli_query($this->db, "UPDATE i_posts SET post_pined = '$pin_Status' WHERE post_owner_id = '$userID' AND post_id = '$postID'") or die(mysqli_error($this->db));
				return $this->iN_CheckPostPinStatus($postID);
			}
		} else {return false;}
	}
	/*Report Post*/
	public function iN_InsertReportedPost($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$time = time();
			if ($this->iN_CheckPostReportedBefore($userID, $postID) == 1) {
				$Unreport = mysqli_query($this->db, "DELETE FROM i_post_reports WHERE reported_post = '$postID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
				return 'un';
			} else {
				$insertReport = mysqli_query($this->db, "INSERT INTO i_post_reports(reported_post, iuid_fk, report_time)VALUES('$postID','$userID','$time')") or die(mysqli_error($this->db));
				return 'rep';
			}
		} else {return false;}
	}
	/*Save Post in Saved List*/
	public function iN_SavePostInSavedList($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$time = time();
			if ($this->iN_CheckPostSavedBefore($userID, $postID) == 1) {
				$UnSavePost = mysqli_query($this->db, "DELETE FROM i_saved_posts WHERE saved_post_id = '$postID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
				return 'unsp';
			} else {
				$savePost = mysqli_query($this->db, "INSERT INTO i_saved_posts(saved_post_id, iuid_fk, saved_time)VALUES('$postID','$userID','$time')") or die(mysqli_error($this->db));
				return 'svp';
			}
		} else {return false;}
	}
	/*Check Sticker ID Exist*/
	public function iN_CheckStickerIDExist($stickerID) {
		$stickerID = mysqli_real_escape_string($this->db, $stickerID);
		$CheckSticker = mysqli_query($this->db, "SELECT sticker_id FROM i_stickers WHERE sticker_id = '$stickerID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($CheckSticker) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Insert New Comment*/
	public function iN_insertNewComment($userID, $postID, $comment, $stickerID, $gifUrl) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$stickerID = mysqli_real_escape_string($this->db, $stickerID);
		$gifUrl = mysqli_real_escape_string($this->db, $gifUrl);
		$get = $this->iN_GetAllPostDetails($postID);
		$checkUser_Blocked = $this->iN_CheckUserBlocked($get['post_owner_id'], $userID);
		$commenterBlockedPostOwner = $this->iN_CheckUserBlocked($userID, $get['post_owner_id']);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1 && $checkUser_Blocked != 1 && $commenterBlockedPostOwner != 1) {
			$dataStickerUrl = '';
			$dataGifUrl = '';
			if ($stickerID) {
				if ($this->iN_CheckStickerIDExist($stickerID) == 1) {
					$stickerURL = $this->iN_getSticker($stickerID);
					$dataStickerUrl = $stickerURL['sticker_url'];
				} else {
					return false;
				}
			} else {
				if ($gifUrl) {
					$dataGifUrl = $gifUrl;
					$dataStickerUrl = '';
				}
			}
			$time = time(); 
		    mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		    mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$insertNewComment = mysqli_query($this->db, "INSERT INTO i_post_comments(comment_post_id_fk,comment_uid_fk,comment_time,comment, sticker_url, gif_url)VALUES('$postID','$userID','$time','$comment', '$dataStickerUrl','$dataGifUrl')") or die(mysqli_error($this->db));
			} else {
				/*Check Post Comment Status*/
				if ($this->iN_CheckPostCommentStatus($postID) == 1) {
					$insertNewComment = mysqli_query($this->db, "INSERT INTO i_post_comments(comment_post_id_fk,comment_uid_fk,comment_time,comment, sticker_url, gif_url)VALUES('$postID','$userID','$time','$comment','$dataStickerUrl','$dataGifUrl')") or die(mysqli_error($this->db));
				} else if ($this->iN_CheckPostOwnerStatus($userID, $postID) == 1) {
					$insertNewComment = mysqli_query($this->db, "INSERT INTO i_post_comments(comment_post_id_fk,comment_uid_fk,comment_time,comment, sticker_url, gif_url)VALUES('$postID','$userID','$time','$comment','$dataStickerUrl','$dataGifUrl')") or die(mysqli_error($this->db));
				}
			}
			if ($insertNewComment) {
				$DataComments = mysqli_query($this->db, "SELECT
				C.com_id,C.comment_uid_fk,C.comment_post_id_fk,C.comment,C.comment_time,C.comment_file,C.sticker_url,C.gif_url,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status,U.i_user_email
				FROM i_post_comments C FORCE INDEX(ixComment)
				INNER JOIN i_users U FORCE INDEX(ixForceUser) ON C.comment_uid_fk = U.iuid AND U.uStatus IN('1','3')
				WHERE C.comment_post_id_fk = '$postID' AND C.comment_uid_fk = '$userID' ORDER BY C.com_id DESC LIMIT 1") or die(mysqli_error($this->db));
				$data = mysqli_fetch_array($DataComments, MYSQLI_ASSOC);
				return $data;
			} else {
				return false;
			}

		} else {return false;}
	}
	/*Like Post Comment*/
	public function iN_LikePostComment($userID, $postID, $commentID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$likedPost = mysqli_real_escape_string($this->db, $postID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$time = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			if ($this->iN_CheckCommentLikedBefore($userID, $postID, $commentID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_post_comment_likes WHERE c_like_post_id = '$postID' AND c_like_iuid_fk = '$userID' AND c_like_comment_id = '$commentID'");
				return false;
			} else {
				mysqli_query($this->db, "INSERT INTO i_post_comment_likes (c_like_post_id,c_like_iuid_fk,c_like_comment_id,c_like_time)VALUES('$postID','$userID','$commentID','$time')") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Get Comment Owner ID From Liked Post ID*/
	public function iN_GetUserIDFromLikedPostID($commentID) {
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$query = mysqli_query($this->db, "SELECT * FROM i_post_comments WHERE com_id = '$commentID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $data;
	}
	/*Comment Like Count*/
	public function iN_TotalCommentLiked($commentID) {
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$CountCommentLike = mysqli_query($this->db, "SELECT COUNT(*) AS commentLikeCount FROM i_post_comment_likes WHERE c_like_comment_id = '$commentID'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($CountCommentLike, MYSQLI_ASSOC);
		return isset($row['commentLikeCount']) ? $row['commentLikeCount'] : '0';
	}
	/*Comment Like Count*/
	public function iN_TotalPostLiked($postID) {
		$postID = mysqli_real_escape_string($this->db, $postID);
		$CountPostLike = mysqli_query($this->db, "SELECT COUNT(*) AS postLikeCount FROM i_post_likes WHERE post_id_fk = '$postID'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($CountPostLike, MYSQLI_ASSOC);
		return $row['postLikeCount'];
	}
	/*Check Notification Inserted Before For Comment For Same User*/
	public function iN_CheckNotificationLikeInsertedBeforeForComment($userID, $commentID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$check = mysqli_query($this->db, "SELECT not_iuid, not_post_id, not_comment_id FROM i_user_notifications WHERE not_iuid = '$userID' AND not_post_id = '$postID' AND not_comment_id = '$commentID' AND not_not_type = 'commentLike'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($check) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Check Notification Inserted Before For Comment For Same User*/
	public function iN_CheckNotificationInsertedBeforePostLike($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$check = mysqli_query($this->db, "SELECT not_iuid, not_post_id FROM i_user_notifications WHERE not_iuid = '$userID' AND not_post_id = '$postID' AND not_not_type = 'postLike'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($check) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Check User Liked Comment Before*/
	public function iN_CheckUserLikedCommentBefore($userID, $commentID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$check = mysqli_query($this->db, "SELECT c_like_iuid_fk, c_like_comment_id FROM i_post_comment_likes WHERE c_like_iuid_fk = '$userID' AND c_like_comment_id = '$commentID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($check) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Get Comment Details*/
	public function iN_GetCommentDetails($commendID) {
		$getData = mysqli_query($this->db, "SELECT * FROM i_post_comments WHERE com_id = '$commendID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($getData, MYSQLI_ASSOC);
		return $data;
	}
	/*Insert Comment Notification*/
	public function iN_insertCommentLikeNotification($userID, $postID, $commentID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$postData = $this->iN_GetAllPostDetails($postID);
		$postFile = isset($postData['post_file']) ? $postData['post_file'] : NULL;
		$postOwnerID = isset($postData['post_owner_id']) ? $postData['post_owner_id'] : NULL;
		$comData = $this->iN_GetCommentDetails($commentID);
		$commentOwnerID = isset($comData['comment_uid_fk']) ? $comData['comment_uid_fk'] : NULL;
		if ($postFile) {
			$notType = 'image';
		} else {
			$notType = 'text';
		}
		$time = time();
		if ($this->iN_CheckNotificationLikeInsertedBeforeForComment($userID, $commentID, $postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$userID' AND not_post_id = '$postID' AND not_comment_id = '$commentID'") or die(mysqli_error($this->db));
			return false;
		} else if ($this->iN_CheckUserLikedCommentBefore($commentOwnerID, $commentID) != '1') {
			mysqli_query($this->db, "INSERT INTO i_user_notifications (not_iuid, not_post_id, not_comment_id, not_own_iuid, not_type, not_not_type, not_time)VALUES('$userID','$postID','$commentID','$commentOwnerID','$notType','commentLike','$time')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE iuid = '$commentOwnerID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Insert Comment Notification*/
	public function iN_insertPostLikeNotification($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$postData = $this->iN_GetAllPostDetails($postID);
		$postFile = isset($postData['post_file']) ? $postData['post_file'] : NULL;
		$postOwnerID = isset($postData['post_owner_id']) ? $postData['post_owner_id'] : NULL;
		if ($postFile) {
			$notType = 'image';
		} else {
			$notType = 'text';
		}
		$time = time();
		if ($this->iN_CheckNotificationInsertedBeforePostLike($userID, $postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$userID' AND not_post_id = '$postID'") or die(mysqli_error($this->db));
			return false;
		} else if ($userID !== $postOwnerID) {
			mysqli_query($this->db, "INSERT INTO i_user_notifications (not_iuid, not_post_id, not_own_iuid, not_type, not_not_type, not_time)VALUES('$userID','$postID','$postOwnerID','$notType','postLike','$time')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE iuid = '$postOwnerID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Insert Notification for Commented*/
	public function iN_InsertNotificationForCommented($userID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$postData = $this->iN_GetAllPostDetails($postID);
		$postFile = isset($postData['post_file']) ? $postData['post_file'] : NULL;
		$postOwnerID = isset($postData['post_owner_id']) ? $postData['post_owner_id'] : NULL;
		if ($postFile) {
			$notType = 'image';
		} else {
			$notType = 'text';
		}
		$time = time();
		mysqli_query($this->db, "INSERT INTO i_user_notifications (not_iuid, not_post_id, not_own_iuid, not_type, not_not_type, not_time)VALUES('$userID','$postID','$postOwnerID','$notType','commented','$time')") or die(mysqli_error($this->db));
		mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE iuid = '$postOwnerID'") or die(mysqli_error($this->db));
		return true;
	}
	/*Insert Notification for Follow*/
	public function iN_InsertNotificationForFollow($userID, $userTwo) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$time = time();
		mysqli_query($this->db, "INSERT INTO i_user_notifications(not_iuid, not_own_iuid, not_not_type, not_time)VALUES('$userID','$userTwo','follow','$time')") or die(mysqli_error($this->db));
		mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE iuid = '$userTwo'") or die(mysqli_error($this->db));
		return true;
	}
	/*Insert Notification for Follow*/
	public function iN_RemoveNotificationForFollow($userID, $userTwo) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$time = time();
		$query = mysqli_query($this->db, "SELECT * FROM i_user_notifications WHERE not_iuid = '$userID' AND not_own_iuid = '$userTwo' AND not_not_type = 'follow'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$userID' AND not_own_iuid = '$userTwo' AND not_not_type = 'follow'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Insert Notification for Follow*/
	public function iN_InsertNotificationForSubscribe($userID, $userTwo) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$time = time();
		mysqli_query($this->db, "INSERT INTO i_user_notifications(not_iuid, not_own_iuid, not_not_type, not_time)VALUES('$userID','$userTwo','subscribe','$time')") or die(mysqli_error($this->db));
		mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE iuid = '$userTwo'") or die(mysqli_error($this->db));
		return true;
	}
	/*Insert Notification for Follow*/
	public function iN_RemoveNotificationForSubscribe($userID, $userTwo) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$time = time();
		$query = mysqli_query($this->db, "SELECT * FROM i_user_notifications WHERE not_iuid = '$userID' AND not_own_iuid = '$userTwo' AND not_not_type = 'subscribe'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$userID' AND not_own_iuid = '$userTwo' AND not_not_type = 'subscribe'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Check Comment ID EXISTs*/
	public function iN_CheckCommentIDExist($commentID, $userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$checkCommentisExist = mysqli_query($this->db, "SELECT com_id FROM i_post_comments WHERE com_id = '$commentID' AND comment_uid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkCommentisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Check Comment ID EXISTs*/
	public function iN_CheckCommentIDExistUniq($commentID) {
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$checkCommentisExist = mysqli_query($this->db, "SELECT com_id FROM i_post_comments WHERE com_id = '$commentID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkCommentisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Delete Comment*/
	public function iN_DeleteComment($userID, $commentID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckCommentIDExist($commentID, $userID) == '1' && $this->iN_CheckPostIDExist($postID) == 1) {

			mysqli_query($this->db, "DELETE FROM i_post_comments WHERE comment_uid_fk = '$userID' AND com_id = '$commentID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$userID' AND not_post_id = '$postID' AND not_not_type = 'commented'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_post_comment_likes WHERE c_like_comment_id = '$commentID' AND c_like_post_id = '$postID'") or die(mysqli_error($this->db));
			return true;

		} else if ($this->iN_CheckCommentIDExistUniq($commentID) == '1' && $this->iN_CheckPostIDExist($postID) == 1) {
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$getUserIDFromCommentID = mysqli_query($this->db, "SELECT comment_uid_fk FROM i_post_comments WHERE com_id = '$commentID'") or die(mysqli_error($this->db));
				mysqli_query($this->db, "DELETE FROM i_post_comments WHERE com_id = '$commentID'") or die(mysqli_error($this->db));
				if (mysqli_num_rows($getUserIDFromCommentID) == 1) {
					$data = mysqli_fetch_array($getUserIDFromCommentID, MYSQLI_ASSOC);
					$commentedUserID = $data['comment_uid_fk'];
					mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$commentedUserID' AND not_post_id = '$postID' AND not_not_type = 'commented'") or die(mysqli_error($this->db));
				}
				mysqli_query($this->db, "DELETE FROM i_post_comment_likes WHERE c_like_comment_id = '$commentID' AND c_like_post_id = '$postID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Check Post Reported Before*/
	public function iN_CheckCommentReportedBefore($userID, $commentID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$checkCommentReportStatus = mysqli_query($this->db, "SELECT reported_comment, iuid_fk FROM i_comment_reports WHERE reported_comment = '$commentID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkCommentReportStatus) == 1) {
			return true;
		} else {return false;}
	}
	/*Report Comment*/
	public function iN_InsertReportedComment($userID, $commentID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1 && $this->iN_CheckCommentIDExistUniq($commentID)) {
			$time = time();
			if ($this->iN_CheckCommentReportedBefore($userID, $commentID) == 1) {
				$Unreport = mysqli_query($this->db, "DELETE FROM i_comment_reports WHERE reported_comment = '$commentID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
				return 'un';
			} else {
				$insertReport = mysqli_query($this->db, "INSERT INTO i_comment_reports(reported_comment, iuid_fk, report_time,comment_post_id_fk)VALUES('$commentID','$userID','$time','$postID')") or die(mysqli_error($this->db));
				return 'rep';
			}
		} else {return false;}
	}
	/*Get Comment*/
	public function iN_GetCommentFromID($userID, $commentID, $postID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckCommentIDExistUniq($commentID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$getComment = mysqli_query($this->db, "SELECT * FROM i_post_comments WHERE com_id = '$commentID'") or die(mysqli_error($this->db));
				$data = mysqli_fetch_array($getComment, MYSQLI_ASSOC);
				return $data;
			} else {
				$getComment = mysqli_query($this->db, "SELECT * FROM i_post_comments WHERE com_id = '$commentID' AND comment_uid_fk = '$userID'") or die(mysqli_error($this->db));
				$data = mysqli_fetch_array($getComment, MYSQLI_ASSOC);
				return $data;
			}
		} else {
			return false;
		}
	}
	/*Save Update Comment Text*/
	public function iN_UpdateComment($userID, $postID, $commentID, $editedText) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$commentID = mysqli_real_escape_string($this->db, $commentID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1 && $this->iN_CheckCommentIDExistUniq($commentID) == 1) {
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				$updateComment = mysqli_query($this->db, "UPDATE i_post_comments SET comment = '$editedText' WHERE com_id = '$commentID'") or die(mysqli_error($this->db));
				return true;
			} else {
				$updateComment = mysqli_query($this->db, "UPDATE i_post_comments SET comment = '$editedText' WHERE com_id = '$commentID' AND comment_uid_fk = '$userID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Get Stickers From Data*/
	public function iN_GetActiveStickers() {
		$stickers = mysqli_query($this->db, "SELECT * FROM i_stickers WHERE sticker_status = '1' ") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($stickers, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get Sticker By ID*/
	public function iN_getSticker($stickerID) {
		$stickerID = mysqli_real_escape_string($this->db, $stickerID);
		$stickers = mysqli_query($this->db, "SELECT sticker_id, sticker_url FROM i_stickers WHERE sticker_id = '$stickerID' AND sticker_status = '1' ") or die(mysqli_error($this->db));
		if ($this->iN_CheckStickerIDExist($stickerID) == 1) {
			$row = mysqli_fetch_array($stickers, MYSQLI_ASSOC);
			return $row;
		} else {
			return false;
		}
	}
	/*Calculate Birthday*/
	public function iN_CalculateUserAge($birthDate) {
		$birthDate = explode("/", $birthDate);
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2]));
		return $age;
	}
	/*Birthday Validator*/
	public function checkDateFormat($date) {
		return preg_match("/^(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1])\/[0-9]{4}$/", $date);
	}
	/*Update User Last Seen*/
	public function iN_UpdateLastSeen($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "UPDATE i_users SET last_login_time = '$time' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
		}
	}
	/*Get Total Posts*/
	public function iN_TotalPosts($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$countPosts = mysqli_query($this->db, "SELECT COUNT(*) AS totalPost FROM i_posts WHERE post_owner_id = '$userID'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($countPosts, MYSQLI_ASSOC);
		return isset($row['totalPost']) ? $row['totalPost'] : '0';
	}
	/*Get Total Posts*/
	public function iN_TotalImagePosts($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$countImagePosts = mysqli_query($this->db, "SELECT COUNT(*) AS totalImagePost FROM i_user_uploads WHERE iuid_fk = '$userID' AND upload_type = 'wall' AND uploaded_file_ext IN('gif','GIF','jpg','jpeg','JPEG','JPG','PNG','png')") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($countImagePosts, MYSQLI_ASSOC);
		return isset($row['totalImagePost']) ? $row['totalImagePost'] : '0';
	}
	/*Get Total Posts*/
	public function iN_TotalVideoPosts($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$countVideoPosts = mysqli_query($this->db, "SELECT COUNT(*) AS totalVideoPost FROM i_user_uploads WHERE iuid_fk = '$userID' AND upload_type = 'wall' AND uploaded_file_ext IN('mp4','MP4')") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($countVideoPosts, MYSQLI_ASSOC);
		return isset($row['totalVideoPost']) ? $row['totalVideoPost'] : '0';
	}
    /*Get Total Posts*/
	public function iN_TotalAudioPosts($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$countVideoPosts = mysqli_query($this->db, "SELECT COUNT(*) AS totalAudioPost FROM i_user_uploads WHERE iuid_fk = '$userID' AND upload_type = 'wall' AND uploaded_file_ext IN('mp3','MP3')") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($countVideoPosts, MYSQLI_ASSOC);
		return isset($row['totalAudioPost']) ? $row['totalAudioPost'] : '0';
	}
	/*Check user is in FLWR*/
	public function iN_CheckUserIsInFLWR($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		$GetStatus = mysqli_query($this->db, "SELECT fr_status FROM i_friends WHERE fr_one='$userID' AND fr_two='$uID' AND fr_status = 'flwr'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($GetStatus) == 1) {
			return true;
		} else {return false;}
	}
	/*Check user is in FLWR*/
	public function iN_CheckUserIsInSubscriber($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		$GetStatus = mysqli_query($this->db, "SELECT fr_status FROM i_friends WHERE fr_one='$userID' AND fr_two='$uID' AND fr_status = 'subscriber'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($GetStatus) == 1) {
			return true;
		} else {return false;}
	}
	/*UnSubscribe User*/
	public function iN_UnSubscriberUser($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1) {
			$time = time();
			if ($this->iN_CheckUserIsInSubscriber($userID, $uID) == '1') {
				$UnSubscribe = mysqli_query($this->db, "DELETE FROM i_friends WHERE fr_one='$userID' AND fr_two='$uID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Insert New Following List*/
	public function iN_insertNewFollow($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1) {
			$time = time();
			if ($this->iN_CheckUserIsInFLWR($userID, $uID) == '1') {
				$UnFollow = mysqli_query($this->db, "DELETE FROM i_friends WHERE fr_one='$userID' AND fr_two='$uID' AND fr_status = 'flwr'") or die(mysqli_error($this->db));
				return 'unflw';
			} else {
				$Follow = mysqli_query($this->db, "INSERT INTO i_friends(fr_one, fr_two, fr_status,fr_time)VALUES('$userID','$uID','flwr','$time')") or die(mysqli_error($this->db));
				return 'flw';
			}
		} else {
			return false;
		}
	}
	/*Check User Blocked Before*/
	public function iN_CheckUserBlocked($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1) {
			$checkBlocked = mysqli_query($this->db, "SELECT blocker_iuid, blocked_iuid FROM i_user_blocks WHERE blocker_iuid = '$userID' AND blocked_iuid = '$uID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkBlocked) == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Check User Blocked User Profile*/
	public function iN_CheckUserBlockedVisitor($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1) {
			$checkBlocked = mysqli_query($this->db, "SELECT blocker_iuid, blocked_iuid FROM i_user_blocks WHERE blocker_iuid = '$userID' AND blocked_iuid = '$uID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkBlocked) == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Get User Block Type*/
	public function iN_GetUserBlockedType($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1 && $this->iN_CheckUserBlocked($userID, $uID) == 1) {
			$getBlockType = mysqli_query($this->db, "SELECT * FROM i_user_blocks WHERE blocker_iuid = '$userID' AND blocked_iuid = '$uID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($getBlockType, MYSQLI_ASSOC);
			$userblockType = isset($data['block_type']) ? $data['block_type'] : FALSE;
			return $userblockType;
		}
	}
	/*Insert User in Blocked List*/
	public function iN_InsertBlockList($userID, $uID, $blockType) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$blockType = mysqli_real_escape_string($this->db, $blockType);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1) {
			$time = time();
			/*Check Blocked Before*/
			if ($this->iN_CheckUserBlocked($userID, $uID) == 1) {
				/*Remove From Blocked List*/
				$removeBlockList = mysqli_query($this->db, "DELETE FROM i_user_blocks WHERE blocker_iuid='$userID' AND blocked_iuid='$uID'") or die(mysqli_error($this->db));
				return 'bRemoved';
			} else {
				$addBlockList = mysqli_query($this->db, "INSERT INTO i_user_blocks(blocker_iuid, blocked_iuid,block_type, blocked_time)VALUES('$userID','$uID','$blockType','$time')") or die(mysqli_error($this->db));
				return 'bAdded';
			}
		} else {
			return false;
		}
	}
	/*User Subscriptions OFFERS*/
	public function iN_UserSusbscriptionOffers($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$getOffers = mysqli_query($this->db, "SELECT * FROM i_user_subscribe_plans WHERE iuid_fk = '$userID' AND plan_status = '1'") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($getOffers, MYSQLI_ASSOC)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Check Plan Exist*/
	public function iN_CheckPlanExist($planID, $userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$planID = mysqli_real_escape_string($this->db, $planID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$checkPlan = mysqli_query($this->db, "SELECT plan_id, iuid_fk , plan_type FROM i_user_subscribe_plans WHERE iuid_fk = '$userID' AND plan_id = '$planID' AND plan_status = '1'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkPlan) == 1) {
				$planDetails = mysqli_query($this->db, "SELECT * FROM i_user_subscribe_plans WHERE iuid_fk = '$userID' AND plan_id = '$planID'") or die(mysqli_error($this->db));
				$data = mysqli_fetch_array($planDetails, MYSQLI_ASSOC);
				return $data;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/*Insert User Subscription*/
	public function iN_InsertUserSubscription($userID, $subscribedUserID, $planType, $subscriberName, $subscrID, $custID, $planIDs, $planAmount, $adminEarning, $userNetEarning, $planCurrency, $planinterval, $planIntervalCount, $subscriberEmail, $plancreated, $current_period_start, $current_period_end, $planStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$subscribedUserID = mysqli_real_escape_string($this->db, $subscribedUserID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($subscribedUserID) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_user_subscriptions(iuid_fk, subscribed_iuid_fk, subscriber_name, payment_method, payment_subscription_id, customer_id, plan_id, plan_amount,admin_earning,user_net_earning, plan_amount_currency, plan_interval, plan_interval_count, payer_email, created, plan_period_start, plan_period_end,status)VALUES('$userID', '$subscribedUserID','$subscriberName', '$planType', '$subscrID', '$custID', '$planIDs', '$planAmount','$adminEarning','$userNetEarning', '$planCurrency', '$planinterval', '$planIntervalCount', '$subscriberEmail', '$plancreated', '$current_period_start', '$current_period_end', '$planStatus')") or die(mysqli_error($this->db));
			if ($query) {
				$time = time();
				$GetStatus = mysqli_query($this->db, "SELECT fr_one, fr_two, fr_status FROM i_friends WHERE fr_one='$userID' AND fr_two='$subscribedUserID' AND fr_status = 'flwr'") or die(mysqli_error($this->db));
				if (mysqli_num_rows($GetStatus) == 1) {
					mysqli_query($this->db, "UPDATE i_friends SET fr_status = 'subscriber', fr_time = '$time' WHERE fr_one='$userID' AND fr_two='$subscribedUserID'") or die(mysqli_error($this->db));
				} else {
					mysqli_query($this->db, "INSERT INTO i_friends(fr_one, fr_two, fr_status,fr_time)VALUES('$userID','$subscribedUserID','subscriber','$time')") or die(mysqli_error($this->db));
				}
				return true;
			} else {
				return false;
			}
		}
	}
	/*Get Subscribe ID*/
	public function iN_GetSubscribeID($userID, $uID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uID = mysqli_real_escape_string($this->db, $uID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($uID) == 1) {
			$getSubscribeData = mysqli_query($this->db, "SELECT * FROM i_user_subscriptions WHERE iuid_fk = '$userID' AND subscribed_iuid_fk = '$uID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($getSubscribeData, MYSQLI_ASSOC);
			return $data;
		} else {return false;}
	}
	/*Update Subscription Status*/
	public function iN_UpdateSubscriptionStatus($subscriptionID) {
		$subscriptionID = mysqli_real_escape_string($this->db, $subscriptionID);
		mysqli_query($this->db, "UPDATE i_user_subscriptions SET status = 'inactive', in_status = '1' WHERE subscription_id = '$subscriptionID'") or die(mysqli_error($this->db));
	}
	public function iN_AllUserProfilePosts($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.*,U.*
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')
		WHERE P.post_owner_id='$uid' $morePost
		ORDER BY P.post_id
		DESC LIMIT $showingPosts ") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Insert  A New Verification Request*/
	public function iN_InsertNewVerificationRequest($userID, $cardIDPhoto, $Photo) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$cardIDPhoto = mysqli_real_escape_string($this->db, $cardIDPhoto);
		$Photo = mysqli_real_escape_string($this->db, $Photo);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$time = time();
			$InsertQuery = mysqli_query($this->db, "INSERT INTO i_verification_requests(iuid_fk,id_card,photo_of_card,request_status, request_time)VALUES('$userID','$Photo','$cardIDPhoto','0','$time')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET certification_status = '1' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Accept Conditions Button by Clicking Next button*/
	public function iN_AcceptConditions($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET certification_status = '2', validation_status = '1' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Check user Set Subscription Fees Before*/
	public function iN_CheckUserSetSubscriptionFeesBefore($userID, $plan) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$plan = mysqli_real_escape_string($this->db, $plan);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$Query = mysqli_query($this->db, "SELECT iuid_fk, plan_type FROM i_user_subscribe_plans WHERE iuid_fk = '$userID' AND plan_type = '$plan'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($Query) == '1') {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Insert Subscription Weekly*/
	public function iN_InsertWeeklySubscriptionAmountAndStatus($userID, $SubWeekAmount, $weeklySubStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$SubWeekAmount = mysqli_real_escape_string($this->db, $SubWeekAmount);
		$weeklySubStatus = mysqli_real_escape_string($this->db, $weeklySubStatus);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserSetSubscriptionFeesBefore($userID, 'weekly') == '0') {
			$time = time();
			$query = mysqli_query($this->db, "INSERT INTO i_user_subscribe_plans(iuid_fk, amount,plan_type, plan_created_time,plan_status)VALUES('$userID','$SubWeekAmount','weekly','$time','$weeklySubStatus')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {return false;}
	}
	/*Insert Subscription Monthly*/
	public function iN_InsertMonthlySubscriptionAmountAndStatus($userID, $SubMonthAmount, $monthlySubStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$SubMonthAmount = mysqli_real_escape_string($this->db, $SubMonthAmount);
		$monthlySubStatus = mysqli_real_escape_string($this->db, $monthlySubStatus);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserSetSubscriptionFeesBefore($userID, 'monthly') == '0') {
			$time = time();
			$query = mysqli_query($this->db, "INSERT INTO i_user_subscribe_plans(iuid_fk, amount,plan_type, plan_created_time,plan_status)VALUES('$userID','$SubMonthAmount','monthly','$time','$monthlySubStatus')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {return false;}
	}
	/*Insert Subscription Yearly*/
	public function iN_InsertYearlySubscriptionAmountAndStatus($userID, $SubYearAmount, $yearlySubStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$SubYearAmount = mysqli_real_escape_string($this->db, $SubYearAmount);
		$yearlySubStatus = mysqli_real_escape_string($this->db, $yearlySubStatus);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserSetSubscriptionFeesBefore($userID, 'yearly') == '0') {
			$time = time();
			$query = mysqli_query($this->db, "INSERT INTO i_user_subscribe_plans(iuid_fk, amount,plan_type, plan_created_time,plan_status)VALUES('$userID','$SubYearAmount','yearly','$time','$yearlySubStatus')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {return false;}
	}
	/*Update Fee Status From Users Table*/
	public function iN_UpdateUserFeeStatus($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET validation_status = '2', condition_status = '2', fees_status = '2' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Insert Payout Settings*/
	public function iN_SetPayout($userID, $paypalEmail, $bankAccount, $defaultMethod) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paypalEmail = mysqli_real_escape_string($this->db, $paypalEmail);
		$bankAccount = mysqli_real_escape_string($this->db, $bankAccount);
		$defaultMethod = mysqli_real_escape_string($this->db, $defaultMethod);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$updatePayoutMethod = mysqli_query($this->db, "UPDATE i_users SET payout_method = '$defaultMethod', payout_status = '2', user_verified_status = '1', paypal_email = '$paypalEmail', bank_account = '$bankAccount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Profile*/
	public function iN_UpdateProfile($userID, $fulname, $bio, $newUsername, $birthDay, $profileCategory, $gender, $tipNot) {
		$userID = mysqli_real_escape_string($this->db, $userID); 
		if($birthDay){
			$correctBirthday = $this->iN_CorrectDateFormat($birthDay);
			$correctBirthday = ', birthday = "'.$correctBirthday.'"';
		}else{
			$correctBirthday = '';
		}
		if($tipNot){
           $tipNots = ', thanks_for_tip = "'.$tipNot.'"';
		}else{
			$tipNots = ', thanks_for_tip  = "'.NULL.'"';
		}
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET i_username = '$newUsername', i_user_fullname = '$fulname' , user_gender = '$gender' $correctBirthday , profile_category = '$profileCategory', u_bio = '$bio' $tipNots WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {return false;}
	}
	/*INSERT UPLOADED COVER PHOTO*/
	public function iN_INSERTUploadedCoverPhoto($uid, $filePath) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$filePath = mysqli_real_escape_string($this->db, $filePath);
		$uploadTime = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($this->iN_CheckUserExist($uid) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_user_covers (iuid_fk,cover_path,cover_upload_time,ip)VALUES('$uid' ,'$filePath','$uploadTime','$userIP')") or die(mysqli_error($this->db));
			$ids = mysqli_insert_id($this->db);
			if ($ids) {
				mysqli_query($this->db, "UPDATE i_users SET user_cover= '$ids' WHERE iuid = '$uid'") or die(mysqli_error($this->db));
			}
			return $ids;
		} else {return false;}
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedCoverURL($uid, $imageID) {
		if ($imageID && $this->iN_CheckUserExist($uid) == 1) {
			$query = mysqli_query($this->db, "SELECT iuid_fk,cover_path, cover_id FROM i_user_covers WHERE iuid_fk='$uid' AND cover_id = '$imageID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($result['cover_path']) ? $result['cover_path'] : NULL;
		} else {
			return false;
		}
	}
	/*INSERT UPLOADED AVATAR PHOTO*/
	public function iN_INSERTUploadedAvatarPhoto($uid, $filePath) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$filePath = mysqli_real_escape_string($this->db, $filePath);
		$uploadTime = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($this->iN_CheckUserExist($uid) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_user_avatars (iuid_fk,avatar_path,avatar_upload_time,ip)VALUES('$uid' ,'$filePath','$uploadTime','$userIP')") or die(mysqli_error($this->db));
			$ids = mysqli_insert_id($this->db);
			if ($ids) {
				mysqli_query($this->db, "UPDATE i_users SET user_avatar= '$ids' WHERE iuid = '$uid'") or die(mysqli_error($this->db));
			}
			return $ids;
		} else {return false;}
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedAvatarURL($uid, $imageID) {
		if ($imageID && $this->iN_CheckUserExist($uid) == 1) {
			$query = mysqli_query($this->db, "SELECT iuid_fk,avatar_path, avatar_id FROM i_user_avatars WHERE iuid_fk='$uid' AND avatar_id = '$imageID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($result['avatar_path']) ? $result['avatar_path'] : NULL;
		} else {
			return false;
		}
	}
	/*Check User Email Address*/
	public function iN_CheckEmail($userID, $newEmail) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$newEmail = mysqli_real_escape_string($this->db, $newEmail);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$checkEmail = mysqli_query($this->db, "SELECT i_user_email FROM i_users WHERE i_user_email = '$newEmail'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkEmail) == 1) {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	/*Check User Password is Valid*/
	public function iN_CheckUserPasswordAndUpdateIfIsValid($userID, $pass, $email) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$pass = mysqli_real_escape_string($this->db, $pass);
		$newEmail = mysqli_real_escape_string($this->db, $email);
		$uPass = sha1(md5($pass));
		if ($this->iN_CheckUserExist($userID) == 1) {
			$checkPassValid = mysqli_query($this->db, "SELECT i_password, iuid FROM i_users WHERE i_password = '$uPass' AND iuid = '$userID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkPassValid) == 1) {
				$updaetEmail = mysqli_query($this->db, "UPDATE i_users SET i_user_email= '$newEmail' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
				return true;
			} else {
				return false;
			}
		} else {return false;}
	}
	/*Payments Subscriptions List*/
	public function iN_PaymentsSubscriptionsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			S.subscription_id, S.iuid_fk, S.subscribed_iuid_fk,S.payment_method, S.subscriber_name, S.plan_id, S.plan_amount,S.user_net_earning,S.admin_earning, S.plan_amount_currency, S.created, S.status, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_subscriptions S FORCE INDEX(ix_Subscribe)
		    ON S.subscribed_iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE S.status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' AND S.subscribed_iuid_fk = '$userID' ORDER BY S.subscription_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Payments Subscriptions List*/
	public function iN_PaymentsSubscriptionsListPage($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			S.subscription_id, S.iuid_fk, S.subscribed_iuid_fk, S.subscriber_name, S.plan_id, S.plan_amount,S.admin_earning, S.plan_amount_currency,S.plan_interval,S.payment_method, S.created, S.status, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_subscriptions S FORCE INDEX(ix_Subscribe)
		    ON S.iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE S.status = 'active' AND S.iuid_fk = '$userID' ORDER BY S.subscription_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*User Total Subscribers*/
	public function iN_UserTotalSubscribers($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalSubscribers FROM i_user_subscriptions WHERE subscribed_iuid_fk = '$userID' AND status='active'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalSubscribers']) ? $row['totalSubscribers'] : '0';
		}
	}
	/*User Total Subscribtions*/
	public function iN_UserTotalSubscribtions($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalSubscribtions FROM i_user_subscriptions WHERE iuid_fk = '$userID' AND status='active'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalSubscribtions']) ? $row['totalSubscribtions'] : '0';
		}
	}
	/*Insert Payout Settings*/
	public function iN_UpdatePayout($userID, $paypalEmail, $bankAccount, $defaultMethod) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paypalEmail = mysqli_real_escape_string($this->db, $paypalEmail);
		$bankAccount = mysqli_real_escape_string($this->db, $bankAccount);
		$defaultMethod = mysqli_real_escape_string($this->db, $defaultMethod);
		if ($this->iN_CheckUserExist($userID) == 1) { 
			$updatePayoutMethod = mysqli_query($this->db, "UPDATE i_users SET payout_method = '$defaultMethod', paypal_email = '$paypalEmail', bank_account = '$bankAccount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert Subscription Weekly*/
	public function iN_UpdateWeeklySubscriptionAmountAndStatus($userID, $SubWeekAmount, $weeklySubStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$SubWeekAmount = mysqli_real_escape_string($this->db, $SubWeekAmount);
		$weeklySubStatus = mysqli_real_escape_string($this->db, $weeklySubStatus);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserSetSubscriptionFeesBefore($userID, 'weekly') == '1') {
			$time = time();
			$query = mysqli_query($this->db, "UPDATE i_user_subscribe_plans SET amount = '$SubWeekAmount', plan_status = '$weeklySubStatus' WHERE iuid_fk = '$userID' AND plan_type = 'weekly'") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {
			$WeeklyInsert = $this->iN_InsertWeeklySubscriptionAmountAndStatus($userID, $SubWeekAmount, $weeklySubStatus);
			if ($WeeklyInsert) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Insert Subscription Monthly*/
	public function iN_UpdateMonthlySubscriptionAmountAndStatus($userID, $SubMonthAmount, $monthlySubStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$SubMonthAmount = mysqli_real_escape_string($this->db, $SubMonthAmount);
		$monthlySubStatus = mysqli_real_escape_string($this->db, $monthlySubStatus);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserSetSubscriptionFeesBefore($userID, 'monthly') == '1') {
			$time = time();
			$query = mysqli_query($this->db, "UPDATE i_user_subscribe_plans SET amount = '$SubMonthAmount', plan_status = '$monthlySubStatus' WHERE iuid_fk = '$userID' AND plan_type = 'monthly'") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {
			$MonthlyInsert = $this->iN_InsertMonthlySubscriptionAmountAndStatus($userID, $SubMonthAmount, $monthlySubStatus);
			if ($MonthlyInsert) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Insert Subscription Yearly*/
	public function iN_UpdateYearlySubscriptionAmountAndStatus($userID, $SubYearAmount, $yearlySubStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$SubYearAmount = mysqli_real_escape_string($this->db, $SubYearAmount);
		$yearlySubStatus = mysqli_real_escape_string($this->db, $yearlySubStatus);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserSetSubscriptionFeesBefore($userID, 'yearly') == '1') {
			$time = time();
			$query = mysqli_query($this->db, "UPDATE i_user_subscribe_plans SET amount = '$SubYearAmount', plan_status = '$yearlySubStatus' WHERE iuid_fk = '$userID' AND plan_type = 'yearly'") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {
			$YearlyInsert = $this->iN_InsertYearlySubscriptionAmountAndStatus($userID, $SubYearAmount, $yearlySubStatus);
			if ($YearlyInsert) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Get User Weekly Subscription Plan*/
	public function iN_GetUserSubscriptionPlanDetails($userID, $planType) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$checkWeeklyPlanExist = mysqli_query($this->db, "SELECT amount, plan_status, plan_type FROM i_user_subscribe_plans WHERE iuid_fk = '$userID' AND plan_type = '$planType'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkWeeklyPlanExist) == 1) {
				$result = mysqli_fetch_array($checkWeeklyPlanExist, MYSQLI_ASSOC);
				return $result;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/*Payments Subscriptions List*/
	public function iN_PayoutHistory($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			P.payout_id, P.iuid_fk, P.amount, P.method, P.payout_time, P.status,P.payment_type, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payouts P FORCE INDEX(ix_PayoutUser)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.iuid_fk = '$userID' ORDER BY P.payout_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Current Month Earn Calculate*/
	public function iN_CalculateCurrentMonthEarning($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT SUM(user_net_earning) AS calculate FROM i_user_subscriptions WHERE subscribed_iuid_fk = '$userID' AND status IN('active','inactive') AND in_status IN('1','0') AND finished = '0'") or die(mysqli_error($this->db));
			//$query = mysqli_query($this->db, "SELECT SUM(user_net_earning) AS calculate FROM i_user_subscriptions WHERE subscribed_iuid_fk = '$userID' AND status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' AND MONTH(created)= MONTH(CURDATE())") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Insert Withdrawal*/
	public function iN_InsertWithdrawal($userID, $withdrawalAmount, $defaultMethod, $payoutType) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$time = time();
			$query = mysqli_query($this->db, "INSERT INTO i_user_payouts (iuid_fk,amount,method,payment_type,payout_time,status)VALUES('$userID' ,'$withdrawalAmount','$defaultMethod','$payoutType','$time','pending')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET wallet_money = wallet_money - $withdrawalAmount WHERE iuid = '$userID'") or die(mysqli_error($this->db));

			return true;
		} else {
			return false;
		}
	}
	/*Check User have Pending Withdrawal*/
	public function iN_CheckUserHavePendingWithdrawal($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT iuid_fk, status FROM i_user_payouts WHERE iuid_fk = '$userID' AND payment_type = 'withdrawal' AND status = 'pending'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($query) > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Payments history List*/
	public function iN_PaymentsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			P.payment_id,P.payer_iuid_fk, P.payed_iuid_fk, P.payed_post_id_fk, P.payed_profile_id_fk, P.order_key, P.payment_type, P.payment_option, P.payment_time, P.payment_status, P.amount, P.fee, P.admin_earning, P.user_earning, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payments P FORCE INDEX(ixPayment)
		    ON P.payed_iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.payment_status = 'ok' AND P.payed_iuid_fk = '$userID' ORDER BY P.payment_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	public function iN_CheckUserPurchasedThisPost($userID, $PurchasePostID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$PurchasePostID = mysqli_real_escape_string($this->db, $PurchasePostID);
		$query = mysqli_query($this->db, "SELECT payer_iuid_fk, payed_post_id_fk FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payed_post_id_fk = '$PurchasePostID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Buy Post*/
	public function iN_BuyPost($userID, $userPostOwnerID, $PurchasePostID, $amount, $adminEarning, $userEarning, $fee, $credit) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$userPostOwnerID = mysqli_real_escape_string($this->db, $userPostOwnerID);
		$PurchasePostID = mysqli_real_escape_string($this->db, $PurchasePostID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckUserExist($userPostOwnerID) == '1' && $this->iN_CheckPostIDExist($PurchasePostID) == '1' && $this->iN_CheckUserPurchasedThisPost($userID, $PurchasePostID) == '0') {
			$time = time();
			$query = mysqli_query($this->db, "INSERT INTO i_user_payments(payer_iuid_fk, payed_iuid_fk, payed_post_id_fk,payment_type,payment_time,payment_status, amount, fee, admin_earning, user_earning)VALUES('$userID','$userPostOwnerID', '$PurchasePostID', 'post', '$time', 'ok', '$amount', '$fee', '$adminEarning', '$userEarning')") or die(mysqli_error($this->db));
			if ($query) {
				mysqli_query($this->db, "UPDATE i_users SET wallet_points = wallet_points - $credit WHERE iuid = '$userID'") or die(mysqli_error($this->db));
				mysqli_query($this->db, "UPDATE i_users SET wallet_money = (wallet_money + $userEarning) WHERE iuid = '$userPostOwnerID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Premium Plan List*/
	public function iN_PremiumPlans() {
		$query = mysqli_query($this->db, "SELECT * FROM i_premium_plans WHERE plan_status = '1'") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Check Premium Plan Exist*/
	public function CheckPlanExist($planID) {
		$planID = mysqli_real_escape_string($this->db, $planID);
		$query = mysqli_query($this->db, "SELECT plan_id FROM i_premium_plans WHERE plan_id = '$planID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Check Premium Plan Exist*/
	public function CheckLivePlanExist($planID) {
		$planID = mysqli_real_escape_string($this->db, $planID);
		$query = mysqli_query($this->db, "SELECT gift_id FROM i_live_gift_point WHERE gift_id = '$planID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Check Premium Plan Exist*/
	public function GetPlanDetails($planID) {
		$planID = mysqli_real_escape_string($this->db, $planID);
		if ($this->CheckPlanExist($planID) == '1') {
			$query = mysqli_query($this->db, "SELECT * FROM i_premium_plans WHERE plan_id = '$planID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		} else {return false;}
	}
	/*Text REplacement*/
	public function iN_TextReaplacement($string, $values = []) {
		preg_match_all('/\{(\w+)\}/', $string, $matches);
		return str_replace($matches[0], $values, $string);
	}
	/*Get Latest Payment Details*/
	public function iN_LatestPaymentPost($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payment_type = 'post' AND payment_status = 'ok'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		} else {
			return false;
		}
	}
	/*Get Latest Payment Details*/
	public function iN_LatestPaymentPoint($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payment_type IN('point','product') AND payment_status = 'pending'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		} else {
			return false;
		}
	} 
	/*Update Payment Success Status*/
    public function iN_UpdatePaymentSuccessStatus($userID, $paymentID){
		if ($this->iN_CheckUserExist($userID) == '1') {
		    $query = mysqli_query($this->db, "UPDATE i_user_payments SET payment_status = 'ok' WHERE payment_id = '$paymentID'") or die(mysqli_error($this->db));
            return true;
		}
	}
	/*Chat User List*/
	public function iN_ChatUserList($userID, $limit) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$query = mysqli_query($this->db, "SELECT DISTINCT
		  C.chat_id,C.user_one,C.user_two,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.online_offline_status,U.user_gender,U.user_verified_status
		  FROM i_chat_users C FORCE INDEX(ixUserChat)
		  INNER JOIN i_users U FORCE INDEX(ixForceUser)
		  ON C.user_one = U.iuid AND U.uStatus IN('1','3')
		  WHERE C.user_two = '$userID' OR C.user_one = '$userID' ORDER BY C.last_message_time DESC LIMIT $limit
		  ") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Check Chat ID Exist*/
	public function iN_CheckChatIDExist($chatID) {
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		$query = mysqli_query($this->db, "SELECT chat_id from i_chat_users WHERE chat_id = '$chatID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == '1') {
			return true;
		} else {
			return false;
		}
	}
	/*Check Chat Owners Exist*/
	public function iN_CheckChatUserOwnersID($userID, $chatID) {
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		if($this->iN_CheckChatIDExist($chatID) == '1'){
           $query = mysqli_query($this->db,"SELECT user_one, user_two FROM i_chat_users WHERE chat_id = '$chatID' AND (user_one = '$userID' OR user_two = '$userID')") or die(mysqli_error($this->db));
		   if(mysqli_num_rows($query) == '1'){
              return true;
		   }else{
			   return false;
		   }
		}
	}
	/*Check Chat ID Exist*/
	public function iN_GetChatUserIDs($chatID) {
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		$query = mysqli_query($this->db, "SELECT * FROM i_chat_users WHERE chat_id = '$chatID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $data;
	}
	/*Chat Latest Message*/
	public function iN_GetLatestMessage($chatID) {
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		if ($this->iN_CheckChatIDExist($chatID) == '1') {
			$query = mysqli_query($this->db, "SELECT * FROM i_chat_conversations WHERE chat_id_fk = '$chatID' ORDER BY con_id DESC LIMIT 1") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		}
	}
	/*Chat Messages*/
	public function iN_GetChatMessages($userID, $chatID, $lastMessageID, $messageLimit) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckChatIDExist($chatID) == '1') {
			$moreMessage = '';
			if ($lastMessageID) {
				$moreMessage = " M.con_id < '" . $lastMessageID . "' AND ";
			}
			$query = mysqli_query($this->db, "SELECT * FROM (SELECT DISTINCT
				M.con_id, M.chat_id_fk, M.user_one, M.user_two, M.message,M.seen_status,M.file,M.sticker_url,M.gifurl, M.time,C.chat_id, U.iuid, U.uStatus, U.i_username, U.i_user_fullname, U.user_gender
				FROM i_chat_users C FORCE INDEX(ixUserChat)
				INNER JOIN i_chat_conversations M FORCE INDEX(ixChat)
				ON C.chat_id = M.chat_id_fk
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON M.user_one = U.iuid AND U.uStatus IN('1','3')
				WHERE $moreMessage M.chat_id_fk = '$chatID' ORDER BY M.con_id DESC LIMIT $messageLimit ) t ORDER BY con_id ASC
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Get Latest Message*/
	public function iN_GetUserNewMessage($uid, $chatID, $user, $lastMessageID) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		$query = mysqli_query($this->db, "SELECT DISTINCT
				M.con_id, M.chat_id_fk, M.user_one, M.user_two, M.message,M.file,M.seen_status,M.sticker_url,M.gifurl, M.time,C.chat_id, U.iuid, U.uStatus, U.i_username, U.i_user_fullname, U.user_gender
				FROM i_chat_users C FORCE INDEX(ixUserChat)
				INNER JOIN i_chat_conversations M FORCE INDEX(ixChat)
				ON C.chat_id = M.chat_id_fk
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON M.user_one = U.iuid AND U.uStatus IN('1','3')
				WHERE M.con_id > " . $lastMessageID . " AND M.user_one = '$user' AND M.chat_id_fk = '$chatID' ORDER BY M.con_id DESC LIMIT 1") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $data;
	}
	/*Insert New Message*/
	public function iN_InsertNewMessage($userID, $chatID, $message, $stickerURL, $gif, $fileIDs) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$chatID = mysqli_real_escape_string($this->db, $chatID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckChatIDExist($chatID) == '1') {
			$time = time();
			$cData = $this->iN_GetChatUserIDs($chatID);
			$chatUserOne = $cData['user_one'];
			$chatUserTwo = $cData['user_two'];
			if ($chatUserOne == $userID) {
				$toID = $chatUserTwo;
			} else {
				$toID = $chatUserOne;
			}
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db, "INSERT INTO i_chat_conversations(chat_id_fk,user_one, user_two,message,sticker_url,gifurl,file, time)VALUES('$chatID','$userID','$toID', '$message','$stickerURL', '$gif','$fileIDs', '$time')") or die(mysqli_error($this->db));
			if ($query) {
				$lastMessageData = mysqli_query($this->db, "SELECT * FROM (SELECT DISTINCT
				M.con_id, M.chat_id_fk, M.user_one, M.user_two, M.message,M.file,M.sticker_url,M.gifurl,M.seen_status, M.time,C.chat_id, U.iuid, U.uStatus, U.i_username, U.i_user_fullname, U.user_gender
				FROM i_chat_users C FORCE INDEX(ixUserChat)
				INNER JOIN i_chat_conversations M FORCE INDEX(ixChat)
				ON C.chat_id = M.chat_id_fk
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON M.user_one = U.iuid AND U.uStatus IN('1','3')
				WHERE M.chat_id_fk = '$chatID' AND M.user_one = '$userID' AND M.user_two = '$toID' ORDER BY M.con_id DESC LIMIT 1 ) t ORDER BY con_id ASC
			") or die(mysqli_error($this->db));
				mysqli_query($this->db, "UPDATE i_users SET message_notification_read_status = '1' WHERE iuid = '$toID'") or die(mysqli_error($this->db));
				$data = mysqli_fetch_array($lastMessageData, MYSQLI_ASSOC);
				return $data;
			}
		} else {
			return false;
		}
	}
	/*INSERT UPLOADED FILES FROM UPLOADS TABLE*/
	public function iN_INSERTUploadedMessageFiles($uid, $conversationID, $filePath, $fileXPath, $ext) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$filePath = mysqli_real_escape_string($this->db, $filePath);
		$fileXPath = mysqli_real_escape_string($this->db, $fileXPath);
		$fileExtension = mysqli_real_escape_string($this->db, $ext);
		$uploadTime = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		$query = mysqli_query($this->db, "INSERT INTO i_user_conversation_uploads (iuid_fk,con_id_fk,uploaded_file_path,uploaded_x_file_path, uploaded_file_ext,upload_time,ip)VALUES('$uid','$conversationID' ,'$filePath','$fileXPath','$fileExtension','$uploadTime','$userIP')") or die(mysqli_error($this->db));
		$ids = mysqli_insert_id($this->db);
		return $ids;
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedMessageFilesIDs($uid, $imageName) {
		if ($imageName) {
			$query = mysqli_query($this->db, "SELECT upload_id,uploaded_file_path FROM i_user_conversation_uploads WHERE iuid_fk='$uid' ORDER BY upload_id DESC") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*GET UPLOADED FILE DATA*/
	public function iN_GetUploadedMessageFileDetails($imageID) {
		if ($imageID) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_conversation_uploads WHERE upload_id='$imageID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Update User Typing*/
	public function iN_UpdateTypingStatus($userID, $conversationID, $time) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$conversationID = mysqli_real_escape_string($this->db, $conversationID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckChatIDExist($conversationID) == '1') {
			mysqli_query($this->db, "UPDATE i_chat_users SET typing_user_one = '$time' WHERE chat_id = '$conversationID'") or die(mysqli_error($this->db));
		}
	}
	/*Check Conversation Started Before*/
	public function iN_CheckConversationStartedBeforeBetweenUsers($userID, $iuID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$iuID = mysqli_real_escape_string($this->db, $iuID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($iuID) == 1) {
			$query = mysqli_query($this->db, "SELECT chat_id AS chat FROM i_chat_users WHERE user_one = '$userID' AND user_two = '$iuID' OR user_two = '$userID' AND user_one = '$iuID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($query) == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Check User Typing Status*/
	public function iN_GetTypingStatus($userID, $conversationID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$conversationID = mysqli_real_escape_string($this->db, $conversationID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckChatIDExist($conversationID) == '1') {
			$query = mysqli_query($this->db, "SELECT typing_user_one FROM i_chat_users WHERE chat_id = '$conversationID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			/*Return result if icon id exist or not*/
			return isset($data['typing_user_one']) ? $data['typing_user_one'] : FALSE;
		}
	}
	/*Update Message Seen*/
	public function iN_UpdateMessageSeenStatus($cID, $toUserID, $userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$cID = mysqli_real_escape_string($this->db, $cID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckChatIDExist($cID) == '1') {
			mysqli_query($this->db, "UPDATE i_chat_conversations SET seen_status = '1' WHERE chat_id_fk = '$cID' AND user_one = '$toUserID'") or die(mysqli_error($this->db));
		}
	}
	/*Update Message Seen*/
	public function iN_CheckLastMessageSeenOrNot($cID, $toUserID, $userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$cID = mysqli_real_escape_string($this->db, $cID);
		$toUserID = mysqli_real_escape_string($this->db, $toUserID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckChatIDExist($cID) == '1') {
			$query = mysqli_query($this->db, "SELECT COUNT(*) AS notReaded FROM i_chat_conversations WHERE chat_id_fk = '$cID' AND user_one = '$userID' AND user_two = '$toUserID' AND seen_status = '0'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			$read = isset($row['notReaded']) ? $row['notReaded'] : '0';
			if ($read > 0) {
				return '0';
			} else {
				return '1';
			}
		}
	}
	/*Get Total Unreaded notifications */
	public function iN_GetNewMessageNotificationSum($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$CountNotification = mysqli_query($this->db, "SELECT COUNT(*) AS newMessageNotification FROM i_chat_conversations WHERE user_two = '$userID' AND seen_status='0'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($CountNotification, MYSQLI_ASSOC);
			return $row['newMessageNotification'];
		} else {
			return false;
		}
	}
	/*Update Message Notification Status 1 to 0*/
	public function iN_UpdateMessageNotificationStatus($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET message_notification_read_status = '0' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
		}
	}
	/*Popular User From Last Week*/
	public function iN_PopularUsersFromLastWeek() {
		$query = mysqli_query($this->db, "SELECT DISTINCT
		  P.post_owner_id,P.post_owner_id, U.iuid,U.i_username,U.i_user_fullname,U.user_verified_status, U.user_gender , count(P.post_owner_id) as cnt
		  FROM i_posts P FORCE INDEX(ixForcePostOwner)
		  INNER JOIN i_users U FORCE INDEX(ixForceUser)
		  ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3')
		  WHERE WEEK(FROM_UNIXTIME(P.post_created_time)) = WEEK(NOW()) - 1 GROUP BY P.post_owner_id ORDER BY cnt DESC LIMIT 5
		  ") or die(mysqli_error($this->db));
		/*U.user_verified_status = '1' AND*/
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get All Posts For Explore Page*/
	public function iN_AllUserForExplore($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.payout_method,U.thanks_for_tip,U.user_gender,U.last_login_time,U.user_verified_status
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3')
		WHERE P.post_status IN('0','1') $morePost
		ORDER BY P.post_id
		DESC LIMIT $showingPosts ") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get All Posts For Premium Page*/
	public function iN_AllUserForPremium($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,U.iuid,U.i_username,U.payout_method,U.thanks_for_tip,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3')
		WHERE P.post_status IN('1') AND P.who_can_see IN('4') $morePost 
		ORDER BY P.post_id
		DESC LIMIT $showingPosts ") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Creators List For Menu*/
	public function iN_CreatorTypes() {
		$query = mysqli_query($this->db, "SELECT * FROM i_creators WHERE creator_status = '1'") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Check Creator Type Exist*/
	public function iN_CheckCreatorTypeExist($creatorType) {
		$creatorType = mysqli_real_escape_string($this->db, $creatorType);
		$query = mysqli_query($this->db, "SELECT * FROM i_creators WHERE creator_value = '$creatorType' AND creator_status = '1'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Popular User From Last Week*/
	public function iN_PopularUsersFromLastWeekInExplorePage() {
		$query = mysqli_query($this->db, "SELECT DISTINCT
		P.post_owner_id,P.post_owner_id, U.iuid,U.i_username,U.i_user_fullname,U.user_verified_status, U.user_gender , count(P.post_owner_id) as cnt
		FROM i_posts P FORCE INDEX(ixForcePostOwner)
		INNER JOIN i_users U FORCE INDEX(ixForceUser)
		ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3')
		WHERE U.user_verified_status = '1' AND WEEK(FROM_UNIXTIME(P.post_created_time)) = WEEK(NOW()) - 1 GROUP BY P.post_owner_id ORDER BY cnt DESC LIMIT 30
		") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	public function iN_ExploreUserLatestFivePost($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND P.post_file <> ''
		WHERE P.post_owner_id='$userID' AND P.post_status = '1' AND P.post_file IS NOT NULL
		ORDER BY P.post_id
		DESC LIMIT 5") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Display the developer list requested by url*/
	public function iN_GetCreatorFromUrl($requested, $lastUID, $userLimit) {
		$requested = mysqli_real_escape_string($this->db, $requested);
		$lastUID = mysqli_real_escape_string($this->db, $lastUID); 
			$moreUser = "";
			if ($lastUID) {
				$moreUser = " AND iuid <'" . $lastUID . "' ";
			}
			$data = null;
			$query = mysqli_query($this->db, "SELECT * FROM i_users WHERE profile_category = '$requested' AND uStatus IN('1','3') $moreUser ORDER BY iuid DESC LIMIT $userLimit") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			} 
	}
	/*Calculate Subscription Earnings*/
	public function iN_CalculateSubEarnings($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$query = mysqli_query($this->db, "SELECT SUM(user_net_earning) AS subEarn FROM i_user_subscriptions WHERE subscribed_iuid_fk = '$userID' AND status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' AND MONTH(created)= MONTH(CURDATE())") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($row['subEarn']) ? $row['subEarn'] : '0.00';
		}
	}
	/*Calculate Premium Earnings*/
	public function iN_CalculatePremiumEarnings($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == '1') {
			$query = mysqli_query($this->db, "SELECT SUM(user_earning) AS premiumEarn FROM i_user_payments WHERE payed_iuid_fk = '$userID' AND MONTH(FROM_UNIXTIME(payment_time))= MONTH(CURDATE())") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($row['premiumEarn']) ? $row['premiumEarn'] : '0.00';
		}
	}
	/*SAVED POSTS*/
	public function iN_SavedPosts($userID, $lastPostID, $showingPost) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and S.saved_post_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,S.save_id, S.iuid_fk, S.saved_post_id,U.iuid,U.i_username,U.i_user_fullname,U.payout_method,U.thanks_for_tip,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
		FROM i_saved_posts S FORCE INDEX(ixSaved)
		INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
		   ON S.saved_post_id = P.post_id
		INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON S.iuid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE S.iuid_fk = '$userID' $morePost ORDER BY S.saved_post_id DESC LIMIT 1") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getData, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Update User Language*/
	public function iN_UpdateLanguage($userID, $langID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$langID = mysqli_real_escape_string($this->db, $langID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckLangIDExist($langID)) {
			$langKey = $this->iN_CheckLangIDExist($langID);
			mysqli_query($this->db, "UPDATE i_users SET lang = '$langKey' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Search User*/
	public function iN_GetSearchResult($key, $showingNumberOfPost) {
		$key = mysqli_real_escape_string($this->db, $key);
		mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
		$result = mysqli_query($this->db, "SELECT * FROM i_users WHERE (i_username Like '%$key' OR i_user_fullname Like '$key%' OR i_user_fullname Like '$key' OR i_username Like '$key') AND uStatus IN('1','3') ORDER BY iuid LIMIT $showingNumberOfPost") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Create a Conversation and Insert First Message Between Users*/
	public function iN_CreateConverationAndInsertFirstMessage($userID, $user, $firstMessage) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$user = mysqli_real_escape_string($this->db, $user);
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckUserExist($user) == 1 && $this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckConversationStartedBeforeBetweenUsers($userID, $user) == 0) {
			$query = mysqli_query($this->db, "INSERT INTO i_chat_users (user_one, user_two)VALUES('$userID','$user')") or die(mysqli_error($this->db));
			$getChatID = mysqli_query($this->db, "SELECT * FROM i_chat_users WHERE user_one = '$userID' AND user_two = '$user'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($getChatID, MYSQLI_ASSOC);
			if (mysqli_num_rows($getChatID) == 1) {
				$time = time();
				$chatID = isset($row['chat_id']) ? $row['chat_id'] : NULL;
				$query = mysqli_query($this->db, "INSERT INTO i_chat_conversations (chat_id_fk, user_one, user_two, message , time)VALUES('$chatID','$userID', '$user', '$firstMessage','$time')") or die(mysqli_error($this->db));
				return $chatID;
			} else {
				return FALSE;
			}
		} else {
			return false;
		}
	}
	/*Get Conversation ID Between Two Users*/
	public function iN_GetConverationID($userIDone, $userIDTwo) {
		$userIDone = mysqli_real_escape_string($this->db, $userIDone);
		$userIDTwo = mysqli_real_escape_string($this->db, $userIDTwo);
		if ($this->iN_CheckUserExist($userIDone) == 1 && $this->iN_CheckUserExist($userIDTwo) == 1) {
			$getID = mysqli_query($this->db, "SELECT chat_id FROM i_chat_users WHERE user_one = '$userIDone' AND user_two = '$userIDTwo' OR user_one = '$userIDTwo' AND user_two = '$userIDone'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($getID, MYSQLI_ASSOC);
			if (mysqli_num_rows($getID) == 1) {
				return isset($row['chat_id']) ? $row['chat_id'] : NULL;
			} else {
				return false;
			}
		}
	}
	/*Update Theme*/
	public function iN_UpdateUserTheme($userID, $uTheme) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$uTheme = mysqli_real_escape_string($this->db, $uTheme);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET light_dark = '$uTheme' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Check Message ID Exist*/
	public function iN_CheckMesageIDExist($userID, $messageID, $conversationID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$conversationID = mysqli_real_escape_string($this->db, $conversationID);
		$messageID = mysqli_real_escape_string($this->db, $messageID);
		$checkMessage = mysqli_query($this->db, "SELECT * FROM i_chat_conversations WHERE chat_id_fk = '$conversationID' AND con_id = '$messageID' AND user_one = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkMessage) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Delete Message*/
	public function iN_DeleteMessageFromData($userID, $messageID, $conversationID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$conversationID = mysqli_real_escape_string($this->db, $conversationID);
		$messageID = mysqli_real_escape_string($this->db, $messageID);
		if ($this->iN_CheckMesageIDExist($userID, $messageID, $conversationID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_chat_conversations WHERE chat_id_fk = '$conversationID' AND con_id = '$messageID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check Conversation Exist*/
	public function iN_CheckConversationIDExist($conversationID, $userID){
	    mysqli_query($this->db, "DELETE FROM i_chat_users WHERE chat_id = '$conversationID' AND (user_one = '$userID' OR user_two = '$userID')") or die(mysqli_error($this->db));
	    return true;
	}
	/*Delete This Conversation*/
	public function iN_DeleteConversationFromData($userID, $conversationID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$conversationID = mysqli_real_escape_string($this->db, $conversationID); 
		if ($this->iN_CheckConversationIDExist($conversationID, $userID) == '1') {
			mysqli_query($this->db, "DELETE FROM i_chat_conversations WHERE chat_id_fk = '$conversationID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_chat_users WHERE chat_id = '$conversationID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Search Following Users*/
	public function iN_SearchChatUsers($userID, $searchKey) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$searchKey = mysqli_real_escape_string($this->db, $searchKey);
		mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
		if ($this->iN_CheckUserExist($userID) == 1 && !empty($searchKey)) {
			$result = mysqli_query($this->db, "SELECT * FROM i_users WHERE (i_username Like '%$searchKey' OR i_user_fullname Like '$searchKey%' OR i_user_fullname Like '$searchKey' OR i_username Like '$searchKey') AND uStatus IN('1','3') AND (SELECT fr_one FROM i_friends WHERE fr_one = '$userID' AND fr_two <> '$userID' AND fr_status <> 'me') = '1' ORDER BY iuid LIMIT 10") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$data[] = $this->iN_GetUserDetails($row['iuid']);
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Hide Noticiation*/
	public function iN_HideNotification($userID, $hideID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$hideID = mysqli_real_escape_string($this->db, $hideID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckNotificationIDExist($hideID) == 1) {
			mysqli_query($this->db, "UPDATE i_user_notifications SET not_show_hide = '1' WHERE not_id = '$hideID' AND not_own_iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*User Total Blocked User*/
	public function iN_UserTotalBlocks($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalBlocks FROM i_user_blocks WHERE blocker_iuid = '$userID'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalBlocks']) ? $row['totalBlocks'] : '0';
		}
	}
	/*Payments Subscriptions List*/
	public function iN_UserBlockedListPage($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			B.block_id, B.blocker_iuid, B.blocked_iuid, B.block_type,B.blocked_time, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_blocks B FORCE INDEX(ixBlocked)
			ON B.blocked_iuid = U.iuid AND U.uStatus IN('1','3')
			WHERE B.blocker_iuid = '$userID' ORDER BY B.block_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*UnBlock User*/
	public function iN_UnBlockUser($userID, $unBlockID, $unBlockUserID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$unBlockID = mysqli_real_escape_string($this->db, $unBlockID);
		$unBlockUserID = mysqli_real_escape_string($this->db, $unBlockUserID);
		if ($this->iN_CheckUserBlocked($userID, $unBlockUserID) == 1 && $this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "DELETE FROM  i_user_blocks WHERE block_id = '$unBlockID' AND blocker_iuid = '$userID' AND blocked_iuid = '$unBlockUserID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Password*/
	public function iN_UpdatePassword($userID, $newPassword) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$newPassword = mysqli_real_escape_string($this->db, $newPassword);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "UPDATE i_users SET i_password = '$newPassword' WHERE iuid = '$userID' AND uStatus IN('1','3')") or die(mysqli_error($this->db));
			if ($query) {
				mysqli_query($this->db, "DELETE FROM i_sessions WHERE session_uid = '$userID'") or die(mysqli_error($this->db));
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/*Update Profile Preferences (Email notification)*/
	public function iN_UpdateEmailNotificationStatus($userID, $status) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$status = mysqli_real_escape_string($this->db, $status);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET email_notification_status = '$status' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Profile Preferences (Message Send Status)*/
	public function iN_UpdateMessageSendStatus($userID, $status) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$status = mysqli_real_escape_string($this->db, $status);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET message_status = '$status' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Profile Preferences (Message Send Status)*/
	public function iN_UpdateShowHidePostsStatus($userID, $status) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$status = mysqli_real_escape_string($this->db, $status);
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_users SET show_hide_posts = '$status' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Total Subscription Earnings*/
	public function iN_TotalSubscriptionEarnings($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS subEarn FROM i_user_subscriptions WHERE status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' ") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($row['subEarn']) ? $row['subEarn'] : '0.00';
		}
	}
	/*Total Admin Premium Earnings*/
	public function iN_TotalPremiumEarnings($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS premEarn FROM i_user_payments WHERE payment_status = 'ok'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($row['premEarn']) ? $row['premEarn'] : '0.00';
		}
	}
	/*Total User*/
	public function iN_TotalUsers() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS userCount FROM i_users WHERE uStatus IN('1','2','3')") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return $row['userCount'];
		} else {return 0;}
	}
	/*Total Posts*/
	public function iN_TotalUserPosts() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS tPosts FROM i_posts") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return $row['tPosts'];
		} else {return 0;}
	}
	/*Total Sticker*/
	public function iN_TotalSticker() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS stickerCount FROM i_stickers") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return $row['stickerCount'];
		} else {return 0;}
	}
	/*Total Withdrawal Payments*/
	public function iN_TotalUsersWithdrawals() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS userCount FROM i_user_payouts WHERE payment_type = 'withdrawal'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return $row['userCount'];
		} else {return 0;}
	}
	/*Total Subscription Payments*/
	public function iN_TotalUsersSubscriptions() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS userCount FROM i_user_payouts WHERE payment_type = 'subscription'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return $row['userCount'];
		} else {return 0;}
	}
	/*Total Premium Earnings Weekly*/
	public function iN_WeeklyTotalPremiumEarning() {
		$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS WeekTotalEarnPremium FROM i_user_payments WHERE  payment_status = 'ok' AND WEEK(FROM_UNIXTIME(payment_time)) = WEEK(NOW())") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['WeekTotalEarnPremium']) ? $row['WeekTotalEarnPremium'] : '0.00';
	}
	/*Total Premium Earnings Current Day*/
	public function iN_CurrentDayTotalPremiumEarning() {
		$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS DayTotalEarnPremium FROM i_user_payments WHERE payment_status = 'ok' AND DAY(FROM_UNIXTIME(payment_time)) = DAY(CURDATE()) ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['DayTotalEarnPremium']) ? $row['DayTotalEarnPremium'] : '0.00';
	}
	/*Total Premium Earnings Current Month*/
	public function iN_CurrentMonthTotalPremiumEarning() {
		$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS MonthTotalEarnPremium FROM i_user_payments WHERE payment_status = 'ok' AND MONTH(FROM_UNIXTIME(payment_time)) = MONTH(CURDATE()) ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['MonthTotalEarnPremium']) ? $row['MonthTotalEarnPremium'] : '0.00';
	}
	/*Total Premium Earnings Weekly*/
	public function iN_WeeklyTotalSubscriptionEarning() {
		$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS WeekTotalEarnSubscription FROM  i_user_subscriptions WHERE status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' AND WEEK(created) = WEEK(NOW())") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['WeekTotalEarnSubscription']) ? $row['WeekTotalEarnSubscription'] : '0.00';
	}
	/*Total Premium Earnings Current Day*/
	public function iN_CurrentDayTotalSubscriptionEarning() {
		$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS DayTotalEarnSubscription FROM  i_user_subscriptions WHERE status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' AND DAY(created) = DAY(CURDATE()) ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['DayTotalEarnSubscription']) ? $row['DayTotalEarnSubscription'] : '0.00';
	}
	/*Total Premium Earnings Current Month*/
	public function iN_CurrentMonthTotalSubscriptionEarning() {
		$query = mysqli_query($this->db, "SELECT SUM(admin_earning) AS MonthTotalEarnSubscription FROM  i_user_subscriptions WHERE status IN('active','inactive') AND in_status IN('1','0') AND finished = '0' AND MONTH(created) = MONTH(CURDATE()) ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['MonthTotalEarnSubscription']) ? $row['MonthTotalEarnSubscription'] : '0.00';
	}
	/*New Registered Latest 5 User*/
	public function iN_NewRegisteredUsers() {
		$query = mysqli_query($this->db, "SELECT * FROM i_users ORDER BY iuid DESC LIMIT 5") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Latest 5 Subscriptions List*/
	public function iN_LatestPaymentsSubscriptionsList() {
		$query = mysqli_query($this->db, "SELECT DISTINCT
			S.subscription_id, S.iuid_fk, S.subscribed_iuid_fk, S.subscriber_name, S.plan_id, S.plan_amount,S.admin_earning, S.plan_amount_currency, S.created, S.status, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_subscriptions S FORCE INDEX(ix_Subscribe)
		    ON S.subscribed_iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE S.status = 'active' ORDER BY S.subscription_id DESC LIMIT 5
			") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Latest Content Payments */
	public function iN_LatestContentPaymentsList() {
		$query = mysqli_query($this->db, "SELECT DISTINCT
			P.payment_id,P.payer_iuid_fk, P.payed_iuid_fk, P.payed_post_id_fk, P.payed_profile_id_fk, P.order_key, P.payment_type, P.payment_option, P.payment_time, P.payment_status, P.amount, P.fee, P.admin_earning, P.user_earning, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payments P FORCE INDEX(ixPayment)
		    ON P.payed_iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.payment_status = 'ok' ORDER BY P.payment_id DESC LIMIT 5
			") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Update Site Configurations*/
	public function iN_UpdateSiteConfiguration($userID, $watermark, $updateSiteLogo, $updateSiteFavicon, $updateSiteKeywords, $updateSiteDescription, $updateSiteTitle, $updateSiteName) {
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET site_watermark_logo = '$watermark', site = '$updateSiteName', site_title = '$updateSiteTitle', site_keywords = '$updateSiteKeywords', site_description = '$updateSiteDescription', site_logo = '$updateSiteLogo', site_favicon = '$updateSiteFavicon' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Site Business Informations*/
	public function iN_UpdateSiteBusinessInformations($userID, $updateSiteCampanyName, $updateSiteCountry, $updateSiteCity, $updateSiteBusinessAddress, $updateSitePostCode, $updateSiteVAT) {
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET campany = '$updateSiteCampanyName', country = '$updateSiteCountry', city = '$updateSiteCity', business_address = '$updateSiteBusinessAddress', post_code = '$updateSitePostCode', vat = '$updateSiteVAT' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Site Limit Values*/
	public function iN_UpdateLimitValues($userID,$oneSignalStatus,$oneSignalApiKey, $oneSignalRestApiKey, $reCaptchaStatus, $reCaptchaSiteKey, $reCaptchaSecretKey, $postCreateLimit,$blockCountryStatus, $fileLimit, $lengthLimit, $postShowLimit, $paginatonLimit, $approvalFileExtension, $availableUploadFileExtensions, $ffmpegPath, $unavailableUserNames) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET g_recaptcha_status = '$reCaptchaStatus', g_recaptcha_site_key = '$reCaptchaSiteKey', g_recaptcha_secret_key = '$reCaptchaSecretKey', normal_user_can_post = '$postCreateLimit', available_verification_file_extensions = '$approvalFileExtension', available_file_extensions = '$availableUploadFileExtensions', available_file_size = '$fileLimit', available_length = '$lengthLimit', load_more_limit = '$postShowLimit', pagination_limit = '$paginatonLimit' , ffmpeg_path = '$ffmpegPath' , disallowed_usernames = '$unavailableUserNames',one_signal_api = '$oneSignalApiKey', one_signal_rest_api = '$oneSignalRestApiKey', one_signal_status = '$oneSignalStatus' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Default Language*/
	public function iN_UpdateDefaultLanguage($userID, $lang) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckLangIDExist($lang)) {
			$langKey = $this->iN_CheckLangIDExist($lang);
			mysqli_query($this->db, "UPDATE i_configurations SET default_language = '$langKey' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Mantenance Mod*/
	public function iN_UpdateMaintenanceStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET maintenance_mode = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Email Send Mod*/
	public function iN_UpdateEmailSendStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET emailSendStatus = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Register Mod*/
	public function iN_UpdateRegisterStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET register = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update IP Limit Mod*/
	public function iN_UpdateIpLimitStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET ip_limit = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Email Settings*/
	public function iN_UpdateEmailSettings($userID, $updateSmtpEmail, $updateSmtpMail, $updateSmtpEncription, $updateSmtpHost, $updateSmtpUsername, $updateSmtpPassword, $updateSmtpPort) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET default_mail = '$updateSmtpEmail', smtp_or_mail = '$updateSmtpMail', smtp_encryption = '$updateSmtpEncription' , smtp_host = '$updateSmtpHost' , smtp_username = '$updateSmtpUsername' , smtp_password = '$updateSmtpPassword' , smtp_port = '$updateSmtpPort' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update AMAZON S3 Settings*/
	public function iN_UpdateAmazonS3Details($userID, $updateS3Region, $updateS3Bucket, $updateS3Key, $updateS3SecretKey, $updateS3Status) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET ocean_status = '0' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_configurations SET s3_region = '$updateS3Region', s3_bucket = '$updateS3Bucket' , s3_key = '$updateS3Key' , s3_secret_key = '$updateS3SecretKey' , s3_status = '$updateS3Status' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Waiting Approval or Approved Posts*/
	public function iN_aWaitingApprovalOrApprovedPostsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT P.post_id,P.shared_post_id,P.post_pined,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.url_slug,P.post_status,P.comment_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
			FROM i_posts P FORCE INDEX(ixForcePostOwner)
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON P.post_owner_id = U.iuid
			WHERE P.post_status IN('2') AND P.who_can_see = '4' ORDER BY P.post_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Calculate Non Approved Posts*/
	public function iN_CalculateNonApprovedPosts() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS nonApprovedPost FROM i_posts WHERE post_status = '2' AND who_can_see = '4'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['nonApprovedPost']) ? $row['nonApprovedPost'] : '0';
	}
	/*Calculate All Posts*/
	public function iN_CalculateAllPosts() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_posts ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Calculate All Storie Posts*/
	public function iN_CalculateAllStoriePosts() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_user_stories ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Calculate All Questions*/
	public function iN_CalculateAllQuestions() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_contacts ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Calculate All Reported Posts*/
	public function iN_CalculateAllUnReadReportedPosts() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_post_reports WHERE report_status = '0' ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Calculate All Reported Comments*/
	public function iN_CalculateAllUnReadReportedComments() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_comment_reports WHERE report_status = '0' ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Calculate All Premium Posts*/
	public function iN_CalculateAllPremiumPosts() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_posts WHERE who_can_see = '4' AND post_status = '1'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Calculate All Subscribers Posts*/
	public function iN_CalculateAllSubscribersPosts() {
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS psts FROM i_posts WHERE who_can_see = '3' AND post_status = '1'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['psts']) ? $row['psts'] : '0';
	}
	/*Approve / Reject / Decline Premium Post*/
	public function iN_UpdateApprovePostStatus($userID, $postDescription, $postNewPoint, $postApproveStat, $postID, $postOwnerID, $approveNot) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckUserExist($postOwnerID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$time = time();
			$stat = '1';
			$notType = 'accepted_post';
			if ($postApproveStat != '1') {
				$stat = '2';
			}
			if ($postApproveStat == '2') {
				$notType = 'rejected_post';
			}
			if ($postApproveStat == '3') {
				$notType = 'declined_post';
			}
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_posts SET post_text = '$postDescription', post_wanted_credit = '$postNewPoint', post_status = '$stat' WHERE post_id = '$postID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "INSERT INTO i_approve_post_notification(approved_post_id,approved_post_owner_id,approve_status,approve_not,appprove_time)VALUES('$postID','$postOwnerID','$postApproveStat','$approveNot','$time')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "INSERT INTO i_user_notifications(not_post_id, not_not_type,not_time, not_own_iuid, not_iuid)VALUES('$postID','$notType','$time','$postOwnerID','$userID')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE iuid = '$postOwnerID'");
			return true;
		} else {
			return false;
		}
	}
	public function iN_UpdatePostDetailsAdmin($userID, $postDescription, $editedPostID, $editedPostOwnerID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckUserExist($editedPostOwnerID) == 1 && $this->iN_CheckPostIDExist($editedPostID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_posts SET post_text = '$postDescription' WHERE post_id = '$editedPostID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Post*/
	public function iN_DeletePremiumPostBeforeApprove($userID, $postID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$getPostFileIDs = $this->iN_GetAllPostDetails($postID);
			$postFileIDs = isset($getPostFileIDs['post_file']) ? $getPostFileIDs['post_file'] : NULL;
			if ($postFileIDs) {
				$trimValue = rtrim($postFileIDs, ',');
				$explodeFiles = explode(',', $trimValue);
				$explodeFiles = array_unique($explodeFiles);
				foreach ($explodeFiles as $explodeFile) {
					$theFileID = $this->iN_GetUploadedFileDetails($explodeFile);
					$uploadedFileID = isset($theFileID['upload_id']) ? $theFileID['upload_id'] : NULL;
					$uploadedFilePath = isset($theFileID['uploaded_file_path']) ? $theFileID['uploaded_file_path'] : NULL;
					$uploadedFilePathX = isset($theFileID['uploaded_x_file_path']) ? $theFileID['uploaded_x_file_path'] : NULL;
					@unlink('../../../' . $uploadedFilePath);
					@unlink('../../../' . $uploadedFilePathX);
					mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE upload_id = '$uploadedFileID' AND iuid_fk = '$userID'");
				}
			}
			mysqli_query($this->db, "DELETE FROM i_posts WHERE post_id = '$postID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*All Posts*/
	public function iN_AllTypePostsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT P.post_id,P.shared_post_id,P.post_pined,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.url_slug,P.post_status,P.comment_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
			FROM i_posts P FORCE INDEX(ixForcePostOwner)
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON P.post_owner_id = U.iuid
			WHERE P.post_status IN('0','1','2') ORDER BY P.post_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*All Premium Posts*/
	public function iN_AllPremiumTypePostsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT P.post_id,P.shared_post_id,P.post_pined,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.url_slug,P.post_status,P.comment_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
			FROM i_posts P FORCE INDEX(ixForcePostOwner)
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON P.post_owner_id = U.iuid
			WHERE P.post_status IN('1') AND P.who_can_see = '4' ORDER BY P.post_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*All Subscribers Posts*/
	public function iN_AllSubscribersTypePostsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT P.post_id,P.shared_post_id,P.post_pined,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.post_wanted_credit,P.url_slug,P.post_status,P.comment_status,U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
			FROM i_posts P FORCE INDEX(ixForcePostOwner)
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON P.post_owner_id = U.iuid
			WHERE P.post_status IN('1') AND P.who_can_see = '3' ORDER BY P.post_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Get Custom Codes*/
	public function iN_GetCustomCodes($cID) {
		$cID = mysqli_real_escape_string($this->db, $cID);
		$query = mysqli_query($this->db, "SELECT * FROM i_custom_codes WHERE custom_id = '$cID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return isset($data['custom_code']) ? $data['custom_code'] : FALSE;
	}
	/*Update Custom*/
	public function iN_UpdateCustomCodes($userID, $customCssCode, $cID) {
		$cID = mysqli_real_escape_string($this->db, $cID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_custom_codes SET custom_code = '$customCssCode' WHERE custom_id = '$cID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*All SVG Icons List*/
	public function iN_AllSVGIcons() {
		$query = mysqli_query($this->db, "SELECT * FROM i_svg_icons") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get Custom Codes*/
	public function iN_GetSVGCodeFromID($cID) {
		$cID = mysqli_real_escape_string($this->db, $cID);
		$query = mysqli_query($this->db, "SELECT * FROM i_svg_icons WHERE icon_id = '$cID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return isset($data['icon_code']) ? $data['icon_code'] : FALSE;
	}
	/*Update SVG Code*/
	public function iN_UpdateSVGCode($userID, $cID, $svgCode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_svg_icons SET icon_code = '$svgCode' WHERE icon_id = '$cID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check Icon ID Exist*/
	public function iN_CheckIconIDExist($iconID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_svg_icons WHERE icon_id = '$iconID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Update SVG Icon Status*/
	public function iN_UpdateSVGIconStatus($userID, $mod, $iconID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckIconIDExist($iconID) == 1) {
			mysqli_query($this->db, "UPDATE i_svg_icons SET icon_status = '$mod' WHERE icon_id = '$iconID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert New SVG ICON*/
	public function iN_InsertNewSVGCode($userID, $newSVGCode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "INSERT INTO i_svg_icons(icon_code, icon_status)VALUES('$newSVGCode','0')") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Update Point Plan*/
	public function iN_UpdatePlanFromID($userID, $planKey, $planPoint, $planAmount, $plandID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckPlanExist($plandID)) {
			mysqli_query($this->db, "UPDATE i_premium_plans SET plan_name_key = '$planKey', plan_amount = '$planPoint', amount = '$planAmount' WHERE plan_id = '$plandID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert New POINT PLAN*/
	public function iN_InsertNewPointPlan($userID, $planKey, $planPointAmount, $planAmount) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "INSERT INTO i_premium_plans(plan_name_key, plan_amount,amount,plan_status)VALUES('$planKey','$planPointAmount','$planAmount','0')") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Plan Status*/
	public function iN_UpdatePlanStatus($userID, $mod, $planID) {
		$planID = mysqli_real_escape_string($this->db, $planID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckPlanExist($planID)) {
			mysqli_query($this->db, "UPDATE i_premium_plans SET plan_status = '$mod' WHERE plan_id = '$planID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Premium Plan List*/
	public function iN_PremiumPlansListFromAdmin() {
		$query = mysqli_query($this->db, "SELECT * FROM i_premium_plans ") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Delete Plan*/
	public function iN_DeletePlanFromData($userID, $planID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckPlanExist($planID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_premium_plans WHERE plan_id = '$planID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	public function iN_LanguagesList() {
		$query = mysqli_query($this->db, "SELECT * FROM i_langs") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get Language Details From ID*/
	public function iN_GetLangDetails($langID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_langs WHERE  lang_id = '$langID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return $data;
	}
	/*Check Language ID exist*/
	public function iN_CheckLangIDExistWithoutStatus($langID) {
		$langID = mysqli_real_escape_string($this->db, $langID);
		$query = mysqli_query($this->db, "SELECT * FROM i_langs WHERE lang_id = '$langID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return isset($data['lang_name']) ? $data['lang_name'] : FALSE;
	}
	/*Update Language Status*/
	public function iN_UpdateLanguageStatus($userID, $mod, $langID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && !empty($this->iN_CheckLangIDExistWithoutStatus($langID))) {
			mysqli_query($this->db, "UPDATE i_langs SET lang_status = '$mod' WHERE lang_id = '$langID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Language*/
	public function iN_UpdateLanguageByID($userID, $langKey, $langID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && !empty($this->iN_CheckLangIDExistWithoutStatus($langID))) {
			mysqli_query($this->db, "UPDATE i_langs SET lang_name = '$langKey' WHERE lang_id = '$langID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Add New Language*/
	public function iN_AddNewLanguageFromData($userID, $langKey) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "INSERT INTO i_langs(lang_name, lang_status)VALUES('$langKey','0')") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Language*/
	public function iN_DeleteLanguage($userID, $langID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && !empty($this->iN_CheckLangIDExistWithoutStatus($langID))) {
			mysqli_query($this->db, "DELETE FROM i_langs WHERE lang_id = '$langID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*All Posts*/
	public function iN_AllTypeOfUsersList($userID, $paginationLimit, $page, $searchValue) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;  
		$startSearch = '';
		if(!empty($searchValue)){
           $startSearch = "WHERE (i_user_email Like '%$searchValue' OR i_user_email Like '$searchValue%' OR i_user_email Like '$searchValue' OR i_username Like '%$searchValue' OR i_user_fullname Like '$searchValue%' OR i_user_fullname Like '$searchValue' OR i_user_fullname Like '%$searchValue%' OR i_username Like '$searchValue')";
		}
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_users $startSearch ORDER BY iuid DESC LIMIT $start_from, $paginationLimit ") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Update Some User Profile*/
	public function iN_UpdateUserProfile($userID, $updatedUser, $updateVerification, $updateUserType, $updateUserWallet) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckUserExist($updatedUser) == 1) {
			if ($updateVerification == '2') {
				mysqli_query($this->db, "UPDATE i_users SET email_verify_status = 'yes' , verify_key =  NULL ,user_verified_status = '1', certification_status = '2', validation_status = '2', condition_status = '2', fees_status = '2', payout_status = '2', userType = '$updateUserType' , wallet_points = '$updateUserWallet' WHERE iuid = '$updatedUser'") or die(mysqli_error($this->db));
				return true;
			} else if ($updateVerification == '1') {
				mysqli_query($this->db, "UPDATE i_users SET certification_status = '2', validation_status = '1', userType = '$updateUserType' , wallet_points = '$updateUserWallet' WHERE iuid = '$updatedUser'") or die(mysqli_error($this->db));
				return true;
			} else {
				mysqli_query($this->db, "UPDATE i_users SET certification_status = '0', validation_status = '0', condition_status = '0', fees_status = '0', payout_status = '0',userType = '$updateUserType' , wallet_points = '$updateUserWallet' WHERE iuid = '$updatedUser'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Delete User*/
	public function iN_DeleteUser($userID, $deleteUserID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckUserExist($deleteUserID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_users WHERE iuid = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_chat_conversations WHERE user_one = '$deleteUserID' OR user_two = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_chat_users WHERE user_one = '$deleteUserID' OR user_two = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_comment_reports WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_friends WHERE fr_one = '$deleteUserID' OR fr_two = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_posts WHERE post_owner_id = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_post_comments WHERE comment_uid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_post_comment_likes WHERE c_like_iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_post_likes WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_post_reports WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_saved_posts WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_sessions WHERE session_uid = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_users WHERE iuid = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_avatars WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_blocks WHERE blocker_iuid = '$deleteUserID' OR blocked_iuid = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_conversation_uploads WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_covers WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_notifications WHERE not_iuid = '$deleteUserID' OR not_own_iuid = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_subscribe_plans WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_subscriptions WHERE iuid_fk = '$deleteUserID' OR subscribed_iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_verification_requests WHERE iuid_fk = '$deleteUserID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Total Creator Verification Requests User*/
	public function iN_TotalVerificationRequests() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS verificationCount FROM i_verification_requests WHERE request_status = '0'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return isset($row['verificationCount']) ? $row['verificationCount'] : '0';
		} else {return 0;}
	}
	/*All Posts*/
	public function iN_AllVerficationRequestList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_verification_requests WHERE request_status IN('0') ORDER BY request_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Get Verification Request Details BY ID*/
	public function iN_GetVerificationRequestFromID($vID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_verification_requests WHERE request_id = '$vID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return $data;
	}
	/*Check Verification Request Exist*/
	public function iN_CheckVerificationRequestExist($vID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_verification_requests WHERE request_id = '$vID'") or die(mysqli_error($this->db, $vID));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Delete Verification Request*/
	public function iN_DeleteVerificationRequest($userID, $verificationRequestID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == '1' && $this->iN_CheckVerificationRequestExist($verificationRequestID)) {
			$getUser = $this->iN_GetVerificationRequestFromID($verificationRequestID);
			$iuIDfk = $getUser['iuid_fk'];
			mysqli_query($this->db, "UPDATE i_users SET certification_status = '0' WHERE iuid = '$iuIDfk'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_verification_requests WHERE request_id = '$verificationRequestID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Update / Insert Approve Verification Request*/
	public function iN_UpdateVerificationProfileStatus($userID, $answerType, $answerValue, $answeringVerificationID) {
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckIsAdmin($userID) == '1' && $this->iN_CheckVerificationRequestExist($answeringVerificationID) == 1) {
			$data = $this->iN_GetVerificationRequestFromID($answeringVerificationID);
			$iuIDfk = $data['iuid_fk'];
			if ($answerType == '1') {
				mysqli_query($this->db, "UPDATE i_verification_requests SET request_status = '1', request_not = '$answerValue' WHERE request_id = '$answeringVerificationID'") or die(mysqli_error($this->db));
				mysqli_query($this->db, "UPDATE i_users SET certification_status = '1', validation_status = '1' WHERE iuid = '$iuIDfk'") or die(mysqli_error($this->db));
				return true;
			} else if ($answerType == '2') {
				mysqli_query($this->db, "UPDATE i_verification_requests SET request_status = '2', request_not = '$answerValue' WHERE request_id = '$answeringVerificationID'") or die(mysqli_error($this->db));
				mysqli_query($this->db, "UPDATE i_users SET certification_status = '0', validation_status = '0' WHERE iuid = '$iuIDfk'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Check User Have Verification Request*/
	public function iN_CheckUserHasVerificationRequest($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID)) {
			$query = mysqli_query($this->db, "SELECT * FROM i_verification_requests WHERE iuid_fk = '$userID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			/*Return result if icon id exist or not*/
			return $data;
		} else {
			return false;
		}
	}
	/*Update Read Status*/
	public function iN_UpdateVerificationAnswerReadStatus($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID)) {
			mysqli_query($this->db, "UPDATE i_verification_requests SET user_read_status = '1' WHERE iuid_fk = '$userID'") or die(mysqli_error($this->db));
		} else {
			return false;
		}
	}
	/*GET ALL PAGE DETAILS*/
	public function iN_GetPageDetails($pageID) {
		$pageID = mysqli_real_escape_string($this->db, $pageID);
		$query = mysqli_query($this->db, "SELECT * FROM i_pages WHERE page_id = '$pageID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $row;
		} else {
			return false;
		}
	}
	/*Update Page Details*/
	public function iN_SavePageEdit($userID, $pageTitle, $pageSeoUrl, $pageEditor, $pageID) {
		if ($this->iN_CheckIsAdmin($userID) == '1' && $this->iN_CheckpageExistByID($pageID)) {
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_pages SET page_title = '$pageTitle', page_name = '$pageSeoUrl', page_inside = '$pageEditor' WHERE page_id = '$pageID'") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Create a New Page*/
	public function iN_CreateANewPage($userID, $pageTitle, $pageSeoUrl, $pageEditor) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "INSERT INTO i_pages(page_title, page_name, page_created_time, page_inside)VALUES('$pageTitle','$pageSeoUrl','$time','$pageEditor')") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Post*/
	public function iN_DeletePage($userID, $pageID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckpageExistByID($pageID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_pages WHERE page_id = '$pageID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check User Email or IP address Sended Contact Email Before*/
	public function iN_CheckAlreadyHaveMail($contacterEmail, $ip) {
		$query = mysqli_query($this->db, "SELECT * FROM i_contacts WHERE contact_email = '$contacterEmail' OR contact_ip = '$ip' AND contact_read_status = '0'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Insert New Contact Email*/
	public function iN_InsertUserContactMessage($contacterFullName, $contacterEmail, $contactMessage, $ip) {
		$time = time();
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		$query = mysqli_query($this->db, "INSERT INTO i_contacts(contact_full_name, contact_email, contact_message, contact_time, contact_ip, contact_read_status)VALUES('$contacterFullName','$contacterEmail','$contactMessage', '$time', '$ip','0')") or die(mysqli_error($this->db));
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	/*All Stickers*/
	public function iN_AllStickersList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_stickers ORDER BY sticker_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Get Sticker Details From ID*/
	public function iN_GetStickerDetailsFromID($sID) {
		$sID = mysqli_real_escape_string($this->db, $sID);
		$query = mysqli_query($this->db, "SELECT * FROM i_stickers WHERE sticker_id = '$sID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return $data;
	}
	/*Update Sticker URL*/
	public function iN_UpdateStickerURL($userID, $stickerUrl, $sID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckStickerIDExist($sID) == 1) {
			mysqli_query($this->db, "UPDATE i_stickers SET sticker_url = '$stickerUrl' WHERE sticker_id = '$sID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Sticker*/
	public function iN_DeleteSticker($userID, $stickerid) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckStickerIDExist($stickerid) == 1) {
			mysqli_query($this->db, "DELETE FROM i_stickers WHERE sticker_id = '$stickerid'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert New Sticker URL*/
	public function iN_InsertNewStickerURL($userID, $newStickerUrl) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "INSERT INTO i_stickers(sticker_url)VALUES('$newStickerUrl')") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Sticker Status*/
	public function iN_UpdateStickerStatus($userID, $mode, $sID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_stickers SET sticker_status = '$mode' WHERE sticker_id = '$sID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Payment Settings*/
	public function iN_UpdatePaymentSettings($userID, $minTipAmount,$defaultSubsType, $defaultCurrency, $comissionFee, $minimumSubscriptionAmountWeekly, $minimumSubscriptionAmountMonthly, $minimumSubscriptionAmountYearly, $minimumPointAmount, $maximumPointAmount, $pointToMoney, $minWihDrawlAmount , $minFeePointWeekly, $minFeePointMonthly, $minFeePointYearly) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET min_tip_amount = '$minTipAmount', subscription_type = '$defaultSubsType', default_currency = '$defaultCurrency', fee = '$comissionFee', sub_weekly_minimum_amount = '$minimumSubscriptionAmountWeekly', sub_monthly_minimum_amount = '$minimumSubscriptionAmountMonthly', sub_yearly_minimum_amount ='$minimumSubscriptionAmountYearly', min_point_limit = '$minimumPointAmount', max_point_limit = '$maximumPointAmount', one_point = '$pointToMoney',  minimum_withdrawal_amount = '$minWihDrawlAmount' , min_point_fee_weekly = '$minFeePointWeekly', min_point_fee_monthly = '$minFeePointMonthly', min_point_fee_yearly = '$minFeePointYearly'  WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayPal Sendbox Mode*/
	public function iN_UpdatePayPalSendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET paypal_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayPal Status*/
	public function iN_UpdatePayPalStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET paypal_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayPal Details*/
	public function iN_UpdatePayPalDetails($userID, $sandBoxEmail, $paypalProductEmail, $paypalCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET paypal_sendbox_business_email = '$sandBoxEmail', paypal_product_business_email = '$paypalProductEmail', paypal_crncy ='$paypalCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update BitPay Sendbox Mode*/
	public function iN_UpdateBitPaySendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET bitpay_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update BitPay Status*/
	public function iN_UpdateBitPayStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET bitpay_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayPal Details*/
	public function iN_UpdateBitPayDetails($userID, $bitNotificationEmail, $bitPassword, $bitPairingCode, $bitLabel, $bitCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET bitpay_notification_email = '$bitNotificationEmail', bitpay_password = '$bitPassword', bitpay_pairing_code ='$bitPairingCode', bitpay_label = '$bitLabel', bitpay_crncy = '$bitCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Stripe Sendbox Mode*/
	public function iN_UpdateStripeSendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET stripe_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Stripe Status*/
	public function iN_UpdateStripeStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET stripe_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Stripe Details*/
	public function iN_UpdateStripeDetails($userID, $stTestSecretKey, $stTestPublicKey, $stLiveSecretKey, $stLivePublicKey, $stCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET stripe_test_secret_key = '$stTestSecretKey', stripe_test_public_key = '$stTestPublicKey', stripe_live_secret_key ='$stLiveSecretKey', stripe_live_public_key = '$stLivePublicKey', stripe_crncy = '$stCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Stripe Sendbox Mode*/
	public function iN_UpdateAuthorizeNetSendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET authorize_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Stripe Status*/
	public function iN_UpdateAuthorizeNetStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET authorizenet_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update AuthorizeNet Details*/
	public function iN_UpdateAuthorizeNetDetails($userID, $autTestAppID, $autTestTransactionKey, $autLiveAppID, $autLiveTransactionKey, $autCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET authorizenet_test_ap_id = '$autTestAppID', authorizenet_test_transaction_key = '$autTestTransactionKey', authorizenet_live_api_id ='$autLiveAppID', authorizenet_live_transaction_key = '$autLiveTransactionKey', authorize_crncy = '$autCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update IyziCo Sendbox Mode*/
	public function iN_UpdateIyziCoSendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET iyzico_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update IyziCo Status*/
	public function iN_UpdateIyziCoStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET iyzico_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update IyziCo Details*/
	public function iN_UpdateIyziCoDetails($userID, $iyziTestSecretKey, $iyziTestApiKey, $iyziLiveApiKey, $iyziLiveApiSeckretKey, $iyziCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET iyzico_testing_secret_key = '$iyziTestSecretKey', iyzico_testing_api_key = '$iyziTestApiKey', iyzico_live_api_key ='$iyziLiveApiKey', iyzico_live_secret_key = '$iyziLiveApiSeckretKey', iyzico_crncy = '$iyziCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update RazorPay Sendbox Mode*/
	public function iN_UpdateRazorPaySendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET razorpay_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update RazorPay Status*/
	public function iN_UpdateRazorPayStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET razorpay_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update RazorPay Details*/
	public function iN_UpdateRazorPayDetails($userID, $razorTestKey, $razorTestSecret, $razorLiveKey, $razorLiveSecret, $razorCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET razorpay_testing_key_id = '$razorTestKey', razorpay_testing_secret_key = '$razorTestSecret', razorpay_live_key_id ='$razorLiveKey', razorpay_live_secret_key = '$razorLiveSecret', razorpay_crncy = '$razorCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayStack Sendbox Mode*/
	public function iN_UpdatePayStackSendBoxMode($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET paystack_payment_mode = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayStack Status*/
	public function iN_UpdatePayStackStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET paystack_active_pasive = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update PayStack Details*/
	public function iN_UpdatePayStackDetails($userID, $payStackTestSecret, $payStackTestPublic, $payStackLiveSecret, $payStackLivePublic, $payStackCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET paystack_testing_secret_key = '$payStackTestSecret', paystack_testing_public_key = '$payStackTestPublic', paystack_live_secret_key ='$payStackLiveSecret', pay_stack_liive_public_key = '$payStackLivePublic', paystack_crncy = '$payStackCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	public function iN_UpdateSocialLoginDetails($userID, $GoogleCliendID, $TwitterCliendID, $GoogleIcon, $TwitterIcon, $GoogleCliendSecret, $TwitterCliendSecret, $GoogleSocialLoginStatus, $TwitterSocialLoginStatus) {

		$gCliendID = !empty($GoogleCliendID) ? "'$GoogleCliendID'" : "NULL";
		$tCliendID = !empty($TwitterCliendID) ? "'$TwitterCliendID'" : "NULL";
		$gIcon = !empty($GoogleIcon) ? "'$GoogleIcon'" : "NULL";
		$tIcon = !empty($TwitterIcon) ? "'$TwitterIcon'" : "NULL";
		$gCliendSecret = !empty($GoogleCliendSecret) ? "'$GoogleCliendSecret'" : "NULL";
		$tCliendSecret = !empty($TwitterCliendSecret) ? "'$TwitterCliendSecret'" : "NULL";
		$gLStatus = !empty($GoogleSocialLoginStatus) ? "'$GoogleSocialLoginStatus'" : "'0'";
		$tLStatus = !empty($TwitterSocialLoginStatus) ? "'$TwitterSocialLoginStatus'" : "'0'";
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_social_logins SET s_key_one = $gCliendID , s_key_two = $gCliendSecret , s_icon = $gIcon , s_status = $gLStatus WHERE s_id = '1'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_social_logins SET s_key_one = $tCliendID , s_key_two = $tCliendSecret , s_icon = $tIcon , s_status = $tLStatus WHERE s_id = '2'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Payments Withdrawal AND Subscription Payments List*/
	public function iN_PayoutWithdrawalAndSubscriptionHistory($userID, $paginationLimit, $page, $type) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			P.payout_id, P.iuid_fk, P.amount, P.method, P.payout_time, P.status,P.payment_type, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payouts P FORCE INDEX(ix_PayoutUser)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.payment_type = '$type' ORDER BY P.payout_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Get User Payout Details*/
	public function iN_GetUserPayoutDetails($userID, $ID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$ID = mysqli_real_escape_string($this->db, $ID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_payouts WHERE payout_id = '$ID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Check Payment ID Exist*/
	public function iN_CheckPaymentRequestIDExist($userID, $declineID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_payouts WHERE payout_id = '$declineID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($query) == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/*Update Payout Status*/
	public function iN_UpdatePayoutStatus($userID, $id) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "UPDATE i_user_payouts SET status = 'payed', paid_time = '$time' WHERE payout_id = '$id'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Ok Decline*/
	public function iN_DeclineRequest($userID, $declinedID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$uData = $this->iN_GetUserPayoutDetails($userID, $declinedID);
			$uDataUserID = $uData['iuid_fk'];
			$uDataAmount = $uData['amount'];
			$updateUserData = mysqli_query($this->db, "UPDATE i_users SET wallet_money = wallet_money + $uDataAmount WHERE iuid = '$uDataUserID'") or die(mysqli_error($this->db));
			$updatePayoutStatus = mysqli_query($this->db, "UPDATE i_user_payouts SET status = 'declined' WHERE payout_id = '$declinedID'") or die(mysqli_error($this->db));
			if ($updateUserData && $updatePayoutStatus) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/*Delete Post*/
	public function iN_DeletePayoutRequest($userID, $ID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_user_payouts WHERE payout_id = '$ID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert Activate Code*/
	public function iN_InsertNewForgotPasswordCode($userEmail, $code) {
		$query = mysqli_query($this->db, "UPDATE i_users SET forgot_pass_code = '$code' WHERE i_user_email = '$userEmail'") or die(mysqli_error($this->db));
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	/*Check Code Exist*/
	public function iN_CheckCodeExist($activationCode) {
		$query = mysqli_query($this->db, "SELECT * FROM i_users WHERE forgot_pass_code = '$activationCode'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == '1') {
			return true;
		} else {
			return false;
		}
	}
	public function iN_CheckVerCodeExist($activationCode) {
		$query = mysqli_query($this->db, "SELECT * FROM i_users WHERE verify_key = '$activationCode'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == '1') {
			return true;
		} else {
			return false;
		}
	}
	public function iN_InsertNewVerificationCode($userID, $code){
		$query = mysqli_query($this->db, "UPDATE i_users SET verify_key = '$code' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	/*Update Password*/
	public function iN_ResetPassword($code, $newPassword) {
		$code = mysqli_real_escape_string($this->db, $code);
		$newPassword = mysqli_real_escape_string($this->db, $newPassword);
		$query = mysqli_query($this->db, "UPDATE i_users SET i_password = '$newPassword' WHERE forgot_pass_code = '$code' AND uStatus IN('1','3')") or die(mysqli_error($this->db));
		if ($query) {
			$query = mysqli_query($this->db, "UPDATE i_users SET forgot_pass_code = NULL WHERE forgot_pass_code = '$code'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert New Advertisement*/
	public function iN_InsertNewAdvertisement($userID, $adsImage, $adsTitle, $adsDescription, $adsRedirectURL) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_advertisements(ads_title,ads_desc,ads_url,ads_image)VALUES('$adsTitle','$adsDescription','$adsRedirectURL','$adsImage')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Advertisements List (Admin)*/
	public function iN_AdvertisementsListAdmin($userID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_advertisements ORDER BY ads_id ") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Check Premium Plan Exist*/
	public function CheckAdsExist($adsID) {
		$adsID = mysqli_real_escape_string($this->db, $adsID);
		$query = mysqli_query($this->db, "SELECT ads_id FROM i_advertisements WHERE ads_id = '$adsID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Update Ads Status*/
	public function iN_UpdateAdsStatus($userID, $mod, $adsID) {
		$adsID = mysqli_real_escape_string($this->db, $adsID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckAdsExist($adsID)) {
			mysqli_query($this->db, "UPDATE i_advertisements SET ads_status = '$mod' WHERE ads_id = '$adsID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get Ads Details*/
	public function iN_GetAdsDetailsAdmin($userID, $adsID) {
		$adsID = mysqli_real_escape_string($this->db, $adsID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckAdsExist($adsID)) {
			$query = mysqli_query($this->db, "SELECT * FROM i_advertisements WHERE ads_id = '$adsID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Insert New Advertisement*/
	public function iN_UpdateAdvertisement($userID, $adsID, $adsImage, $adsTitle, $adsDescription, $adsRedirectURL) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "UPDATE i_advertisements SET ads_image = '$adsImage', ads_title = '$adsTitle', ads_desc = '$adsDescription', ads_url = '$adsRedirectURL' , ads_status = '0' WHERE ads_id = '$adsID'") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Delete Ads*/
	public function iN_DeleteAdsFromData($userID, $adsID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckAdsExist($adsID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_advertisements WHERE ads_id = '$adsID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Show Advertisements If Exist*/
	public function iN_ShowAds() {
		$query = mysqli_query($this->db, "SELECT * FROM i_advertisements WHERE ads_status = '1' ORDER BY RAND() LIMIT 2") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	public function xss_clean($data) {
		// Fix &entity\n;
		$data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		do {
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		} while ($old_data !== $data);

		return $data;
	}
	/*Get Not Rejected or declined  the post*/
	public function iN_GetAdminNot($userID, $postID) {
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_approve_post_notification WHERE approve_status IN('2','3') AND approved_post_id = '$postID' AND approved_post_owner_id = '$userID' ORDER BY approve_id DESC LIMIT 1") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Payments history List*/
	public function iN_YourPaymentsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			P.payment_id,P.payer_iuid_fk, P.payed_iuid_fk, P.payed_post_id_fk, P.payed_profile_id_fk, P.order_key, P.payment_type, P.payment_option, P.payment_time, P.payment_status, P.amount, P.fee, P.admin_earning, P.user_earning, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payments P FORCE INDEX(ixPayment)
		    ON P.payer_iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.payment_status = 'ok' AND P.payer_iuid_fk = '$userID' AND P.payment_type IN('post','live_stream','tips','live_gift') ORDER BY P.payment_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*User Total Point Payments*/
	public function iN_UserTotalPointPayments($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countTotalPointPayments = mysqli_query($this->db, "SELECT COUNT(*) AS totalPointPayments FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payment_type = 'post'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countTotalPointPayments, MYSQLI_ASSOC);
			return isset($row['totalPointPayments']) ? $row['totalPointPayments'] : '0';
		}
	}
	/*Check Invoice ID Exist*/
	public function iN_CheckInvoiceIDExist($invoiceID, $userID) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_payments WHERE payment_id = '$invoiceID' AND payer_iuid_fk = '$userID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($query) == 1) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Get Invoice Details*/
	public function iN_GetInvoiceDetails($invoiceID, $userID) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_payments WHERE payment_id = '$invoiceID' AND payer_iuid_fk = '$userID'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $row;
		} else {
			return false;
		}
	}
	/*Update Subscription Stripe Status*/
	public function iN_UpdateStripeSubStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET stripe_status = '$mode' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Subscription Stripe Details*/
	public function iN_UpdateSubStripeDetails($userID, $stSubSecretKey, $stSubPublicKey, $stSubCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET stripe_secret_key = '$stSubSecretKey', stripe_public_key = '$stSubPublicKey', stripe_currency = '$stSubCurrency' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Giphy Api Key*/
	public function iN_UpdateGiphyAPIKey($userID, $giphyKey) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET giphy_api_key = '$giphyKey' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check Last Finish Time*/
	public function iN_GetLiveStreamingDetails($userID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_live WHERE live_uid_fk = '$userID' ORDER BY live_id DESC LIMIT 1") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $row;
		} else {
			return false;
		}
	}
	/*Check Last Finish Time*/
	public function iN_GetLiveStreamingDetailsByID($liveID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_live WHERE live_id = '$liveID' ORDER BY live_id DESC LIMIT 1") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $row;
		} else {
			return false;
		}
	}
	/*Check Last Finish Time*/
	public function iN_GetLastLiveFinishTime($userID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_live WHERE live_uid_fk = '$userID' ORDER BY live_id DESC LIMIT 1") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($row['finish_time']) ? $row['finish_time'] : FALSE;
		} else {
			return false;
		}
	}
	/*Create a Free Live Streaming*/
	public function iN_CreateAFreeLiveStreaming($userID, $liveStreamingTitle, $freeLiveTime, $channelName) {
		$currentTime = time();
		$finishTime = $currentTime + 60 * $freeLiveTime;
		$l_Time = $this->iN_GetLastLiveFinishTime($userID);
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($l_Time) {
			if ($currentTime > $l_Time) {
				$query = mysqli_query($this->db, "INSERT INTO i_live(live_name,started_at,finish_time,live_uid_fk,live_type,live_channel)VALUES('$liveStreamingTitle','$currentTime','$finishTime','$userID','free', '$channelName')") or die(mysqli_error($this->db));
				if ($query) {
					return true;
				} else {
					return false;
				}
			} else {
				/*Redirect user from live streaming page*/
				echo '2';
			}
		} else {
			$query = mysqli_query($this->db, "INSERT INTO i_live(live_name,started_at,finish_time,live_uid_fk,live_type,live_channel)VALUES('$liveStreamingTitle','$currentTime','$finishTime','$userID','free', '$channelName')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Create a Free Live Streaming*/
	public function iN_CreateAPaidLiveStreaming($userID, $liveStreamingTitle, $freeLiveTime, $channelName, $streamFee) {
		$currentTime = time();
		$finishTime = $currentTime + 60 * $freeLiveTime;
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_live(live_name,started_at,finish_time,live_uid_fk,live_type,live_channel,live_credit)VALUES('$liveStreamingTitle','$currentTime','$finishTime','$userID','paid', '$channelName','$streamFee')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function iN_StartCloudRecording($vendor, $region, $bucket, $accessKey, $secretKey, $cname, $uid, $post_id, $agoraAppID, $agoraCustomerID, $agoraCertificate) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.agora.io/v1/apps/" . $agoraAppID . "/cloud_recording/acquire");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($agoraCustomerID . ":" . $agoraCertificate), 'Content-Type: application/json;charset=utf-8'));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{
		    "cname": "' . $cname . '",
		    "uid": "' . $uid . '",
		    "clientRequest":{
		    }
		}');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response);
		$resourceId = $data->resourceId;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.agora.io/v1/apps/" . $agoraAppID . "/cloud_recording/resourceid/" . $resourceId . "/mode/mix/start");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($agoraCustomerID . ":" . $agoraCertificate), 'Content-Type: application/json;charset=utf-8'));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{
		    "cname":"' . $cname . '",
		    "uid":"' . $uid . '",
		    "clientRequest":{
		        "recordingConfig":{
		            "channelType":1,
		            "streamTypes":2,
		            "audioProfile":1,
		            "videoStreamType":1,
		            "maxIdleTime":120,
		            "transcodingConfig":{
		                "width":480,
		                "height":720,
		                "fps":24,
		                "bitrate":800,
		                "maxResolutionUid":"1",
		                "mixedVideoLayout":1
		                }
		            },
		        "storageConfig":{
		            "vendor":' . $vendor . ',
		            "region":' . $region . ',
		            "bucket":"' . $bucket . '",
		            "accessKey":"' . $accessKey . '",
		            "secretKey":"' . $secretKey . '",
		            "fileNamePrefix": [
		                "upload",
		                "videos",
		                "' . date('Y') . '",
		                "' . date('m') . '"
		              ]
		        }
		    }
		} ');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response);
		if (!empty($data->sid) && !empty($resourceId)) {
			mysqli_query($this->db, "UPDATE i_live SET a_resource_id = '" . $resourceId . "', a_sid = '" . $data->sid . "' WHERE live_id = '$post_id'") or die(mysqli_error($this->db));
		}
		return true;
	}
	/*Check Live EXISTs*/
	public function iN_CheckLiveIDExist($liveID) {
		$checkPostisExist = mysqli_query($this->db, "SELECT live_id FROM i_live WHERE live_id = '$liveID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Check User Liked The Post Before*/
	public function iN_CheckLiveLikedBefore($userID, $liveID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$liveID = mysqli_real_escape_string($this->db, $liveID);
		$checkLiveLikedBefore = mysqli_query($this->db, "SELECT live_id_fk FROM i_live_likes WHERE live_id_fk = '$liveID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkLiveLikedBefore) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Comment Like Count*/
	public function iN_TotalLiveLiked($liveID) {
		$liveID = mysqli_real_escape_string($this->db, $liveID);
		$CountLiveLike = mysqli_query($this->db, "SELECT COUNT(*) AS LiveLikeCount FROM i_live_likes WHERE live_id_fk = '$liveID'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($CountLiveLike, MYSQLI_ASSOC);
		return $row['LiveLikeCount'];
	}
	/*Like Post*/
	public function iN_LiveLike($userID, $liveID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$liveID = mysqli_real_escape_string($this->db, $liveID);
		$time = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckLiveIDExist($liveID) == 1) {
			if ($this->iN_CheckLiveLikedBefore($userID, $liveID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_live_likes WHERE live_id_fk = '$liveID' AND iuid_fk = '$userID'");
				return false;
			} else {
				mysqli_query($this->db, "INSERT INTO i_live_likes (live_id_fk,iuid_fk,like_time,user_ip) VALUES('$liveID','$userID','$time','$userIP')") or die(mysqli_error($this->db));
				return true;
			}
		}
	}
	/*Get Live Video Online users*/
	public function iN_OnlineLiveVideoUserCount($userID, $liveID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$liveID = mysqli_real_escape_string($this->db, $liveID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckLiveIDExist($liveID) == 1) {
			$time = time();
			mysqli_query($this->db, "UPDATE i_live_video_users SET live_time = '$time' WHERE  live_video_id = '$liveID' AND live_user_uid_fk = '$userID'") or die(mysqli_error($this->db));
		}
		$query = mysqli_query($this->db, "SELECT COUNT(*) AS countLiveVideoUsers FROM i_live_video_users WHERE live_video_id = '$liveID' AND FROM_UNIXTIME(live_time) > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 minute)") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		if ($row) {
			return $row['countLiveVideoUsers'];
		} else {return 0;}
	}
	/*Check Last Finish Time*/
	public function iN_GetLastLiveFinishTimeFromID($liveID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_live WHERE live_id = '$liveID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($row['finish_time']) ? $row['finish_time'] : FALSE;
		} else {
			return false;
		}
	}
	public function iN_InsertMyOnlineStatus($userID, $liveID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$liveID = mysqli_real_escape_string($this->db, $liveID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckLiveIDExist($liveID) == 1) {
			$time = time();
			$checkUserExistInLive = mysqli_query($this->db, "SELECT live_user_uid_fk,live_video_id FROM i_live_video_users WHERE live_video_id = '$liveID' AND live_user_uid_fk = '$userID'") or die(mysqli_error($this->db));
			if (mysqli_num_rows($checkUserExistInLive) == 1) {
				mysqli_query($this->db, "UPDATE i_live_video_users SET live_time = '$time' WHERE  live_video_id = '$liveID' AND live_user_uid_fk = '$userID'") or die(mysqli_error($this->db));
			} else {
				mysqli_query($this->db, "INSERT INTO `i_live_video_users`(live_user_uid_fk,live_time,live_video_id)VALUES('$userID','$time','$liveID')") or die(mysqli_error($this->db));
			}
		}
	}
	public function iN_CheckUserPurchasedThisLiveStream($userID, $purchaseLiveStreamID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$purchaseLiveStreamID = mysqli_real_escape_string($this->db, $purchaseLiveStreamID);
		$query = mysqli_query($this->db, "SELECT payer_iuid_fk, payed_live_stream_id_fk FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payed_live_stream_id_fk = '$purchaseLiveStreamID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Buy Post*/
	public function iN_BuyLiveStreaming($userID, $userLiveStreamOwnerID, $purchasdLiveStreamID, $amount, $adminEarning, $userEarning, $fee, $credit) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$userLiveStreamOwnerID = mysqli_real_escape_string($this->db, $userLiveStreamOwnerID);
		$purchasdLiveStreamID = mysqli_real_escape_string($this->db, $purchasdLiveStreamID);
		if ($this->iN_CheckUserExist($userID) == '1' && $this->iN_CheckUserExist($userLiveStreamOwnerID) == '1' && $this->iN_CheckLiveIDExist($purchasdLiveStreamID) == '1') {
			$time = time();
			$query = mysqli_query($this->db, "INSERT INTO i_user_payments(payer_iuid_fk, payed_iuid_fk, payed_live_stream_id_fk,payment_type,payment_time,payment_status, amount, fee, admin_earning, user_earning)VALUES('$userID','$userLiveStreamOwnerID', '$purchasdLiveStreamID', 'live_stream', '$time', 'ok', '$amount', '$fee', '$adminEarning', '$userEarning')") or die(mysqli_error($this->db));
			if ($query) {
				mysqli_query($this->db, "UPDATE i_users SET wallet_points = wallet_points - $credit WHERE iuid = '$userID'") or die(mysqli_error($this->db));
				mysqli_query($this->db, "UPDATE i_users SET wallet_money = (wallet_money + $userEarning) WHERE iuid = '$userLiveStreamOwnerID'") or die(mysqli_error($this->db));
				return true;
			}
		} else {
			return false;
		}
	}
	/*Free Live Streamings List*/
	public function iN_LiveStreaminsList($liveStyle, $lastPostID, $showingPost) {
		$liveStyle = mysqli_real_escape_string($this->db, $liveStyle);
		$tree_minutes_ago = time() - (10 * 1);
		$datetime = date("Y-m-d H:i:s", $tree_minutes_ago);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " AND L.live_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getLives = mysqli_query($this->db, "SELECT DISTINCT
		L.live_id, L.live_name, L.live_uid_fk,L.finish_time, L.live_credit, U.iuid, U.i_username, U.i_user_fullname
		FROM i_live L FORCE INDEX(ix_Live)
		INNER JOIN i_users U FORCE INDEX(ixForceUser) ON L.live_uid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE L.live_type = '$liveStyle' AND L.finish_time >= '$tree_minutes_ago' $morePost ORDER BY L.live_id DESC LIMIT $showingPost") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getLives, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Update Live Streaming time*/
	public function iN_UpdateLiveStreamingTime($liveID) {
		$time = time();
		mysqli_query($this->db, "UPDATE i_live SET finish_time = '$time' WHERE live_id = '$liveID'") or die(mysqli_error($this->db));
	}
	/*Update Email Settings*/
	public function iN_UpdateAgoraLiveStreamingSettings($userID,$freeLiveStreamingStatus,$paidLiveStreamingStatus, $liveStatus, $freeLiveLimit, $agora_AppID, $agora_Certificate, $agora_CustomerID, $liveMinimumFee) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET free_live_streaming_status = '$freeLiveStreamingStatus', paid_live_streaming_status = '$paidLiveStreamingStatus' , agora_status = '$liveStatus', agora_app_id = '$agora_AppID', agora_certificate = '$agora_Certificate', agora_customer_id = '$agora_CustomerID', free_live_time = '$freeLiveLimit' , minimum_live_streaming_fee = '$liveMinimumFee' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Hashtags*/
	public function iN_GetHashTagsSearch($hashTag, $lastPostID, $showingPosts) {
		$hashTag = mysqli_real_escape_string($this->db, strip_tags(trim($hashTag)));
		// Now if it has commas, you have to explode() it to an array
		$hashtags_list = explode(',', $hashTag);
		// A variable to hold all the hashtag LIKE conditions
		$hashtag_query = array();
		foreach ($hashtags_list as $ht) {
			// Each tag has to be checked with LIKE alone
			$hashtag_query[] = "FIND_IN_SET(LOWER('$ht'), LOWER(hashtags))";
		}
		// Make them into AND conditions
		$hashtag_query = implode(' AND ', $hashtag_query);
		$morequery = '';
		if ($lastPostID) {
			//build up the query
			$morequery = " AND P.post_id < '" . $lastPostID . "' ";
		}
		mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
		$getData = mysqli_query($this->db, "SELECT DISTINCT P.post_id,P.shared_post_id,P.post_pined,P.comment_status,P.post_owner_id,P.post_text,P.post_file,P.post_created_time,P.who_can_see,P.post_want_status,P.url_slug,P.post_wanted_credit,P.post_status,P.hashtags,U.iuid,U.i_username,U.payout_method, U.thanks_for_tip, U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')
		WHERE ($hashtag_query) $morequery ORDER BY P.post_id DESC LIMIT $showingPosts") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getData, MYSQLI_ASSOC)) {
			// Store the result into array
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	public function iN_CaltulateHashFromDatabase($hashTag = "") {
		$hashTag = mysqli_real_escape_string($this->db, strip_tags(trim($hashTag)));
		// Now if it has commas, you have to explode() it to an array
		$hashtags_list = explode(',', $hashTag);
		// A variable to hold all the hashtag LIKE conditions
		$hashtag_query = array();
		foreach ($hashtags_list as $ht) {
			// Each tag has to be checked with LIKE alone
			$hashtag_query[] = "FIND_IN_SET(LOWER('$ht'), LOWER(hashtags))";
		}
		// Make them into AND conditions
		mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
		$hashtag_query = implode($hashtag_query);
		$Calculate = mysqli_query($this->db, "SELECT COUNT(*) AS totalHashTag FROM i_posts WHERE ($hashtag_query)") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($Calculate, MYSQLI_ASSOC);
		return isset($row['totalHashTag']) ? $row['totalHashTag'] : FALSE;
	}
	/*List Question Answer From Landing Page*/
	public function iN_ListQuestionAnswerFromLanding() {
		$query = mysqli_query($this->db, "SELECT * FROM i_landing_qa WHERE qa_status = '1'") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			// Store the result into array
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Popular User From Last Week*/
	public function iN_PopularUsersFromLastWeekInExplorePageLanding() {
		$query = mysqli_query($this->db, "SELECT DISTINCT
		P.post_owner_id,P.post_owner_id, U.iuid,U.i_username,U.i_user_fullname,U.user_verified_status, U.user_gender , count(P.post_owner_id) as cnt
		FROM i_posts P FORCE INDEX(ixForcePostOwner)
		INNER JOIN i_users U FORCE INDEX(ixForceUser)
		ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3')
		WHERE WEEK(FROM_UNIXTIME(P.post_created_time)) = WEEK(NOW()) - 1 GROUP BY P.post_owner_id ORDER BY cnt DESC LIMIT 3
		") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Update Theme*/
	public function iN_UpdateTheme($userID, $theme) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_page_type = '$theme' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update First Landing Page Image*/
	public function iN_UpdateFirstLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_first_image = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Second Landing Page Image*/
	public function iN_UpdateSecondLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_first_image_arrow = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Third Landing Page Image*/
	public function iN_UpdateThirdLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_feature_image_one = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateFourthLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_feature_image_two = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateFifthLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_feature_image_three = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateSixthLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_feature_image_four = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateSeventhLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_feature_image_five = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateBgLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_section_two_bg = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateFrntLandingPageImage($userID, $landingImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET landing_section_feature_image = '$landingImage' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Insert New Question Answer*/
	public function iN_InsertNewQuestionAnswer($userID, $newQusetionAnswer, $newQusetion) {
		// Make them into AND conditions
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db, "INSERT INTO i_landing_qa(qa_title, qa_description,qa_status)VALUES('$newQusetion','$newQusetionAnswer', '1')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Delete Post*/
	public function iN_DeleteQA($userID, $QAID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckQAExistByID($QAID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_landing_qa WHERE qa_id = '$QAID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get QA Details From ID*/
	public function iN_GetQADetailsFromID($sID) {
		$sID = mysqli_real_escape_string($this->db, $sID);
		$query = mysqli_query($this->db, "SELECT * FROM i_landing_qa WHERE qa_id = '$sID'") or die(mysqli_error($this->db));
		$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		/*Return result if icon id exist or not*/
		return $data;
	}
	/*Update Fourth Landing Page Image*/
	public function iN_UpdateLandingQA($userID, $newQusetionAnswer, $newQusetion, $QAID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_landing_qa SET qa_title = '$newQusetion', qa_description = '$newQusetionAnswer' WHERE qa_id = '$QAID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check Live EXISTs*/
	public function iN_CheckLiveIDExistAndOwner($userID, $liveID) {
		$checkPostisExist = mysqli_query($this->db, "SELECT * FROM i_live WHERE live_id = '$liveID' AND live_uid_fk = '$userID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Finish Live Streaming*/
	public function iN_FinishLiveStreaming($userID, $liveID) {
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckLiveIDExistAndOwner($userID, $liveID) == 1) {
		    mysqli_query($this->db, "DELETE FROM i_live WHERE live_id = '$liveID' AND live_uid_fk = '$userID'");
			return true;
		}else{
			return false;
		}
	}
	/*Update Subscription Stripe Details*/
	public function iN_UpdateSubCCBILLDetails($userID, $accountNumber, $subAccountNumber, $flexFormID, $saltKey, $ccbillCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET ccbill_account_number = '$accountNumber', ccbill_subaccount_number = '$subAccountNumber', ccbill_flex_form_id = '$flexFormID' , ccbill_salt_key = '$saltKey', ccbill_currency = '$ccbillCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Payments Withdrawal AND Subscription Payments List*/
	public function iN_GetUWithdrawalDetails($userID, $withdrawID , $type) {
		$userID = mysqli_real_escape_string($this->db, $userID); 
		$withdrawID = mysqli_real_escape_string($this->db, $withdrawID); 
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			P.payout_id, P.iuid_fk, P.amount, P.method,P.paid_time, P.payout_time, P.status,P.payment_type, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payouts P FORCE INDEX(ix_PayoutUser)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.payment_type = '$type' AND P.payout_id = '$withdrawID'
			") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		}
	}
	/*Update DigitalOcean Settings*/
	public function iN_UpdateDigitalOceanDetails($userID, $dOceanRegion, $dOgeanBucket, $dOceanKey, $dOceanSecretKey,  $dOceanStatus) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET s3_status = '0' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_configurations SET ocean_region = '$dOceanRegion', ocean_space_name = '$dOgeanBucket' , ocean_key = '$dOceanKey' , ocean_secret = '$dOceanSecretKey' , ocean_status = '$dOceanStatus' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	} 

	/*Update FFMPEG Mod*/
	public function iN_UpdateFFMPEGSendStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET ffmpeg_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Post Create Mod*/
	public function iN_UpdatePostCretaeStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET normal_user_can_post = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update UPLOADED FILES FROM UPLOADS TABLE*/
	public function iN_UpdateUploadedFiles($userID, $tumbnailPath, $pathFileID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$tumbnailPath = mysqli_real_escape_string($this->db, $tumbnailPath);  
		$updateTumb = mysqli_query($this->db,"UPDATE i_user_uploads SET upload_tumbnail_file_path = '$tumbnailPath', uploaded_x_file_path = '$tumbnailPath' WHERE iuid_fk = '$userID' AND upload_id = '$pathFileID'") or die(mysqli_error($this->db));
		if($updateTumb){
           return true;
		}else{
			return false;
		} 
	}
	/*Remove Youtubelink from Post Text*/
	public function iN_RemoveYoutubelink($postText){
		if($postText){ 
			$remove = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","",$postText);
		}else{
			$remove = $postText;
		}
		return $remove;		
	}
	/*Suggestion Creators*/ 
    public function iN_SuggestionCreatorsList($uid) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$query = mysqli_query($this->db, "SELECT * FROM i_users WHERE uStatus IN('3') AND iuid NOT IN (SELECT fr_two FROM i_friends WHERE fr_one = '$uid' OR fr_two = '$uid') AND certification_status = '2' AND validation_status = '2' AND condition_status = '2' AND fees_status = '2' AND payout_status = '2' ORDER BY rand() LIMIT 5") or die(mysqli_error($this->db));
		$data = array();
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			// Store the result into array
			return $data;
		}
	} 
	/*Suggestion Creators*/ 
    public function iN_SuggestionCreatorsListOut() { 
		$query = mysqli_query($this->db, "SELECT * FROM i_users WHERE uStatus IN('3') ORDER BY rand() LIMIT 5") or die(mysqli_error($this->db));
		$data = array();
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			// Store the result into array
			return $data;
		}
	}
	/*Check Country is Blocked*/
	public function iN_CheckCountryBlocked($userID, $value){
       $userID = mysqli_real_escape_string($this->db, $userID);
	   $value = mysqli_real_escape_string($this->db, $value);
	   if($this->iN_CheckUserExist($userID) == 1){
          $queryCheck  = mysqli_query($this->db,"SELECT * FROM i_user_blocked_countries WHERE b_iuid_fk = '$userID' AND b_country = '$value'") or die(mysqli_error($this->db));
		  if(mysqli_num_rows($queryCheck) == 1){
            return true;
		  }else{
			return false;
		  }
	   }else{
		   return false;
	   }
	}
	/*Insert Country Code in Block List*/
	public function iN_InsertCountryInBlockList($userID, $blockingCountryCode) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$blockingCountryCode = mysqli_real_escape_string($this->db, $blockingCountryCode);
		$time = time();
		if($this->iN_CheckUserExist($userID) == 1){
			$query = mysqli_query($this->db, "INSERT INTO i_user_blocked_countries(b_iuid_fk, b_country,b_time)VALUES('$userID','$blockingCountryCode', '$time')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		}else{
			return false;
		}
	}
	/*Insert Country Code in Block List*/
	public function iN_RemoveCountryInBlockList($userID, $blockingCountryCode) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$blockingCountryCode = mysqli_real_escape_string($this->db, $blockingCountryCode); 
		if($this->iN_CheckUserExist($userID) == 1){
			$query = mysqli_query($this->db, "DELETE FROM i_user_blocked_countries WHERE b_iuid_fk = '$userID' AND b_country = '$blockingCountryCode'");
			if($query){
              return true;
			}
		}else{
			return false;
		}
	}
	/*Following List*/
	public function iN_FollowingUsersListPage($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			F.fr_one,F.fr_two,F.fr_status, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_friends F FORCE INDEX(ixFriend)
		    ON F.fr_one = U.iuid AND U.uStatus IN('1','3')
			WHERE F.fr_one = '$userID' AND F.fr_status = 'flwr' ORDER BY F.fr_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*User Total Following User*/
	public function iN_UserTotalFollowingUsers($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalFollowingUser FROM i_friends WHERE fr_one = '$userID' AND fr_status = 'flwr'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalFollowingUser']) ? $row['totalFollowingUser'] : '0';
		}
	}
	/*Following List*/
	public function iN_FollowerUsersListPage($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			F.fr_one,F.fr_two,F.fr_status, U.iuid, U.i_username, U.i_user_fullname
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_friends F FORCE INDEX(ixFriend)
		    ON F.fr_two = U.iuid AND U.uStatus IN('1','3')
			WHERE F.fr_two = '$userID' AND F.fr_status = 'flwr' ORDER BY F.fr_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*User Total Following User*/
	public function iN_UserTotalFollowerUsers($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalFollowingUser FROM i_friends WHERE fr_two = '$userID' AND fr_status = 'flwr'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalFollowingUser']) ? $row['totalFollowingUser'] : '0';
		}
	}
	/*All Posts*/
	public function iN_AllTypeQuestionsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_contacts
			WHERE contact_read_status IN('0','1') ORDER BY contact_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*All Reported Posts*/
	public function iN_AllTypeReportedPostList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_post_reports
			WHERE report_status IN('0','1') ORDER BY p_report_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*All Reported Comments*/
	public function iN_AllTypeReportedCommentList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_comment_reports
			WHERE report_status IN('0','1') ORDER BY p_report_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Check post EXISTs*/
	public function iN_CheckQuestionIDExist($qID) {
		$checkQuestionisExist = mysqli_query($this->db, "SELECT contact_id FROM i_contacts WHERE contact_id = '$qID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkQuestionisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Check post EXISTs*/
	public function iN_CheckReportIDExist($qID) {
		$checkReportisExist = mysqli_query($this->db, "SELECT p_report_id FROM i_post_reports WHERE p_report_id = '$qID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkReportisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Delete question*/
	public function iN_DeleteQuestion($userID, $postID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckQuestionIDExist($postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_contacts WHERE contact_id = '$postID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get Question Details*/ 
	public function iN_GetUQuestionDetails($userID, $quID) {
		$userID = mysqli_real_escape_string($this->db, $userID); 
		$quID = mysqli_real_escape_string($this->db, $quID); 
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckQuestionIDExist($quID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_contacts WHERE contact_id = '$quID' ") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		}
	}
	/*Update Question Answer Status*/
	public function iN_UpdateQuestionAnswerStatus($userID, $mod, $questionID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckQuestionIDExist($questionID) == 1) {
			mysqli_query($this->db, "UPDATE i_contacts SET contact_read_status = '$mod' WHERE contact_id = '$questionID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Report*/
	public function iN_DeleteReport($userID, $postID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckReportIDExist($postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_post_reports WHERE p_report_id = '$postID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	} 
	/*Update Reported Post Checked Status*/
	public function iN_UpdateReportedPostCheckedStatus($userID, $mod, $rID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckReportIDExist($rID) == 1) {
			mysqli_query($this->db, "UPDATE i_post_reports SET report_status = '$mod' WHERE p_report_id = '$rID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get Total Unreaded notifications */
	public function iN_GetTotalReportedPost($uid) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		if ($this->iN_CheckIsAdmin($uid) == 1) {
			$CountNotification = mysqli_query($this->db, "SELECT COUNT(*) AS unCheckedReports FROM i_post_reports WHERE report_status='0'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($CountNotification, MYSQLI_ASSOC);
			return $row['unCheckedReports'];
		} else {
			return false;
		}
	}
	/*Update Reported Post Checked Status*/
	public function iN_UpdateReportedCommentCheckedStatus($userID, $mod, $rID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_comment_reports SET report_status = '$mod' WHERE p_report_id = '$rID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get Total Unreaded notifications */
	public function iN_GetTotalReportedComment($uid) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		if ($this->iN_CheckIsAdmin($uid) == 1) {
			$CountNotification = mysqli_query($this->db, "SELECT COUNT(*) AS unCheckedReports FROM i_comment_reports WHERE report_status='0'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($CountNotification, MYSQLI_ASSOC);
			return $row['unCheckedReports'];
		} else {
			return false;
		}
	}
	/*Check post EXISTs*/
	public function iN_CheckReportCommentIDExist($qID) {
		$checkReportisExist = mysqli_query($this->db, "SELECT p_report_id FROM i_comment_reports WHERE p_report_id = '$qID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkReportisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Delete Comment Report*/
	public function iN_DeleteCommentReport($userID, $postID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckReportCommentIDExist($postID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_comment_reports WHERE p_report_id = '$postID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	} 
	/*Update Post Create Mod*/
	public function iN_UpdateBlockCountriesStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET user_can_block_country = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Autp approve post Status*/
	public function iN_UpdateAutoApprovePostStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET auto_approve_post = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*User Total Point Purchased*/
	public function iN_UserTotalPointPurchase($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countTotalPointPurchases = mysqli_query($this->db, "SELECT COUNT(*) AS totalPointPurchase FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payment_type = 'point' AND credit_plan_id IS NOT NULL") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countTotalPointPurchases, MYSQLI_ASSOC);
			return isset($row['totalPointPurchase']) ? $row['totalPointPurchase'] : '0';
		}
	}
	/*Payments Point History List*/
	public function iN_YourPointPaymentsHistoryList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db,"SELECT DISTINCT P.payment_id, P.payer_iuid_fk,P.order_key, P.payment_type, P.payment_option, P.payment_time, P.payment_status, P.credit_plan_id
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_payments P FORCE INDEX(ixPayment)
			ON P.payer_iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.payer_iuid_fk = '$userID' AND P.payment_type = 'point' AND P.credit_plan_id IS NOT NULL") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*All Live Streamings List Widget*/
	public function iN_LiveStreamingListWidget($showingPost){
		$tree_minutes_ago = time() - (10 * 1);
		$datetime = date("Y-m-d H:i:s", $tree_minutes_ago);
		$getLives = mysqli_query($this->db, "SELECT DISTINCT
		L.live_id, L.live_name, L.live_uid_fk,L.finish_time, L.live_credit, L.live_type, U.iuid, U.i_username, U.i_user_fullname
		FROM i_live L FORCE INDEX(ix_Live)
		INNER JOIN i_users U FORCE INDEX(ixForceUser) ON L.live_uid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE L.finish_time >= '$tree_minutes_ago' ORDER BY L.live_id DESC LIMIT $showingPost") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getLives, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*All Live Streamings List*/
	public function iN_LiveStreaminsListAllType($lastPostID, $showingPost) { 
		$tree_minutes_ago = time() - (10 * 1);
		$datetime = date("Y-m-d H:i:s", $tree_minutes_ago);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " AND L.live_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getLives = mysqli_query($this->db, "SELECT DISTINCT
		L.live_id, L.live_name, L.live_uid_fk,L.finish_time, L.live_credit, L.live_type, U.iuid, U.i_username, U.i_user_fullname
		FROM i_live L FORCE INDEX(ix_Live)
		INNER JOIN i_users U FORCE INDEX(ixForceUser) ON L.live_uid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE L.finish_time >= '$tree_minutes_ago' $morePost ORDER BY L.live_id DESC LIMIT $showingPost") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getLives, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		} 
	}
	/*Insert User Subscription Using Point*/
	public function iN_InsertUserSubscriptionWithPoint($userID, $subscribedUserID, $planType, $subscriberName, $planAmount, $adminEarning, $userNetEarning, $planCurrency, $planinterval, $planIntervalCount, $subscriberEmail, $plancreated, $current_period_start, $current_period_end, $planStatus,$UpdateCurrentPoint) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$subscribedUserID = mysqli_real_escape_string($this->db, $subscribedUserID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($subscribedUserID) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_user_subscriptions(iuid_fk, subscribed_iuid_fk, subscriber_name, payment_method, plan_amount,admin_earning,user_net_earning, plan_amount_currency, plan_interval, plan_interval_count, payer_email, created, plan_period_start, plan_period_end,status)VALUES('$userID', '$subscribedUserID','$subscriberName', '$planType', '$planAmount','$adminEarning','$userNetEarning', '$planCurrency', '$planinterval', '$planIntervalCount', '$subscriberEmail', '$plancreated', '$current_period_start', '$current_period_end', '$planStatus')") or die(mysqli_error($this->db));
			if ($query) {
				$time = time();
				$GetStatus = mysqli_query($this->db, "SELECT fr_one, fr_two, fr_status FROM i_friends WHERE fr_one='$userID' AND fr_two='$subscribedUserID' AND (fr_status = 'flwr' OR fr_status = 'subscriber')") or die(mysqli_error($this->db));
				if (mysqli_num_rows($GetStatus) == 1) {
					mysqli_query($this->db, "UPDATE i_friends SET fr_status = 'subscriber', fr_time = '$time' WHERE fr_one='$userID' AND fr_two='$subscribedUserID'") or die(mysqli_error($this->db));
					mysqli_query($this->db, "UPDATE i_users SET wallet_points = '$UpdateCurrentPoint' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
				} else {
					mysqli_query($this->db, "INSERT INTO i_friends(fr_one, fr_two, fr_status,fr_time)VALUES('$userID','$subscribedUserID','subscriber','$time')") or die(mysqli_error($this->db));
					mysqli_query($this->db, "UPDATE i_users SET wallet_points = '$UpdateCurrentPoint' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
				}
				return true;
			} else {
				return false;
			}
		}
	}
	/*Update Users Wallets*/
	public function iN_UpdateUsersWallets($userID, $tiSendingUserID, $tipAmount, $netUserEarning,$adminFee,$adminEarning,$userNetEarning){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$tiSendingUserID = mysqli_real_escape_string($this->db, $tiSendingUserID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckUserExist($tiSendingUserID) == 1) { 
			mysqli_query($this->db, "UPDATE i_users SET wallet_points = wallet_points - '$tipAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET wallet_money = wallet_money + '$userNetEarning' WHERE iuid = '$tiSendingUserID'") or die(mysqli_error($this->db));$time = time();
            mysqli_query($this->db, "INSERT INTO i_user_payments(payer_iuid_fk, payed_iuid_fk,payment_type,payment_time,payment_status, amount, user_earning,admin_earning,fee)
			VALUES('$userID','$tiSendingUserID', 'tips', '$time', 'ok', '$netUserEarning', '$userNetEarning','$adminEarning','$adminFee')") or die(mysqli_error($this->db));
			return true;
		}
	} 
	/*Update CoinPayment Status*/
	public function iN_UpdateCoinPaymentStatus($userID, $mode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET coinpayments_status = '$mode' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Stripe Details*/
	public function iN_UpdateCoinPaymentDetails($userID, $cpPrivateKey, $cpPublicKey, $cpMerchandID, $cpIPNSecret, $cpDebugEmail, $cpCurrency) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_payment_methods SET coinpayments_private_key = '$cpPrivateKey', coinpayments_public_key = '$cpPublicKey', coinpayments_merchand_id ='$cpMerchandID', coinpayments_ipn_secret = '$cpIPNSecret', coinpayments_debug_email = '$cpDebugEmail', cp_cryptocurrencies = '$cpCurrency' WHERE payment_method_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*All Live Streamings List*/
	public function iN_LiveStreaminsListAllTypeSuggested($lastPostID,$userID, $showingPost) { 
		$tree_minutes_ago = time() - (10 * 1);
		$datetime = date("Y-m-d H:i:s", $tree_minutes_ago);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " AND L.live_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getLives = mysqli_query($this->db, "SELECT DISTINCT
		L.live_id, L.live_name, L.live_uid_fk,L.finish_time, L.live_credit, L.live_type, U.iuid, U.i_username, U.i_user_fullname
		FROM i_live L FORCE INDEX(ix_Live)
		INNER JOIN i_users U FORCE INDEX(ixForceUser) ON L.live_uid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE L.finish_time >= '$tree_minutes_ago' AND L.live_uid_fk != '$userID' $morePost ORDER BY L.live_id DESC LIMIT $showingPost") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getLives, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		} 
	}
	/*Premium Live Gif Plan List*/
	public function iN_LiveGifPlansListFromAdmin() {
		$query = mysqli_query($this->db, "SELECT * FROM i_live_gift_point") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Insert New Advertisement*/
	public function iN_InsertNewGiftCard($userID, $giftImage, $giftName, $giftPoint, $giftAmount,$gifAnimationImage) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "INSERT INTO i_live_gift_point(gift_name,gift_point,gift_image,gift_money_equal,gift_money_animation_image)VALUES('$giftName','$giftPoint','$giftImage','$giftAmount', '$gifAnimationImage')") or die(mysqli_error($this->db));
			if ($query) {
				return true;
			} else {
				return false;
			}
		}
	}
	/*Check Premium Plan Exist*/
	public function GetLivePlanDetails($planID) {
		$planID = mysqli_real_escape_string($this->db, $planID);
		if ($this->CheckLivePlanExist($planID) == '1') {
			$query = mysqli_query($this->db, "SELECT * FROM i_live_gift_point WHERE gift_id = '$planID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		} else {return false;}
	}
	/*Update Live Point Plan*/
	public function iN_UpdateLivePlanFromID($userID, $giftName, $gifImage, $giftAnimation, $giftPoint, $giftAmount, $giftID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckLivePlanExist($giftID)) {
			mysqli_query($this->db, "UPDATE i_live_gift_point SET gift_name = '$giftName', gift_image = '$gifImage', gift_point = '$giftPoint', gift_money_equal = '$giftAmount', gift_money_animation_image = '$giftAnimation' WHERE gift_id = '$giftID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Plan Status*/
	public function iN_UpdateLivePlanStatus($userID, $mod, $planID) {
		$planID = mysqli_real_escape_string($this->db, $planID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckLivePlanExist($planID)) {
			mysqli_query($this->db, "UPDATE i_live_gift_point SET gift_status = '$mod' WHERE gift_id = '$planID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Plan*/
	public function iN_DeleteLivePlanFromData($userID, $planID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->CheckLivePlanExist($planID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_live_gift_point WHERE gift_id = '$planID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Premium Plan List*/
	public function iN_LiveGiftSendList() {
		$query = mysqli_query($this->db, "SELECT * FROM i_live_gift_point WHERE gift_status = '1'") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Update Users Wallets*/
	public function iN_UpdateUsersWalletsForLiveGift($userID,$cLiveID, $tiSendingUserID, $giftDataID,$liveWantedCoin, $adminEarning, $netUserEarning,$liveWantedMoney){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$giftDataID = mysqli_real_escape_string($this->db, $giftDataID);
		$tiSendingUserID = mysqli_real_escape_string($this->db, $tiSendingUserID);
		if ($this->iN_CheckUserExist($userID) == 1 && $this->CheckLivePlanExist($giftDataID) == 1 && $this->iN_CheckUserExist($tiSendingUserID) == 1) { 
			$time = time();
			mysqli_query($this->db, "UPDATE i_users SET wallet_points = wallet_points - '$liveWantedCoin' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "UPDATE i_users SET wallet_money = wallet_money + '$netUserEarning' WHERE iuid = '$tiSendingUserID'") or die(mysqli_error($this->db));$time = time();
            mysqli_query($this->db, "INSERT INTO i_user_payments(payer_iuid_fk, payed_iuid_fk,payment_type,payment_time,payment_status, amount,admin_earning, user_earning)VALUES('$userID','$tiSendingUserID', 'live_gift', '$time', 'ok','$liveWantedMoney', '$adminEarning', '$netUserEarning')") or die(mysqli_error($this->db));
			mysqli_query($this->db,"INSERT INTO i_live_chat(cm_live_id,cm_iuid_fk, cm_gift_type, cm_time)VALUES('$cLiveID','$userID','$giftDataID', '$time')") or die(mysqli_error($this->db));
			return true;
		}
	}
	/*Live Chat List*/
	public function iN_LiveChatMessages($liveID, $userID){
        $liveID = mysqli_real_escape_string($this->db, $liveID);
		if($this->iN_CheckLiveIDExist($liveID) == 1 && $this->iN_CheckUserExist($userID) == 1){
			$query = mysqli_query($this->db, "SELECT * FROM i_live_chat WHERE cm_live_id = '$liveID'") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			} 
		}
	}
	/*Get New Live Messages*/
	public function iN_GetNewLiveMessage($liveID, $lastLiveMessageID){
        $liveID = mysqli_real_escape_string($this->db, $liveID);
		$lastLiveMessageID = mysqli_real_escape_string($this->db, $lastLiveMessageID);
		if($this->iN_CheckLiveIDExist($liveID) == 1){
			$lasMessageID = '';
			if ($lastLiveMessageID) {
				$lasMessageID = "AND cm_id > '" . $lastLiveMessageID . "'";
			}
			$query = mysqli_query($this->db, "SELECT * FROM i_live_chat WHERE cm_live_id = '$liveID' $lasMessageID ORDER BY cm_live_id ") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			} 
		}
	}
	/*Insert and Get new Live Message*/
	public function iN_InsertLiveMessage($liveID,$liveMessage, $userID) { 
		if($this->iN_CheckLiveIDExist($liveID) == 1 && $this->iN_CheckUserExist($userID) == 1){
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			$InsertNewPost = mysqli_query($this->db, "INSERT INTO `i_live_chat`(cm_live_id,cm_iuid_fk,cm_message, cm_time)VALUES('$liveID','$userID','$liveMessage','$time')") or die(mysqli_error($this->db));
			$getLatestPost = mysqli_query($this->db, "SELECT M.cm_id,M.cm_live_id, M.cm_iuid_fk, M.cm_message, M.cm_time,M.cm_gift_type, U.iuid,U.i_username,U.i_user_fullname,U.user_avatar,U.user_gender,U.last_login_time,U.user_verified_status
			FROM i_live_chat M FORCE INDEX(LiveChatIndex)
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON M.cm_iuid_fk = U.iuid
			WHERE M.cm_live_id = '$liveID' AND M.cm_iuid_fk = '$userID' ORDER BY M.cm_id DESC LIMIT 1") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($getLatestPost, MYSQLI_ASSOC);
			return $result;
		} else{
			echo $liveID;
		}
	}
	/*All Live Streamings List*/
	public function iN_LiveStreaminsListAllTypeBottom($lastPostID, $showingPost,$userID) { 
		$tree_minutes_ago = time() - (10 * 1);
		$datetime = date("Y-m-d H:i:s", $tree_minutes_ago);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " AND L.live_id <'" . $lastPostID . "' ";
		}
		$data = null;
		$getLives = mysqli_query($this->db, "SELECT DISTINCT
		L.live_id, L.live_name, L.live_uid_fk,L.finish_time, L.live_credit, L.live_type, U.iuid, U.i_username, U.i_user_fullname
		FROM i_live L FORCE INDEX(ix_Live)
		INNER JOIN i_users U FORCE INDEX(ixForceUser) ON L.live_uid_fk = U.iuid AND U.uStatus IN('1','3')
		WHERE L.finish_time >= '$tree_minutes_ago' AND L.live_uid_fk != '$userID' $morePost ORDER BY L.live_id DESC LIMIT $showingPost") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getLives, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		} 
	}
	public function iN_OneSignalDeviceKey($userID, $userDeviceOneSignalKey) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$userDeviceOneSignalKey = mysqli_real_escape_string($this->db, $userDeviceOneSignalKey);
		if($this->iN_CheckUserExist($userID) == 1){
			$updateNotificationUser = mysqli_query($this->db, "UPDATE i_users SET device_key = '$userDeviceOneSignalKey' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			if ($updateNotificationUser) {
				return true;
			} else {return false;}
		}
		
	}
	public function iN_OneSignalDeviceKeyRemove($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$updateOneSignalDeviceKey = mysqli_query($this->db, "UPDATE i_users SET device_key = NULL WHERE iuid = '$userID'") or die(mysqli_error($this->db));
		if ($updateOneSignalDeviceKey) {
			return true;
		} else {return false;}
	}
	public function iN_OneSignalPushNotificationSend($msg_body, $msg_title, $url, $device_id, $oneSignalApi, $oneSignalRestApi) {
		$content = array(
			"en" => $msg_body,
		);
		$heading = array(
			"en" => $msg_title,
		);
		$include_player_id = array(
			$device_id,
		);

		$msg_img = '';
		$fields = array(
			'app_id' => $oneSignalApi,
			'contents' => $content,
			'headings' => $heading,
			'data' => array("foo" => "bar"),
			'small_icon' => "ic_launcher",
			'large_icon' => "ic_launcher",
			'image' => $msg_img,
			'include_player_ids' => $include_player_id,
			'url' => $url,
		);
		$fields = json_encode($fields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'Authorization: Basic ' . $oneSignalRestApi . ''));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	} 
	/*Check Affilate ID*/
	public function iN_CheckAffilateID($affilateID){ 
		$affilateID = mysqli_real_escape_string($this->db, $affilateID);
		$query = mysqli_query($this->db,"SELECT * FROM i_configuration_affilate WHERE i_af_id = '$affilateID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {return false;}
	}
	/*Get Register Affilate Details*/
	public function iN_GetRegisterAffilateData($type, $affilateID){
      $affilateType = mysqli_real_escape_string($this->db, $type);
      $affilateID = mysqli_real_escape_string($this->db, $affilateID); 
	  if(!empty($type) && $this->iN_CheckAffilateID($affilateID) == '1'){
         $query = mysqli_query($this->db, "SELECT * FROM i_configuration_affilate WHERE i_af_id = '$affilateID' AND i_af_type = '$type' AND i_af_status = 'yes'") or die(mysqli_error($this->db));
		 if($query){
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $data;
		 }else{
			return false;
		 }
	  }
	}
	/*Update Affilate System Mod*/
	public function iN_UpdateAffilateSystemStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET affilate_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Weekly Sub Mod*/
	public function iN_UpdateWeeklySubStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET sub_weekly_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Monthly Sub Mod*/
	public function iN_UpdateMonthlySubStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET sub_mountly_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Yearly Sub Mod*/
	public function iN_UpdateYearlySubStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET sub_yearly_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Watermark Mod*/
	public function iN_UpdateWatermarkStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET watermark_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Afflate Mod*/
	public function iN_UpdateAffiliateStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET affilate_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Site Business Informations*/
	public function iN_UpdateAffilateInfos($userID, $minimumPointTransferAmount, $affilateEarnAmount) {
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET minimum_point_transfer_request = '$minimumPointTransferAmount', affilate_amount = '$affilateEarnAmount' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get user Earn Point List*/
    public function iN_GetUserEarnPointData($userID){
		if ($this->iN_CheckIsAdmin($userID) == 1) {
            $query = mysqli_query($this->db,"SELECT * FROM i_configuration_affilate") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			} 
		}
	} 
	/*Update EPD*/
	public function iN_EPDUpdate($userID, $epdRegisterStatus, $epdCommentStatus, $epdNewPostStatus, $epdCommetLikeStatus, $epdPostLikeStatus, $epdRegisterAmount, $epdCommendAmount, $epdCommentLikeAmount, $epdNewPostAmount, $epdPostLikeAmount) {
		$query1 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_amount = '$epdRegisterAmount' WHERE i_af_id = '1'") or die(mysqli_error($this->db));
		$query2 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_status = '$epdRegisterStatus' WHERE i_af_id = '1'") or die(mysqli_error($this->db));
		$query3 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_amount = '$epdCommendAmount' WHERE i_af_id = '2'") or die(mysqli_error($this->db));
		$query4 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_status = '$epdCommentStatus' WHERE i_af_id = '2'") or die(mysqli_error($this->db));
		$query5 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_amount = '$epdPostLikeAmount' WHERE i_af_id = '3'") or die(mysqli_error($this->db));
		$query6 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_status = '$epdPostLikeStatus' WHERE i_af_id = '3'") or die(mysqli_error($this->db));
		$query7 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_amount = '$epdCommentLikeAmount' WHERE i_af_id = '4'") or die(mysqli_error($this->db));
		$query8 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_status = '$epdCommetLikeStatus' WHERE i_af_id = '4'") or die(mysqli_error($this->db));
		$query9 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_amount = '$epdNewPostAmount' WHERE i_af_id = '5'") or die(mysqli_error($this->db));
		$query10 = mysqli_query($this->db, "UPDATE i_configuration_affilate SET i_af_status = '$epdNewPostStatus' WHERE i_af_id = '5'") or die(mysqli_error($this->db));
		if($query1 && $query2 && $query3 && $query4 && $query5 && $query6 && $query7 && $query8 && $query9 && $query10){
           return true;
		}else{
		   return false;
		}
	}
	/*Check post EXISTs For Point*/
	public function iN_CheckPostIDExistForPointComment($postID, $userID) {
		$checkPostisExist = mysqli_query($this->db, "SELECT poninted_post_id FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND pointed_type = 'comment'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Check post EXISTs For Point*/
	public function iN_CheckPostIDExistForPointCommentLike($postID, $userID) {
		$checkPostisExist = mysqli_query($this->db, "SELECT poninted_post_id FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND pointed_type = 'comment_like'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkPostisExist) == 1) {
			return true;
		} else {return false;}
	}
	/*Insert New Post Point*/
	public function iN_InsertNewPoint($userID,$postID,$pointAmount){
		$time = time();
       if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1){
		  $InsertPoint = mysqli_query($this->db, "INSERT INTO i_user_point_earnings (poninted_post_id,poninted_user_id, pointed_time, pointed_type,calculated_point,point)VALUES('$postID','$userID','$time','new_post','0','$pointAmount')") or die(mysqli_error($this->db));
		  $updateUserEarning = mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points + '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
	   }
	}
	/*Insert New Post Point*/
	public function iN_InsertNewCommentPoint($userID,$postID,$pointAmount){
		$time = time();
       if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1 && $this->iN_CheckPostIDExistForPointComment($postID, $userID) == false){
		  $InsertPoint = mysqli_query($this->db, "INSERT INTO i_user_point_earnings (poninted_post_id,poninted_user_id, pointed_time, pointed_type,calculated_point,point)VALUES('$postID','$userID','$time','comment','0','$pointAmount')") or die(mysqli_error($this->db));
		  $updateUserEarning = mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points + '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
	   }
	}
	/*Insert New Post Like Point*/
	public function iN_InsertNewPostLikePoint($userID,$postID,$pointAmount){
		$time = time();
       if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1 && $this->iN_CheckPostIDExistForPointComment($postID, $userID) == false){
		  $InsertPoint = mysqli_query($this->db, "INSERT INTO i_user_point_earnings (poninted_post_id,poninted_user_id, pointed_time, pointed_type,calculated_point,point)VALUES('$postID','$userID','$time','post_like','0','$pointAmount')") or die(mysqli_error($this->db));
		  $updateUserEarning = mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points + '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
	   }
	}
	/*Insert New Post Comment Like Point*/
	public function iN_InsertNewPostCommentLikePoint($userID,$postID,$pointAmount){
		$time = time();
       if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckPostIDExist($postID) == 1 && $this->iN_CheckPostIDExistForPointCommentLike($postID, $userID) == false){
		  $InsertPoint = mysqli_query($this->db, "INSERT INTO i_user_point_earnings (poninted_post_id,poninted_user_id, pointed_time, pointed_type,calculated_point,point)VALUES('$postID','$userID','$time','comment_like','0','$pointAmount')") or die(mysqli_error($this->db));
		  $updateUserEarning = mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points + '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
	   }
	}
	/*Remove Point if Earned Before*/
	public function iN_RemovePointIfExist($userID, $postID, $pointAmount){
		if($this->iN_CheckUserExist($userID) == 1){
            $checkExist = mysqli_query($this->db,"SELECT * FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'new_post'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($checkExist) == 1){
				mysqli_query($this->db, "DELETE FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'new_post'") or die(mysqli_error($this->db));
				mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points - '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			}
		}
	}
	/*Remove Point if Earned Before*/
	public function iN_RemovePointCommentIfExist($userID, $postID, $pointAmount){
		if($this->iN_CheckUserExist($userID) == 1){
            $checkExist = mysqli_query($this->db,"SELECT * FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'comment'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($checkExist) == 1){
				mysqli_query($this->db, "DELETE FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'comment'") or die(mysqli_error($this->db));
				mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points - '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			}
		}
	}
	/*Remove Point if Earned Before*/
	public function iN_RemovePointPostLikeIfExist($userID, $postID, $pointAmount){
		if($this->iN_CheckUserExist($userID) == 1){
            $checkExist = mysqli_query($this->db,"SELECT * FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'post_like'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($checkExist) == 1){
				mysqli_query($this->db, "DELETE FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'post_like'") or die(mysqli_error($this->db));
				mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points - '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			}
		}
	}
	/*Remove Point if Earned Before*/
	public function iN_RemovePointPostCommentLikeIfExist($userID, $postID, $pointAmount){
		if($this->iN_CheckUserExist($userID) == 1){
            $checkExist = mysqli_query($this->db,"SELECT * FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'comment_like'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($checkExist) == 1){
				mysqli_query($this->db, "DELETE FROM i_user_point_earnings WHERE poninted_post_id = '$postID' AND poninted_user_id = '$userID' AND pointed_type = 'comment_like'") or die(mysqli_error($this->db));
				mysqli_query($this->db,"UPDATE i_users SET wallet_points = wallet_points - '$pointAmount' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
			}
		}
	}
	/*Check Post Owner */
	public function iN_CheckPostOwner($userID, $postID){
        $query = mysqli_query($this->db,"SELECT * FROM i_posts WHERE post_owner_id = '$userID' AND post_id = '$postID'") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query) == 1){
           return true;
		}else{
			return false;
		}
	}
	/*Check Post Owner */
	public function iN_CheckCommentOwner($userID, $postID){
        $query = mysqli_query($this->db,"SELECT * FROM i_post_comments WHERE comment_uid_fk = '$userID' AND comment_post_id_fk = '$postID'") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query) == 1){
           return true;
		}else{
			return false;
		}
	}
	/*Get user Earn Point List*/
    public function iN_GetUserEarnPointList($userID){
		if ($this->iN_CheckUserExist($userID) == 1) {
            $query = mysqli_query($this->db,"SELECT * FROM i_configuration_affilate WHERE ica_type = 'po' AND i_af_status = 'yes'") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				$data[] = $row;
			} 
			if (!empty($data)) {
				return $data;
			} 
		}
	}
	/*Today Earned comment point*/
	public function iN_TodayEarnedPoint($userID, $type){
		if ($this->iN_CheckUserExist($userID) == 1) {
			$todayEarned = mysqli_query($this->db,"SELECT * FROM i_user_point_earnings WHERE date(now()) = date(FROM_UNIXTIME(pointed_time)) AND poninted_user_id = '$userID' AND pointed_type = '$type' AND calculated_point = '0'") or die(mysqli_error($this->db)); 
			$data = mysqli_fetch_array($todayEarned, MYSQLI_ASSOC);
			/*Return result if icon id exist or not*/
			return isset($data['point']) ? $data['point'] : '0';
		}
	}
	/*Current Month Earn Calculate*/
	public function iN_CalculateTotalPointTypeEarningAll($userID, $type) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT SUM(point) AS calculate FROM i_user_point_earnings WHERE poninted_user_id = '$userID' AND pointed_type = '$type' AND calculated_point = '0'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($result['calculate']) ? $result['calculate'] : '0';
		} else {
			return false;
		}
	}
	/*Update Watermark Link Mod*/
	public function iN_UpdateLinkWatermarkStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET watermark_text_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Show FullName Mod*/
	public function iN_UpdateShowFullNameStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET use_fullname_or_username = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	public function iN_InsertMentionedUsersForPost($userID, $postDetails, $postID, $dataUsername,$userPostOwnerID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$postID = mysqli_real_escape_string($this->db, $postID);
		$mention_regex = '/@([A-Za-z0-9_]+)/i';
		$pregMatch = preg_match_all($mention_regex, $postDetails, $matches);
		if ($pregMatch) { 
			foreach ($matches[1] as $key => $match) {
				if ($match != $dataUsername) {
					// Add the user to an array if it is not the logged in user.
					$mentioned[] = mysqli_real_escape_string($this->db, $match);
				}else{
					$mentioned[] = '';
				}
			}
			$mentionTime = time();
			$mentioned = array_unique($mentioned); 
			$mention_sql = mysqli_query($this->db, "INSERT INTO i_mentions (m_uid_fk , m_type , m_post_id_fk,m_user_owner, m_status,mention_type, m_time ) SELECT iuid, NULL, '$postID','$userID', '1', 'post', '$mentionTime' FROM i_users WHERE i_username IN ('" . implode("','", $mentioned) . "')") or die(mysqli_error($this->db));
			mysqli_query($this->db, "INSERT INTO i_user_notifications(not_post_id, not_not_type,not_time, not_own_iuid, not_iuid) SELECT '$postID','umentioned', '$mentionTime', iuid, '$userID' FROM i_users WHERE i_username IN ('" . implode("','", $mentioned) . "')") or die(mysqli_error($this->db));
			
			$mentionNot = mysqli_query($this->db, "UPDATE i_users SET notification_read_status = '1' WHERE i_username IN ('" . implode("','", $mentioned) . "')") or die(mysqli_error($this->db));
		}
	}
	/*Get HashTags*/
	public function iN_GetHashTagsSearchResult($hashTag, $showingPosts) {

		$hashTag = mysqli_real_escape_string($this->db, strip_tags(trim($hashTag)));
		// Now if it has commas, you have to explode() it to an array
		$hashtags_list = explode(',', $hashTag);
		// A variable to hold all the hashtag LIKE conditions
		$hashtag_query = array();
		foreach ($hashtags_list as $ht) {
			// Each tag has to be checked with LIKE alone
			$hashtag_query[] = "FIND_IN_SET(LOWER('$ht'), LOWER(hashtags))";
		}
		$hashtag_query = array_unique($hashtag_query, SORT_REGULAR);
		// Make them into AND conditions
		$hashtag_query = implode(' AND ', $hashtag_query);
		mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
		$getData = mysqli_query($this->db, "SELECT * FROM i_posts WHERE ($hashtag_query) GROUP BY post_id DESC LIMIT $showingPosts") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($getData, MYSQLI_ASSOC)) {
			// Store the result into array
			$data[] = $row;
		}
		if (!empty($data)) {
			return isset($data) ? $data : FALSE;
		}
	} 
	public function iN_GenerateFakeUsers($userID, $fakeUserEmail, $fakeUserUsername, $fakeUserFullName, $fakeUserGender, $fakeUserPassword, $fakeUserBirthDay, $fakeUserRegisterTime, $fakeUserLatitude, $fakeUserLongitude,$random_countries,$fakeUserCategorie) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) { 
		    mysqli_query($this->db, "SET character_set_client=utf8mb4") or die(mysqli_error($this->db));
	  	    mysqli_query($this->db, "SET character_set_connection=utf8mb4") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db, "INSERT INTO `i_users`(i_user_email, i_username, i_user_fullname,user_gender,i_password,birthday,registered,last_login_time,lat, lon, fake_user_status,email_verify_status,countryCode,profile_category)VALUES('$fakeUserEmail','$fakeUserUsername','$fakeUserFullName','$fakeUserGender','$fakeUserPassword','$fakeUserBirthDay','$fakeUserRegisterTime','$fakeUserRegisterTime','$fakeUserLatitude','$fakeUserLongitude','1','yes','$random_countries','$fakeUserCategorie')") or die(mysqli_error($this->db));
			if($query){
				$getUserData = mysqli_query($this->db, "SELECT * FROM `i_users` WHERE i_username = '$fakeUserUsername'") or die(mysqli_error($this->db));
				$uData = mysqli_fetch_array($getUserData, MYSQLI_ASSOC);
				$GetUserID = $uData['iuid'];
				$time = time(); 
				mysqli_query($this->db, "INSERT INTO `i_friends` (fr_one,fr_two,fr_time,fr_status)VALUES('$GetUserID','$GetUserID','$time', 'me')") or die(mysqli_error($this->db));
			}
			return true;
		} else {return false;}
	}
	/*Update User Can Earn Point Mod*/
	public function iN_UpdateUserCanEarnPointStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET earn_point_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Update Become a Creator Type Status*/
	public function iN_UpdateBecomeACreatorTypeStatus($userID, $mod) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_configurations SET be_a_creator_status = '$mod' WHERE configuration_id = '1'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	public function iN_CheckUserAffilatedBefore($ip,$user){
	    if ($this->iN_CheckUserExist($user) == 1) {
	        $query = mysqli_query($this->db,"SELECT * FROM i_refUsers WHERE ref_owner_user_id = '$user' AND ip = '$ip'") or die(mysqli_error($this->db));
	        if(mysqli_num_rows($query) == 1){
	            return false;
	        }else{
	            return true;
	        }
	    }else{
	        return false;
	    }
	}
	public function iN_CheckCountFile($postFileIDs){
		$trimValue = rtrim($postFileIDs, ',');
		$explodeFiles = explode(',', $trimValue);
		$explodeFiles = array_unique($explodeFiles);
		$i = 0;
		foreach ($explodeFiles as $explodeFile) {
			$theFileID = $this->iN_GetUploadedFileDetails($explodeFile);
			$uploadedFileIDExt = isset($theFileID['uploaded_file_ext']) ? $theFileID['uploaded_file_ext'] : NULL;
			if($uploadedFileIDExt != 'mp3'){
                $i++;
			} 
		} 
		return isset($i) ? $i : NULL;
	}
	
	/*GET UPLOADED FILE DATA*/
	public function iN_GetUploadedMp3FileDetails($imageID) {
		if ($imageID) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_uploads WHERE upload_id='$imageID' AND uploaded_file_ext = 'mp3'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	public function iN_SearchMention($userID, $searchmUser) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$searchmUser = mysqli_real_escape_string($this->db, $searchmUser);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$sql_res = mysqli_query($this->db, "SELECT * FROM i_users WHERE (i_username like '%$searchmUser%' or i_user_fullname like '%$searchmUser%') ORDER BY iuid LIMIT 5") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($sql_res, MYSQLI_ASSOC)) {
				// Store the result into array
				$data[] = $row;
			}
			if (!empty($data)) {
				// Store the result into array
				return $data;
			}
	    }
	}
	/*INSERT UPLOADED FILES FROM UPLOADS TABLE*/
	public function iN_insertUploadedSotieFiles($uid, $filePath, $tumbnailPath, $fileXPath, $ext) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$filePath = mysqli_real_escape_string($this->db, $filePath);
		$fileXPath = mysqli_real_escape_string($this->db, $fileXPath);
		$fileExtension = mysqli_real_escape_string($this->db, $ext);
		$uploadTime = time();
		$userIP = $_SERVER['REMOTE_ADDR'];
		$query = mysqli_query($this->db, "INSERT INTO i_user_stories (uid_fk,uploaded_file_path,upload_tumbnail_file_path,uploaded_x_file_path, uploaded_file_ext,created)VALUES('$uid' ,'$filePath','$tumbnailPath','$fileXPath','$fileExtension','$uploadTime')") or die(mysqli_error($this->db));
		$ids = mysqli_insert_id($this->db);
		return $ids;
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedStoriesFilesIDs($uid, $imageName) {
		if ($imageName) {
			$query = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE uid_fk = '$uid' ORDER BY s_id DESC") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Check Storie ID Exist*/
	public function iN_CheckStorieIDExist($userID, $sID){
      $sID = mysqli_real_escape_string($this->db, $sID);
      $userID = mysqli_real_escape_string($this->db, $userID);
	  if ($this->iN_CheckUserExist($userID) == 1) {
		$checkStoreisExist = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE uid_fk = '$userID' AND s_id = '$sID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($checkStoreisExist) == 1) {
			return true;
		} else {return false;}
	  }
	}
	/*Get Non Shared Stories From Database*/
	public function iN_GetNonSharedStories($userID){
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) { 
		   $query = mysqli_query($this->db, "SELECT
			P.* , U.*
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_stories P FORCE INDEX(ixUserStories)
		    ON P.uid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.status = '1' AND P.uid_fk = '$userID'
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				// Store the result into array
				$data[] = $row;
			}
			if (!empty($data)) {
				// Store the result into array
				return $data;
			}
		}
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedStoriesData($userID, $sID) {
		if ($this->iN_CheckStorieIDExist($userID, $sID) == 1) { 
			$query = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE uid_fk = '$userID' AND s_id = '$sID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return $result;
		} else {
			return false;
		}
	}
	/*Update Storie Status*/
	public function iN_InsertMyStorie($userID, $storieID, $storieText) {
		$insertStorie = '';
        if($storieText){
          $insertStorie = ", text = '".$storieText."'";
		}
		mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
		mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
		if ($this->iN_CheckUserExist($userID) == 1) { 
			$query = mysqli_query($this->db, "UPDATE i_user_stories SET status = '2' $insertStorie WHERE s_id = '$storieID' AND uid_fk = '$userID'") or die(mysqli_error($this->db));
			if($query){
				return true;
			}else{
				return false;
			}
	    }
	}
	public function iN_FriendStoryPost($userID) {
		$uid = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) { 
			$query = mysqli_query($this->db, "
				SELECT DISTINCT
				S.*,  U.*, GROUP_CONCAT(S.s_id) as pics
				FROM i_user_stories S, i_users U, i_friends F
				WHERE U.uStatus = '3'
				AND S.uid_fk = U.iuid
				AND S.uid_fk = F.fr_two
				AND FROM_UNIXTIME(S.created) > (NOW() - INTERVAL 24 HOUR) 
				AND F.fr_one = '$userID'
				AND (F.fr_status = 'fri' OR F.fr_status = 'me' OR F.fr_status = '1' OR F.fr_status = 'flwr')
				GROUP BY S.uid_fk
				ORDER BY S.uid_fk ASC LIMIT 5") or die(mysqli_error($this->db));
					while ($row = mysqli_fetch_array($query)) {
						$data[] = $row;
					}
					if (!empty($data)) {
						return $data;
					}
		}
	}
	public function iN_GetLastSharedStatus($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$getLastStory = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE uid_fk = '$userID' ORDER BY s_id DESC LIMIT 1") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($getLastStory, MYSQLI_ASSOC);
		$lastStoryImg = isset($row['upload_tumbnail_file_path']) ? $row['upload_tumbnail_file_path'] : NULL;
		if (isset($lastStoryImg)) {
			return $lastStoryImg;
		} else {
			return false;
		}
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedStoriesDataS($sID) { 
		$query = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE s_id = '$sID'") or die(mysqli_error($this->db));
		$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($result) ? $result : NULL; 
	}
	/*Check Storie ID Exist*/
	public function iN_CheckStorieIDExistJustID($userID, $sID){
		$sID = mysqli_real_escape_string($this->db, $sID);
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
		  $checkStoreisExist = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE s_id = '$sID'") or die(mysqli_error($this->db));
		  if (mysqli_num_rows($checkStoreisExist) == 1) {
			  return true;
		  } else {return false;}
		}
	}
	/*Check Storie Seen Before*/
	public function iN_CheckStorieSeenBefore($userID, $storieID){
		$storieID = mysqli_real_escape_string($this->db, $storieID);
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckStorieIDExistJustID($userID, $storieID)) {
		    $checkSeen = mysqli_query($this->db,"SELECT * FROM i_stories_seen WHERE i_seen_uid_fk = '$userID' AND i_seen_storie_id = '$storieID'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($checkSeen) > 0){
               return false;
			}else{
			   return true;
			}
		}
	}
	/*Insert Storie Seen*/
	public function iN_InsertStorieSeen($userID, $storieID) {
		$storieID = mysqli_real_escape_string($this->db, $storieID);
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckStorieSeenBefore($userID, $storieID) == 1) {
		    mysqli_query($this->db,"INSERT INTO i_stories_seen(i_seen_uid_fk,i_seen_storie_id)VALUES('$userID','$storieID')") or die(mysqli_error($this->db)); 
		}
	}
	/*All User Storie Posts*/
	public function iN_AllUserStoriePosts($userID, $lastPostID, $showingPost) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.s_id <'" . $lastPostID . "' ";
		}
		$data = null; 
		/**/
		$query = mysqli_query($this->db, "SELECT
			P.* , U.*
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_stories P FORCE INDEX(ixUserStories)
		    ON P.uid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.status IN('1','2') AND P.uid_fk = '$userID' $morePost
			ORDER BY P.s_id
		DESC LIMIT $showingPosts") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				// Store the result into array
				$data[] = $row;
			}
			if (!empty($data)) {
				// Store the result into array
				return $data;
			}
	}
	/*CALCULATE HOW MANY USER SEEN USER STORIES*/
	public function iN_GetStorySeenCount($userID, $storieID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countStorieSeen = mysqli_query($this->db, "SELECT COUNT(*) AS totalSeen FROM i_stories_seen WHERE i_seen_storie_id = '$storieID' AND i_seen_uid_fk <> '$userID'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countStorieSeen, MYSQLI_ASSOC);
			return isset($row['totalSeen']) ? $row['totalSeen'] : '0';
		} else {
			return false;
		}
	}
	/*Get Storie Seen List*/
	public function iN_GetUploadedStoriesSeenData($userID,$storieID) { 
 
		if ($this->iN_CheckStorieIDExistJustID($userID, $storieID)) {
			$query = mysqli_query($this->db, "SELECT * FROM i_stories_seen WHERE i_seen_storie_id = '$storieID' AND i_seen_uid_fk <> '$userID'") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				// Store the result into array
				$data[] = $row;
			}
			if (!empty($data)) {
				// Store the result into array
				return $data;
			}
	    } 
	}
	/*CALCULATE HOW MANY USERS MALE OR FEMALE*/
	public function iN_GetTotalUserByGender($userID,$genderType) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$totalUsers = mysqli_query($this->db, "SELECT COUNT(*) AS totalUsers FROM i_users WHERE user_gender = '$genderType'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($totalUsers, MYSQLI_ASSOC);
			return isset($row['totalUsers']) ? $row['totalUsers'] : '0';
		} else {
			return false;
		}
	}
	/*CALCULATE HOW MANY USERS Activated*/
	public function iN_GetTotalEmailVerifiedUsers($userID,$verifyStatus) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$totalVerifiedUsers = mysqli_query($this->db, "SELECT COUNT(*) AS totalVerifiedUsers FROM i_users WHERE email_verify_status = '$verifyStatus'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($totalVerifiedUsers, MYSQLI_ASSOC);
			return isset($row['totalVerifiedUsers']) ? $row['totalVerifiedUsers'] : '0';
		} else {
			return false;
		}
	}
	/*All Storie Posts*/
	public function iN_AllTypeStoriePostsList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT P.*,U.*
			FROM i_user_stories P FORCE INDEX(ixUserStories)
				INNER JOIN i_users U FORCE INDEX(ixForceUser)
				ON P.uid_fk = U.iuid
			WHERE P.status IN('1','2') ORDER BY P.s_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Check Storie ID Exist*/
	public function iN_CheckStorieIDExistForAdmin($userID, $sID){
		$sID = mysqli_real_escape_string($this->db, $sID);
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
		  $checkStoreisExist = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE s_id = '$sID'") or die(mysqli_error($this->db));
		  if (mysqli_num_rows($checkStoreisExist) == 1) {
			  return true;
		  } else {return false;}
		}
	}
	/*GET UPLOADED FILE IDs*/
	public function iN_GetUploadedStoriesDataForAdmin($sID) {
		$query = mysqli_query($this->db, "SELECT * FROM i_user_stories WHERE s_id = '$sID'") or die(mysqli_error($this->db));
		$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return $result;
	}
    /*Insert Product*/
	public function iN_InsertNewProduct($userID, $productName, $productPrice, $productDescription, $productDescriptionInfo, $productFiles, $productNameSlug, $productType, $productLimSlots, $productQuestion) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db,"INSERT INTO i_user_product_posts(pr_name,pr_price, pr_files, pr_desc, pr_desc_info, pr_created_time, iuid_fk, pr_status, pr_seen_time, pr_number_of_sales, pr_name_slug, product_type, pr_slots_number, pr_question_answer)VALUES('$productName','$productPrice','$productFiles','$productDescription','$productDescriptionInfo','$time','$userID','1','0','0','$productNameSlug', '$productType','$productLimSlots', '$productQuestion')") or die(mysqli_error($this->db));
		    if($query){
                return true;
			} else{
				return false;
			}
		}
	} 
	/*Insert Product*/
	public function iN_InsertNewProductDownloadable($userID, $productName, $productPrice, $productDescription, $productDescriptionInfo, $productFiles, $productNameSlug, $productType, $productFile) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db,"INSERT INTO i_user_product_posts(pr_name,pr_price, pr_files, pr_desc, pr_desc_info, pr_created_time, iuid_fk, pr_status, pr_seen_time, pr_number_of_sales, pr_name_slug, product_type, pr_downlodable_files)VALUES('$productName','$productPrice','$productFiles','$productDescription','$productDescriptionInfo','$time','$userID','1','0','0','$productNameSlug', '$productType','$productFile')") or die(mysqli_error($this->db));
		    if($query){
                return true;
			} else{
				return false;
			}
		}
	} 
	/*Insert Product*/
	public function iN_InsertNewProductLiveEventTicket($userID, $productName, $productPrice, $productDescription, $productDescriptionInfo, $productFiles, $productNameSlug, $productType, $slotsNumber, $questionAnswer) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			if($slotsNumber == '' || empty($slotsNumber)){
               $slotsNumber = NULL;
			}
			if($questionAnswer == '' || empty($questionAnswer)){
				$questionAnswer = NULL;
			}
			$query = mysqli_query($this->db,"INSERT INTO i_user_product_posts(pr_name,pr_price, pr_files, pr_desc, pr_desc_info, pr_created_time, iuid_fk, pr_status, pr_seen_time, pr_number_of_sales, pr_name_slug, product_type, pr_slots_number, pr_question_answer)VALUES('$productName','$productPrice','$productFiles','$productDescription','$productDescriptionInfo','$time','$userID','1','0','0','$productNameSlug', '$productType','$slotsNumber', '$questionAnswer')") or die(mysqli_error($this->db));
		    if($query){
                return true;
			} else{
				return false;
			}
		}
	} 
	/*Check Product ID exist*/
	public function iN_CheckProductIDExist($userID, $productID){
		if ($this->iN_CheckUserExist($userID) == 1) {
		   $query = mysqli_query($this->db,"SELECT * FROM i_user_product_posts WHERE iuid_fk = '$userID' AND pr_id = '$productID'") or die(mysqli_error($this->db));
		   if(mysqli_num_rows($query) == 1){
               return true;
		   }else{
			   return false;
		   }
		}
	}
	/*Check Product ID EXIST Non Loged In User*/
	public function iN_CheckProductIDExistFromURL($productID){ 
		$query = mysqli_query($this->db,"SELECT * FROM i_user_product_posts WHERE pr_id = '$productID'") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query) == 1){
			return true;
		}else{
			return false;
		} 
	}
	/*Product List*/
	public function iN_ProductLists($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT
			P.*, U.*
			FROM i_users U FORCE INDEX(ixForceUser)
			INNER JOIN i_user_product_posts P FORCE INDEX(ixProduct)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3')
			WHERE P.pr_status IN('0','1') AND P.iuid_fk = '$userID' ORDER BY P.pr_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*User Total Subscribers*/
	public function iN_UserTotalProducts($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalProducts FROM i_user_product_posts WHERE iuid_fk = '$userID'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalProducts']) ? $row['totalProducts'] : '0';
		}
	}
	public function iN_UpdateProductStatus($userID, $productID,$productStatus){
        if($this->iN_CheckProductIDExist($userID, $productID) == 1){
            $query = mysqli_query($this->db,"UPDATE i_user_product_posts SET pr_status = '$productStatus' WHERE iuid_fk = '$userID' AND pr_id = '$productID'") or die(mysqli_error($this->db));
	        if($query){
              return true;
			} else{
			  return false;
			}
		}
	}
	/*GET product Details*/
	public function iN_ProductDetails($userID, $productID){
		if($this->iN_CheckProductIDExist($userID, $productID) == 1){
		   $query = mysqli_query($this->db,"SELECT * FROM i_user_product_posts WHERE iuid_fk = '$userID' AND pr_id = '$productID'") or die(mysqli_error($this->db));
		   $data = mysqli_fetch_array($query, MYSQLI_ASSOC);
		   return $data;
		}
	} 

	/*Get Product Details From URL ID*/ 
	public function iN_GetProductDetailsByID($productID) {
		$productID = mysqli_real_escape_string($this->db, $productID);
		if ($this->iN_CheckProductIDExistFromURL($productID) == '1') {
			$getData = mysqli_query($this->db, "SELECT DISTINCT P.* ,U.*
			FROM i_user_product_posts P FORCE INDEX (ixProduct) 
				INNER JOIN i_users U FORCE INDEX (ixForceUser)
				ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3') AND pr_status IN('1')
			WHERE P.pr_id = '$productID'
			ORDER BY P.pr_id") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($getData, MYSQLI_ASSOC);
			return $data;
		} else {return false;}
	}
	/*Insert Product*/
	public function iN_InsertUpdatedProduct($userID,$productID, $productName, $productPrice, $productDescription, $productDescriptionInfo, $productNameSlug,$productLimSlots,$productQuestion) {
		if ($this->iN_CheckProductIDExist($userID, $productID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$prQuestion = ", pr_question_answer = NULL";
			$prSlot = ", pr_slots_number = NULL";
			if(!empty($productLimSlots)){
				$prSlot = ", pr_slots_number = '".$productLimSlots."'";
			}
			if(!empty($productQuestion)){
				$prQuestion = ", pr_question_answer = '".$productQuestion."'";
			}
			$query = mysqli_query($this->db,"UPDATE i_user_product_posts SET pr_name = '$productName', pr_price = '$productPrice', pr_desc = '$productDescription', pr_desc_info = '$productDescriptionInfo' , pr_name_slug = '$productNameSlug' $prSlot $prQuestion WHERE iuid_fk = '$userID' AND pr_id = '$productID'") or die(mysqli_error($this->db));
		    if($query){
                return true;
			} else{
				return false;
			}
		}
	} 
	/*Delete Post From Data if Storage Deleting*/
	public function iN_DeleteProductFromDataifStorage($userID, $productID){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$productID = mysqli_real_escape_string($this->db, $productID);
		if ($this->iN_CheckProductIDExist($userID, $productID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_user_product_posts WHERE pr_id = '$productID' AND iuid_fk = '$userID'");
			return true;
		} else {
			return false;
		}
	}
	/*Delete Post From Data*/
	public function iN_DeleteProduct($userID, $productID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$productID = mysqli_real_escape_string($this->db, $productID);
		if ($this->iN_CheckProductIDExist($userID, $productID) == 1) {
			$getPostFileIDs = $this->iN_ProductDetails($userID,$productID);
			$postFileIDs = isset($getPostFileIDs['pr_files']) ? $getPostFileIDs['pr_files'] : NULL;
    		$checkS3Status = mysqli_query($this->db, "SELECT * FROM i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
    		$s3 = mysqli_fetch_array($checkS3Status, MYSQLI_ASSOC); 
    		$s3Status = $s3['s3_status'];
    		$oceanStatus = $s3['ocean_status']; 
			if ($postFileIDs && $s3Status != '1' && $oceanStatus != '1') {
				$trimValue = rtrim($postFileIDs, ',');
				$explodeFiles = explode(',', $trimValue);
				$explodeFiles = array_unique($explodeFiles);
				foreach ($explodeFiles as $explodeFile) {
					$theFileID = $this->iN_GetUploadedFileDetails($explodeFile);
					$uploadedFileID = $theFileID['upload_id'];
					$uploadedFilePath = $theFileID['uploaded_file_path'];
					$uploadedTumbnailFilePath = $theFileID['upload_tumbnail_file_path'];
					$uploadedFilePathX = $theFileID['uploaded_x_file_path'];
					@unlink('../' . $uploadedFilePath);
					@unlink('../' . $uploadedFilePathX);
					@unlink('../' . $uploadedTumbnailFilePath);
					mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE upload_id = '$uploadedFileID' AND iuid_fk = '$userID'");
				}
			}
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_user_product_posts WHERE pr_id = '$productID'");
				return true;
			} else {
				mysqli_query($this->db, "DELETE FROM i_user_product_posts WHERE pr_id = '$productID' AND iuid_fk = '$userID'");
				return true;
			}
		} else {
			return false;
		}
	}
	/*Insert Story BG*/
	public function iN_InsertNewStoryBg($userID, $filePath){
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db,"INSERT INTO i_story_text_bg(st_bg_img_url,st_bg_status)VALUES('$filePath', '0')") or die(mysqli_error($this->db));
		    if($query){
                return true;
			} else{
				return false;
			}
		}
	}
	/*All Story Bg Image*/
	public function iN_AllStoryBgList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_story_text_bg ORDER BY st_bg_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Total Story Bg Image*/
	public function iN_TotalStoryBgImage() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS StoryBgImageCount FROM i_story_text_bg") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return isset($row['StoryBgImageCount']) ? $row['StoryBgImageCount'] : '0';
		} else {return 0;}
	}
	/*Check Story Bg ID Exist*/
	public function iN_CheckStoryBgIdExist($bgID){
       $query = mysqli_query($this->db,"SELECT * FROM i_story_text_bg WHERE st_bg_id = '$bgID'") or die(mysqli_error($this->db));
	   if(mysqli_num_rows($query) == 1){
           return true;
	   }else{
		   return false;
	   }
	}
	/*Update Story Bg Status*/
	public function iN_UpdateStoryBgStatus($userID, $mode, $bgID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckStoryBgIdExist($bgID) == 1) {
			mysqli_query($this->db, "UPDATE i_story_text_bg SET st_bg_status = '$mode' WHERE st_bg_id = '$bgID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Delete Sticker*/
	public function iN_DeleteStoryBg($userID, $storyBgIMG) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckStoryBgIdExist($storyBgIMG) == 1) {
			mysqli_query($this->db, "DELETE FROM i_story_text_bg WHERE st_bg_id = '$storyBgIMG'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get All Story Background Images*/
	public function iN_GetStoryBgImages(){
		$query = mysqli_query($this->db, "SELECT * FROM i_story_text_bg WHERE st_bg_status = '1'") or die(mysqli_error($this->db));
		while ($row = mysqli_fetch_array($query)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Get Choosed Bg Image*/
	public function iN_GetChoosedBgImage(){
		$query = mysqli_query($this->db, "SELECT * FROM i_story_text_bg WHERE choosed_status = 'ok'") or die(mysqli_error($this->db));
		$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
		if($result){
			return isset($result['st_bg_img_url']) ? $result['st_bg_img_url'] : FALSE;
		} 
	}
	/*Get Story Background Image from ID*/
	public function iN_GetBgImageByID($bgID){
        if($this->iN_CheckStoryBgIdExist($bgID) == 1){
			$query = mysqli_query($this->db, "SELECT * FROM i_story_text_bg WHERE st_bg_id = '$bgID'") or die(mysqli_error($this->db));
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if($result){
				return isset($result['st_bg_img_url']) ? $result['st_bg_img_url'] : FALSE;
			}
		}
	}
	/*Share My Text Story*/
	public function iN_InsertTextStory($userID, $bgID ,$storyText) {

        if($this->iN_CheckStoryBgIdExist($bgID) == 1 && $this->iN_CheckUserExist($userID) == 1){
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$bgImage = $this->iN_GetBgImageByID($bgID);
			$query = mysqli_query($this->db,"INSERT INTO i_user_stories(uid_fk,uploaded_file_path,upload_tumbnail_file_path, uploaded_x_file_path, uploaded_file_ext,text, text_style, created, status, story_type)VALUES('$userID','$bgImage', '$bgImage', '$bgImage','png','$storyText', 'one','$time','1','textStory')") or die(mysqli_error($this->db));
			if($query){
               return true;
			}else{
				return false;
			}
		}
	} 
	/*Get Other Products*/
	public function iN_OtherProductsByUserID($productOwnerID){
       if($this->iN_CheckUserExist($productOwnerID) == 1){
          $query = mysqli_query($this->db,"SELECT DISTINCT P.* ,U.*
		  FROM i_user_product_posts P FORCE INDEX (ixProduct) 
			  INNER JOIN i_users U FORCE INDEX (ixForceUser)
			  ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3') AND pr_status IN('1')
		  WHERE P.iuid_fk = '$productOwnerID'
		  ORDER BY P.pr_id DESC LIMIT 4") or die(mysqli_error($this->db));
		    while ($row = mysqli_fetch_array($query)) {
			    $data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
	   }
	}
	/*Check IP Exist Before*/
	public function iN_CheckIPExist($ip, $pID){
        $query = mysqli_query($this->db,"SELECT * FROM i_product_seen_time WHERE p_uid_ip ='$ip' AND p_id = '$pID'") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query) == 1){
            return true;
		}else{
			return false;
		}
	}
	/*Insert User Product Seen*/
	public function iN_InsertVisitor($ip,$uProductID,$lUserID) {
		$userIP = mysqli_real_escape_string($this->db, $ip);
		$uProductID = mysqli_real_escape_string($this->db, $uProductID);
		$time = time();
		if($this->iN_CheckIPExist($userIP, $uProductID) == '0'){
			if(isset($lUserID) && !empty($lUserID) && $lUserID != ''){ 
				$insertSeen = mysqli_query($this->db,"INSERT INTO i_product_seen_time(p_uid_ip, p_id,p_seen_time,p_s_iuid_fk)VALUES('$userIP','$uProductID','$time','$lUserID')") or die(mysqli_error($this->db));
			}else{
				$insertSeen = mysqli_query($this->db,"INSERT INTO i_product_seen_time(p_uid_ip, p_id,p_seen_time)VALUES('$userIP','$uProductID','$time')") or die(mysqli_error($this->db));
			}
		} 
	}
	/*Product Seen Count*/
	public function iN_TotalProductSeen($pID) {
		$pID = mysqli_real_escape_string($this->db, $pID);
		$countProductSeen = mysqli_query($this->db, "SELECT COUNT(*) AS productSeenCount FROM i_product_seen_time WHERE p_id = '$pID'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($countProductSeen, MYSQLI_ASSOC);
		return isset($row['productSeenCount']) ? $row['productSeenCount'] : '0';
	}
	/*Product Sell Count*/
	public function iN_TotalProductSell($pID) {
		$pID = mysqli_real_escape_string($this->db, $pID);
		$countProductSeen = mysqli_query($this->db, "SELECT COUNT(*) AS productSellCount FROM i_user_payments WHERE paymet_product_id = '$pID'") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($countProductSeen, MYSQLI_ASSOC);
		return isset($row['productSellCount']) ? $row['productSellCount'] : '0';
	}
	/*Check item purchased before*/
	public function iN_CheckItemPurchasedBefore($userID, $productID){
		if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckProductIDExistFromURL($productID)){
            $query = mysqli_query($this->db,"SELECT * FROM i_user_payments WHERE paymet_product_id = '$productID' AND payer_iuid_fk = '$userID'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($query) > 0){
               return true;
			}else{
				return false;
			}
		}
	}
	public function download($url,$fake) {
		set_time_limit(0); // Prevent timeouts
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$r = curl_exec($ch);
		curl_close($ch);
	  
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header("Content-Length: " . filesize($url));
		header('Content-Disposition: attachment; filename='.basename($fake));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($url));
		@ob_end_clean();
		readfile($url);
		echo $r;
	}
	/*Product Sell List*/
	public function iN_SalesProductList($userID,$paginationLimit,$page){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT P.*,U.*,X.*
				FROM i_users U FORCE INDEX(ixForceUser)
					INNER JOIN i_user_payments P FORCE INDEX (ixPayment)
					ON P.payed_iuid_fk = U.iuid
					INNER JOIN i_user_product_posts X FORCE INDEX (ixProduct)
					ON X.pr_id = P.paymet_product_id AND U.uStatus IN('1','3') AND P.payment_type IN('product')
				WHERE P.payed_iuid_fk='$userID' AND X.pr_id = P.paymet_product_id
				ORDER BY P.payed_iuid_fk
				DESC LIMIT $start_from, $paginationLimit ") or die(mysqli_error($this->db)); 
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		} 
	}
	/*User Total Subscribers*/
	public function iN_UserTotalProductsSales($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalProductSales FROM i_user_payments WHERE payed_iuid_fk = '$userID' AND payment_type IN('product')") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalProductSales']) ? $row['totalProductSales'] : '0';
		}
	}
	/*Product Sell List*/
	public function iN_MyPurchasedProductList($userID,$paginationLimit,$page){
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT DISTINCT P.*,U.*,X.*
				FROM i_users U FORCE INDEX(ixForceUser)
					INNER JOIN i_user_payments P FORCE INDEX (ixPayment)
					ON P.payer_iuid_fk = U.iuid
					INNER JOIN i_user_product_posts X FORCE INDEX (ixProduct)
					ON X.pr_id = P.paymet_product_id AND U.uStatus IN('1','3') AND P.payment_type IN('product')
				WHERE P.payer_iuid_fk='$userID' AND X.pr_id = P.paymet_product_id
				ORDER BY P.payed_iuid_fk
				DESC LIMIT $start_from, $paginationLimit ") or die(mysqli_error($this->db)); 
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		} 
	}
	/*User Total Subscribers*/
	public function iN_UserTotalPurchasedProducts($userID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckUserExist($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalProductSales FROM i_user_payments WHERE payer_iuid_fk = '$userID' AND payment_type IN('product')") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalProductSales']) ? $row['totalProductSales'] : '0';
		}
	}
	/*Shop Data*/
	public function iN_ShopData($userID, $id){
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db,"SELECT * FROM i_shop_configuration WHERE id = '$id'");
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($result['status']) ? $result['status'] : NULL;
		}
	}
	/*Update Post Create Mod*/
	public function iN_UpdateShopFeatureStatus($userID, $mod, $ID) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_shop_configuration SET status = '$mod' WHERE id = '$ID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Story Data*/
	public function iN_StoryData($userID, $id){
		if ($this->iN_CheckUserExist($userID) == 1) {
			$query = mysqli_query($this->db,"SELECT * FROM i_story_configuration WHERE id = '$id'");
			$result = mysqli_fetch_array($query, MYSQLI_ASSOC);
			return isset($result['sstatus']) ? $result['sstatus'] : NULL;
		}
	}
	/*Update Post Create Mod*/
	public function iN_UpdateStoryFeatureStatus($userID, $mod, $ID) {
		if ($this->iN_CheckUserExist($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_story_configuration SET sstatus = '$mod' WHERE id = '$ID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*All Announcement*/
	public function iN_AllCreatedAnnouncement($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_announcement ORDER BY a_id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*User Total Subscribers*/
	public function iN_HowManyUserSeeAnnouncement($userID, $announcementID) { 
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$countSubscribers = mysqli_query($this->db, "SELECT COUNT(*) AS totalViewers FROM i_announcement_seen WHERE a_id_fk = '$announcementID'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($countSubscribers, MYSQLI_ASSOC);
			return isset($row['totalViewers']) ? $row['totalViewers'] : '0';
		}
	}
	/*Total ANNOUNCEMENT*/
	public function iN_TotalAnnouncement() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS announcementCounted FROM i_announcement") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return isset($row['announcementCounted']) ? $row['announcementCounted'] : 0;
		} else {return 0;}
	}
	/*Insert New Announcement*/
	public function iN_InsertAnnouncement($userID, $announcementText, $annoucementStatus, $announcementType) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db,"INSERT INTO i_announcement(a_text, a_who_see, a_status, a_created_time)VALUES('$announcementText','$announcementType','$annoucementStatus','$time')") or die(mysqli_error($this->db));
			if($query){
                return true;
			}else{
				return false;
			}
		}
	}
	/*Update Sticker Status*/
	public function iN_UpdateAnnouncementStatus($userID, $mode, $sID) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			mysqli_query($this->db, "UPDATE i_announcement SET a_status = '$mode' WHERE a_id = '$sID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Check Announcement ID Exist*/
	public function iN_CheckAnnouncementIDExist($aID) {
		$aID = mysqli_real_escape_string($this->db, $aID);
		$query = mysqli_query($this->db, "SELECT * FROM i_announcement WHERE a_id = '$aID'") or die(mysqli_error($this->db));
		if (mysqli_num_rows($query) == 1) {
			return true;
		} else {
			return false;
		}
	}
	/*Delete Announcement*/
	public function iN_DeleteAnnouncement($userID, $aID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckAnnouncementIDExist($aID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_announcement WHERE a_id = '$aID'") or die(mysqli_error($this->db));
			mysqli_query($this->db, "DELETE FROM i_announcement_seen WHERE a_id_fk = '$aID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get Sticker Details From ID*/
	public function iN_GetAnnouncementDetailsFromID($userID, $aID) {
		$aID = mysqli_real_escape_string($this->db, $aID);
		if($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckAnnouncementIDExist($aID) == 1){
			$query = mysqli_query($this->db, "SELECT * FROM i_announcement WHERE a_id = '$aID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			/*Return result if icon id exist or not*/
			return $data;
		}
	}
	/*Update Announcement*/
	public function iN_UpdateAnnouncement($userID, $aID, $announcementText, $annoucementStatus, $announcementType) {
		if($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckAnnouncementIDExist($aID) == 1){
			mysqli_query($this->db, "UPDATE i_announcement SET a_status = '$annoucementStatus', a_text = '$announcementText', a_who_see = '$announcementType' WHERE a_id = '$aID'") or die(mysqli_error($this->db));
			return true;
		}else{
			return false;
		}
	}
	/*Get Announcement*/
	public function iN_ShowAnnouncement(){
		$query = mysqli_query($this->db,"SELECT * FROM i_announcement WHERE a_status = 'yes' ORDER BY a_id DESC LIMIT 1") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query) == 1){
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC); 
			return $data;
		}
	}
	/*Accept Announcement*/
	public function iN_AnnouncementAccepted($userID, $announceID) {
		if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckAnnouncementIDExist($announceID) == 1){
			$time = time();
		   $query = mysqli_query($this->db,"INSERT INTO i_announcement_seen(a_id_fk, iuid_fk,a_seen_time)VALUES('$announceID','$userID','$time')") or die(mysqli_error($this->db));
		   if($query){
              return true;
		   }else{
			   return false;
		   }
		}
	}
	/*Accept Announcement*/
	public function iN_CheckUserAcceptedAnnouncementBefore($userID, $announceID) {
		if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckAnnouncementIDExist($announceID) == 1){
			$time = time();
			$query = mysqli_query($this->db,"SELECT * FROM i_announcement_seen WHERE a_id_fk = '$announceID' AND iuid_fk = '$userID'") or die(mysqli_error($this->db));
			if(mysqli_num_rows($query) == 1){
				return false;
			}else{
				return true;
			}
		}
	}
	/*All User Storie Posts*/
	public function iN_AllUserProductPosts($category, $lastPostID, $showingPost) { 
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$category = mysqli_real_escape_string($this->db, $category);
		$morePost = $pCategory = "" ;
		if ($lastPostID) {
			$morePost = " AND P.pr_id <'" . $lastPostID . "' ";
		}
		if($category){
           $pCategory = " AND P.product_type = '" . $category . "' ";
		}
		$data = null; 
		/**/
		$query = mysqli_query($this->db, "SELECT P.* , U.*
			FROM i_user_product_posts P FORCE INDEX(ixProduct)
			    INNER JOIN i_users U FORCE INDEX(ixForceUser)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3')
			    WHERE P.pr_status IN('1') $pCategory $morePost
			    ORDER BY P.pr_id
		        DESC LIMIT $showingPost") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				// Store the result into array
				$data[] = $row;
			}
			if (!empty($data)) {
				// Store the result into array
				return $data;
			}
	}
	/*Total Products*/
	public function iN_TotalProducts($userID) {
		if($this->iN_CheckIsAdmin($userID) == 1){
			$q = mysqli_query($this->db, "SELECT COUNT(*) AS productCount FROM i_user_product_posts") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
			if ($row) {
				return isset($row['productCount']) ? $row['productCount'] : '0';
			} else {return 0;}
	    }
	}
	/*Total Products BY USER*/
	public function iN_TotalProductByUser($userID) {
		if($this->iN_CheckUserExist($userID) == 1){
			$q = mysqli_query($this->db, "SELECT COUNT(*) AS productCount FROM i_user_product_posts WHERE iuid_fk = '$userID'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
			if ($row) {
				return isset($row['productCount']) ? $row['productCount'] : '0';
			} else {return 0;}
	    }
	}
	/*CALCULATE HOW MANY USERS MALE OR FEMALE*/
	public function iN_GetTotalProductByCategory($userID,$prType) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$totalProduct = mysqli_query($this->db, "SELECT COUNT(*) AS totalProduct FROM i_user_product_posts WHERE product_type = '$prType'") or die(mysqli_error($this->db));
			$row = mysqli_fetch_array($totalProduct, MYSQLI_ASSOC);
			return isset($row['totalProduct']) ? $row['totalProduct'] : '0';
		} else {
			return false;
		}
	}
	/*All Posts*/
	public function iN_AllTypeOfProductList($userID, $paginationLimit, $page, $searchValue) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;  
		$startSearch = '';
		if(!empty($searchValue)){
           $startSearch = "WHERE (P.pr_name Like '%$searchValue' OR P.pr_name Like '$searchValue%' OR P.pr_name Like '$searchValue' OR P.pr_name_slug Like '%$searchValue' OR P.pr_name_slug Like '$searchValue%' OR P.pr_name_slug Like '$searchValue' OR P.pr_name_slug Like '%$searchValue%')";
		}
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT P.* , U.*
			FROM i_user_product_posts P FORCE INDEX(ixProduct)
			    INNER JOIN i_users U FORCE INDEX(ixForceUser)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3') $startSearch ORDER BY P.pr_id DESC LIMIT $start_from, $paginationLimit ") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	public function iN_DeleteProductAdmin($userID, $productID) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$productID = mysqli_real_escape_string($this->db, $productID);
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckProductIDExistFromURL($productID) == 1) {
			$getPostFileIDs = $this->iN_GetProductDetailsByID($productID);
			$postFileIDs = isset($getPostFileIDs['pr_files']) ? $getPostFileIDs['pr_files'] : NULL;
    		$checkS3Status = mysqli_query($this->db, "SELECT * FROM i_configurations WHERE configuration_id = '1'") or die(mysqli_error($this->db));
    		$s3 = mysqli_fetch_array($checkS3Status, MYSQLI_ASSOC); 
    		$s3Status = $s3['s3_status'];
    		$oceanStatus = $s3['ocean_status']; 
			if ($postFileIDs && $s3Status != '1' && $oceanStatus != '1') {
				$trimValue = rtrim($postFileIDs, ',');
				$explodeFiles = explode(',', $trimValue);
				$explodeFiles = array_unique($explodeFiles);
				foreach ($explodeFiles as $explodeFile) {
					$theFileID = $this->iN_GetUploadedFileDetails($explodeFile);
					$uploadedFileID = $theFileID['upload_id'];
					$uploadedFilePath = $theFileID['uploaded_file_path'];
					$uploadedTumbnailFilePath = $theFileID['upload_tumbnail_file_path'];
					$uploadedFilePathX = $theFileID['uploaded_x_file_path'];
					@unlink('../' . $uploadedFilePath);
					@unlink('../' . $uploadedFilePathX);
					@unlink('../' . $uploadedTumbnailFilePath);
					mysqli_query($this->db, "DELETE FROM i_user_uploads WHERE upload_id = '$uploadedFileID' AND iuid_fk = '$userID'");
				}
			}
			if ($this->iN_CheckIsAdmin($userID) == 1) {
				mysqli_query($this->db, "DELETE FROM i_user_product_posts WHERE pr_id = '$productID'");
				return true;
			} else {
				mysqli_query($this->db, "DELETE FROM i_user_product_posts WHERE pr_id = '$productID' AND iuid_fk = '$userID'");
				return true;
			}
		} else {
			return false;
		}
	}
	/*Show profile posts by selection*/
	public function iN_AllUserProfilePostsByChooseAudios($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		} 
		$data = null;
		$getData = mysqli_query($this->db, "SELECT P.*,U.*,A.*
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two 
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')  
			INNER JOIN i_user_uploads A FORCE INDEX (iuPostOwner)
			ON P.post_owner_id = A.iuid_fk
		WHERE P.post_owner_id='$uid'  AND P.post_file <> '' AND A.uploaded_file_ext = 'mp3' AND FIND_IN_SET(A.upload_id, P.post_file) $morePost
		GROUP BY P.post_id
        ORDER BY P.post_id
		DESC LIMIT $showingPost") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Show profile posts by selection*/
	public function iN_AllUserProfilePostsByChooseVideos($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		} 
		$data = null;
		$getData = mysqli_query($this->db, "SELECT P.*,U.*,A.*
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two 
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')  
			INNER JOIN i_user_uploads A FORCE INDEX (iuPostOwner)
			ON P.post_owner_id = A.iuid_fk
		WHERE P.post_owner_id='$uid'  AND P.post_file <> '' AND A.uploaded_file_ext = 'mp4' AND FIND_IN_SET(A.upload_id, P.post_file) $morePost
		GROUP BY P.post_id
        ORDER BY P.post_id
		DESC LIMIT $showingPost") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Show profile posts by selection*/
	public function iN_AllUserProfilePostsByChoosePhotos($uid, $lastPostID, $showingPost) {
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.post_id <'" . $lastPostID . "' ";
		} 
		$data = null;
		$getData = mysqli_query($this->db, "SELECT P.*,U.*,A.*
		FROM i_friends F FORCE INDEX(ixFriend)
			INNER JOIN i_posts P FORCE INDEX (ixForcePostOwner)
			ON P.post_owner_id = F.fr_two 
			INNER JOIN i_users U FORCE INDEX (ixForceUser)
			ON P.post_owner_id = U.iuid AND U.uStatus IN('1','3') AND F.fr_status IN('me', 'flwr', 'subscriber')  
			INNER JOIN i_user_uploads A FORCE INDEX (iuPostOwner)
			ON P.post_owner_id = A.iuid_fk
		WHERE P.post_owner_id='$uid'  AND P.post_file <> '' AND A.uploaded_file_ext IN('gif','GIF','jpg','JPG','jpeg','JPEG','PNG','png') AND FIND_IN_SET(A.upload_id, P.post_file) $morePost
		GROUP BY P.post_id
        ORDER BY P.post_id
		DESC LIMIT $showingPost") or die(mysqli_error($this->db));

		while ($row = mysqli_fetch_array($getData)) {
			$data[] = $row;
		}
		if (!empty($data)) {
			return $data;
		}
	}
	/*Show Products*/
	public function iN_AllUserProfileProductPosts($uid, $lastPostID, $showingPost){
		$uid = mysqli_real_escape_string($this->db, $uid);
		$lastPostID = mysqli_real_escape_string($this->db, $lastPostID);
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost);
		$morePost = "";
		if ($lastPostID) {
			$morePost = " and P.pr_id <'" . $lastPostID . "' ";
		} 
		$data = null;

		$query = mysqli_query($this->db, "SELECT P.* , U.*
			FROM i_user_product_posts P FORCE INDEX(ixProduct)
			    INNER JOIN i_users U FORCE INDEX(ixForceUser)
		    ON P.iuid_fk = U.iuid AND U.uStatus IN('1','3') 
			WHERE P.iuid_fk = '$uid' $morePost ORDER BY P.pr_id DESC LIMIT $showingPost ") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
	}
	/*Move My Point*/
	public function iN_MoveMyPoint($userID){
       
	   if($this->iN_CheckUserExist($userID) == 1){
		$getAffilateEarnedPoint = $this->iN_GetUserDetails($userID);
		$point = $getAffilateEarnedPoint['affilate_earnings'];
		$insertPoint = mysqli_query($this->db, "UPDATE i_users SET affilate_earnings = '0', wallet_points = wallet_points + '$point' WHERE iuid = '$userID'") or die(mysqli_error($this->db));
		return true;
	   }
	} 
	public function iN_CalculatePreviousMonthEarning($userID){
		$query = mysqli_query($this->db,"SELECT SUM(user_earning) AS TotalEarning FROM i_user_payments WHERE payment_status = 'ok' AND payed_iuid_fk = '$userID' AND FROM_UNIXTIME(payment_time) BETWEEN DATE_FORMAT(NOW() - INTERVAL 1 MONTH, '%Y-%m-01 00:00:00')
		AND DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), '%Y-%m-%d 23:59:59')") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['TotalEarning']) ? $row['TotalEarning'] : '0.00';
	}
	/*Total Premium Earnings Weekly*/
	public function iN_WeeklyTotalPremiumEarningUser($userID) {
		$query = mysqli_query($this->db, "SELECT SUM(user_earning) AS WeekTotalEarnPremium FROM i_user_payments WHERE payment_status = 'ok' AND payed_iuid_fk = '$userID' AND WEEK(FROM_UNIXTIME(payment_time)) = WEEK(NOW())") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['WeekTotalEarnPremium']) ? $row['WeekTotalEarnPremium'] : '0.00';
	}
	/*Total Premium Earnings Current Day*/
	public function iN_CurrentDayTotalPremiumEarningUser($userID) {
		$query = mysqli_query($this->db, "SELECT SUM(user_earning) AS DayTotalEarnPremium FROM i_user_payments WHERE payment_status = 'ok' AND payed_iuid_fk = '$userID' AND DAY(FROM_UNIXTIME(payment_time)) = DAY(CURDATE()) ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['DayTotalEarnPremium']) ? $row['DayTotalEarnPremium'] : '0.00'; 
	}
	/*Total Premium Earnings Current Month*/
	public function iN_CurrentMonthTotalPremiumEarningUser($userID) {
		$query = mysqli_query($this->db, "SELECT SUM(user_earning) AS MonthTotalEarnPremium FROM i_user_payments WHERE payment_status = 'ok' AND payed_iuid_fk = '$userID' AND MONTH(FROM_UNIXTIME(payment_time)) = MONTH(CURDATE()) ") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		return isset($row['MonthTotalEarnPremium']) ? $row['MonthTotalEarnPremium'] : '0.00';
	}
	/*Total Story Bg Image*/
	public function iN_TotalSocialNetworks() {
		$q = mysqli_query($this->db, "SELECT COUNT(*) AS socialNetwork FROM i_social_networks") or die(mysqli_error($this->db));
		$row = mysqli_fetch_array($q, MYSQLI_ASSOC);
		if ($row) {
			return isset($row['socialNetwork']) ? $row['socialNetwork'] : '0';
		} else {return 0;}
	}
	/*All Story Bg Image*/
	public function iN_AllSocialNetworkList($userID, $paginationLimit, $page) {
		$userID = mysqli_real_escape_string($this->db, $userID);
		$paginationLimit = mysqli_real_escape_string($this->db, $paginationLimit);
		$page = mysqli_real_escape_string($this->db, $page);
		$start_from = ($page - 1) * $paginationLimit;
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$query = mysqli_query($this->db, "SELECT * FROM i_social_networks ORDER BY id DESC LIMIT $start_from, $paginationLimit
			") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}
	}
	/*Insert New Announcement*/
	public function iN_InsertNewSocialSite($userID, $newSocialSite, $newSocialSiteKey, $newSocialSiteStatus, $newSocialSiteSVGCode) {
		if ($this->iN_CheckIsAdmin($userID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$query = mysqli_query($this->db,"INSERT INTO i_social_networks(social_icon, skey, place_holder, status)VALUES('$newSocialSiteSVGCode','$newSocialSiteKey','$newSocialSite','$newSocialSiteStatus')") or die(mysqli_error($this->db));
			if($query){
                return true;
			}else{
				return false;
			}
		}
	}
	/*Check Story Bg ID Exist*/
	public function iN_CheckSocialSiteIdExist($sID){
		$query = mysqli_query($this->db,"SELECT * FROM i_social_networks WHERE id = '$sID'") or die(mysqli_error($this->db));
		if(mysqli_num_rows($query) == 1){
			return true;
		}else{
			return false;
		}
	 }
	/*Update Story Bg Status*/
	public function iN_UpdateSocialSiteStatus($userID, $mode, $sID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckSocialSiteIdExist($sID) == 1) {
			mysqli_query($this->db, "UPDATE i_social_networks SET status = '$mode' WHERE id = '$sID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	/*Get Social Link Details By ID*/
	public function iN_GetSocialLinkDetails($userID, $ID){
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckSocialSiteIdExist($ID) == 1) {
			$query = mysqli_query($this->db,"SELECT * FROM i_social_networks WHERE id = '$ID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if($data){
				return $data;   
			}else{
				return false;
			}
		} else {
			return false;
		}
	}
	/*Insert New Announcement*/
	public function iN_UpdateSocialSite($userID, $socialSID, $newSocialSite, $newSocialSiteKey, $newSocialSiteStatus, $newSocialSiteSVGCode) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckSocialSiteIdExist($socialSID) == 1) {
			$time = time();
			mysqli_query($this->db, "SET character_set_client=utf8") or die(mysqli_error($this->db));
			mysqli_query($this->db, "SET character_set_connection=utf8") or die(mysqli_error($this->db));
			$updateSSite = mysqli_query($this->db, "UPDATE i_social_networks SET social_icon = '$newSocialSiteSVGCode', skey = '$newSocialSiteKey' , place_holder = '$newSocialSite' , status = '$newSocialSiteStatus' WHERE id = '$socialSID'") or die(mysqli_error($this->db));
			if($updateSSite){
                return true;
			}else{
				return false;
			}
		}
	}
	/*Delete question*/
	public function iN_DeleteSocialSite($userID, $ssID) {
		if ($this->iN_CheckIsAdmin($userID) == 1 && $this->iN_CheckSocialSiteIdExist($ssID) == 1) {
			mysqli_query($this->db, "DELETE FROM i_social_networks WHERE id = '$ssID'") or die(mysqli_error($this->db));
			return true;
		} else {
			return false;
		}
	}
	public function iN_ShowUserSocialSitesList($userID){
		if($this->iN_CheckUserExist($userID) == 1){
            $query = mysqli_query($this->db, "SELECT * FROM i_social_networks WHERE status = 'yes' ORDER BY id") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}else{
		   return false;
		}
	}
	public function iN_GetUserProfileLinkDetails($userID, $sID){
		if($this->iN_CheckUserExist($userID) == 1 && $this->iN_CheckSocialSiteIdExist($sID) == 1){
            $query = mysqli_query($this->db,"SELECT * FROM i_social_user_profiles WHERE isw_id_fk = '$sID' AND uid_fk = '$userID'") or die(mysqli_error($this->db));
			$data = mysqli_fetch_array($query, MYSQLI_ASSOC);
			if($data){
				return $data;   
			}else{
				return false;
			}
		}
	}
	/*Show User Socials*/
	public function iN_ShowUserSocialSites($userID){
		if($this->iN_CheckUserExist($userID) == 1){
            $query = mysqli_query($this->db, "SELECT S.* , U.*
			FROM i_social_user_profiles S FORCE INDEX(ixSocialLink)
			    INNER JOIN i_social_networks U FORCE INDEX(ixLinks)
		    ON S.isw_id_fk = U.id AND U.status = 'yes' 
			WHERE S.uid_fk = '$userID' ORDER BY U.id") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			if (!empty($data)) {
				return $data;
			}
		}else{
		   return false;
		}
	}
	public function iN_IsUrl($uri) {
		if (empty($uri)) {
			return false;
		}
		if (filter_var($uri, FILTER_VALIDATE_URL)) {
			return true;
		}
		return false;
	} 
	/*All User Storie Posts*/
	public function iN_SuggestedProductWidget($showingPost) {  
		$showingPosts = mysqli_real_escape_string($this->db, $showingPost); 
		 
		$data = null; 
		/**/
		$query = mysqli_query($this->db, "SELECT A.*
			FROM (SELECT A.*
					FROM  i_user_product_posts A
					WHERE pr_status IN('1')
					ORDER BY pr_id DESC
					LIMIT 10
					) A
				ORDER BY RAND() 
				LIMIT 4") or die(mysqli_error($this->db));
			while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
				// Store the result into array
				$data[] = $row;
			}
			if (!empty($data)) {
				// Store the result into array
				return $data;
			}
	}
}
?>
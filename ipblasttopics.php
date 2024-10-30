<?php
/*
Plugin Name: Ipb Last Topics    
Plugin URI: http://wordpress.org/extend/plugins/ipb-last-topics/
Description: Show the last posts of ipb forum  
Version: 1.0
Author: Mahdi Khaksar
Author URI: http://www.progpars.com
License: iwordpress.ir
*/
define( 'MYPLUGINNAME_PATH', plugin_dir_path(__FILE__) );

load_plugin_textdomain('ipb','wp-content/plugins/ipb-last-topics/langs');
//require ipb_config.php
if(file_exists(MYPLUGINNAME_PATH .'/ipb_config.php')){
	require(MYPLUGINNAME_PATH .'/ipb_config.php');
}
//plugin
function lasttopics()
{
	//global variable
	global $mysql_connect,$wpdb,$ipb_mysqlquery,$row,$plugin_name,$ipburl,$dbhost,$dbname,$dbuser,$dbpass,$dbprifix,$limit;
	
	//database connect and query
	$mysql_connect = mysql_connect($dbhost,$dbuser,$dbpass) or die("" . __('Error communicating with the database', 'ipb') . "");
	mysql_select_db($dbname) or die("" . __('Error communicating with the database', 'ipb') . "");
	mysql_query("SET NAMES 'latin1_swedish_ci'", $mysql_connect); 
	mysql_query("SET character_set_connection = 'latin1_swedish_ci'", $mysql_connect);

//html 
	$currentlang = get_bloginfo('language');
if($currentlang=="fa-IR")
{
	echo '<!doctype html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'. __('Recent Forum Posts', 'ipb') .'</title>	
	<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/'. basename(dirname(__FILE__)) .'/ipblasttopics_css_rtl.css" />
	</head>
	<body>
	<div class="ForumLastTopic">
		  <div class="Head">
		   <span class="col1">'. __('Title Latest Posts Forum', 'ipb') .'</span>
			<span class="col2">'. __('Reply', 'ipb') .'</span>
			 <span class="col3">'. __('Visit', 'ipb') .'</span>
			  <span class="col4">'. __('Last Post', 'ipb') .'</span>
			<div class="Clear"></div>
		  </div>
		  <div id="MTForumBlock">
		   <table cellspacing="1" cellpadding="0" class="Forumsbox">
						<tbody>';
	$ipb_mysqlquery = mysql_query("SELECT tid,title,posts,starter_id,start_date,last_poster_id,last_post,starter_name,last_poster_name,views,title_seo FROM ".$dbprifix."topics ORDER BY last_post DESC LIMIT $limit");
	
	while($row = mysql_fetch_array($ipb_mysqlquery)) {

	echo "
			<tr>
				<td class=\"col1\"><img class=\"titleicon\" src='" . get_bloginfo('wpurl') . '/wp-content/plugins/'. basename(dirname(__FILE__)) ."/images/topic.png' /><a class=\"titlelinks\" href=\"".$ipburl."/index.php?showtopic=".$row['tid']."\" target=\"_blank\" >".$row['title']."</a></td>
				<td class=\"col2\">".$row['posts']."</td>
				<td class=\"col3\">".$row['views']."</td>
				<td class=\"col4\">".$row['last_poster_name']."</td>
			</tr>";
	}

	echo "
		</tbody>
		  </table>
		</div>
	</div>
	</body>
	</html>";
}
else
{
	echo '<!doctype html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'.__('Recent Forum Posts', 'ipb').'</title>	
	<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/'. basename(dirname(__FILE__)) .'/ipblasttopics_css_ltr.css" />
	</head>
	<body>
	<div class="ForumLastTopic">
		  <div class="Head">			 
		   <span class="col4">'. __('Last Post', 'ipb') .'</span>
		     <span class="col3">'. __('Visit', 'ipb') .'</span>
			<span class="col2">'. __('Reply', 'ipb') .'</span>
		    <span class="col1">'. __('Title Latest Posts Forum', 'ipb') .'</span>
			<div class="Clear"></div>
		  </div>
		  <div id="MTForumBlock">
		   <table cellspacing="1" cellpadding="0" class="Forumsbox">
						<tbody>';
	$ipb_mysqlquery = mysql_query("SELECT tid,title,posts,starter_id,start_date,last_poster_id,last_post,starter_name,last_poster_name,views,title_seo FROM ".$dbprifix."topics ORDER BY last_post DESC LIMIT $limit");
	
	while($row = mysql_fetch_array($ipb_mysqlquery)) {

	echo "
			<tr>
				<td class=\"col1\"><img class=\"titleicon\" src='" . get_bloginfo('wpurl') . '/wp-content/plugins/'. basename(dirname(__FILE__)) ."/images/topic.png' /><a class=\"titlelinks\" href=\"".$ipburl."/index.php?showtopic=".$row['tid']."\" target=\"_blank\" >".$row['title']."</a></td>
				<td class=\"col2\">".$row['posts']."</td>
				<td class=\"col3\">".$row['views']."</td>
				<td class=\"col4\">".$row['last_poster_name']."</td>
			</tr>";
	}

	echo "
		</tbody>
		  </table>
		</div>
	</div>
	</body>
	</html>";
}
	}
add_shortcode('lasttopics','lasttopics');

//plugin admin options
function admin_options_lasttopics()
{
	$plugin_name = MYPLUGINNAME_PATH .'/panel_ipblasttopics.php';
	if(is_admin())
	{
		add_menu_page(''. __(' Latest Posts Forum Ipb', 'ipb') .'', ''. __('IPB', 'ipb') .'', 'administrator',$plugin_name,'',plugins_url('images/icon.png',__FILE__),26);
	}
	
}
add_action('admin_menu', 'admin_options_lasttopics');
?>
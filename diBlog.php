<?php
$start_time = microtime(true);
// diBlog v0.7
//---------------------------------------------------------------------------------------------------
// Developed by CrossTechnical, LLC. - http://crosstechnical.net - team@crosstechnical.net
//---------------------------------------------------------------------------------------------------
// ---Description:
// Single file drop-in blog script complete with commenting and rss2 support.
// ---Requirements:
// Standard LAMP server with PHP5+ and a mySQL database.
// ---Install:
// Create an emptey mysql database, fill out the configuration information below, then just drop this
// file in a folder on a live webserver and visit it with a browser :-)
// ---Notes:
// - Fill in h2/h3_script with the locations of 2 copies of our diHeaders script.
// - Just leave h2_script and h3_script blank to turn off image header generation.
// - CSS controls are currently as follows:
//   #blog, #blog h2, #blog h3, #blog.preview, #blog.preview.date, #blog.preview.tags, #blog.post,
//   #blog.post.date, #blog.post.tags, #blog.comment, #blog.comment.name-date, #blog.comment.url
/////////////////////////////////////////////////////////////////////////////////////////////////////
$page_header    = "";                                // optional file to replace built-in header
$page_footer    = "";                                // optional file to replace built-in footer
$blog_title     = "MyInterblog";                     // blog title
$blog_username  = "username";                        // username for blog admin
$blog_password  = "password";                        // password for blog admin
$blog_tagline   = "This is serious business.";       // tagline, description, etc of the blog
$blog_lang      = "en-us";                           // ISO-639 language code for blog
$passwordsalt   = "salt";                            // random garbage, please change this
$db_username    = "mysqlusername";                   // username for MySQL
$db_password    = "mysqlpassword";                   // password for MySQL
$db_server      = "localhost";                       // MySQL server (usually localhost)
$db_name        = "mysqlblogdatabase";               // name of database
$install        = "no";                              // set this to yes to force database table setup
$per_page       = "10";                              // posts per page
$preview_max    = "50";                              // maximum words allowed in previews
$offset         = "4";                               // number of spaces to offset blog html output
$diFonts        = "off";                             // Allow use of diFonts scripts
$difonts_script = "images/gen.php";                  // location of diFonts script
$headergen      = "off";                             // Generate headers on posts.
//////////////////////////////////////////////////////////////////////////////////////////////////////


function viewCSS() { // built-in css file. You can include into a custom header as  http://yoursite.com/this_script/built-in.css
  header("Content-type: text/css");
  echo "*, body {\n";
  echo "  margin: 0;\n";
  echo "  padding: 0;\n";
  echo "  position: static;\n";
  echo "  background: transparent;\n";
  echo "  color:#000;\n";
  echo "  font:100% \"Lucida Grande\", Arial, Helvetica, Verdana, sans-serif;\n";
  echo "  line-height:1.2em;\n";
  echo "}\n";
  echo "html, body {\n";
  echo "  height: 100%\n";
  echo "}\n";
  echo "#wrapper {\n";
  echo "  position:relative;\n";
  echo "  min-height:100%;\n";
  echo "  width: 760px;\n";
  echo "  margin: 0 auto -60px;\n";
  echo "  text-align:left;\n";
  echo "  border-left:1px black solid;\n";
  echo "  border-right:1px black solid;\n";
  echo "}\n";
  echo "#header {\n";
  echo "  background: #CCC url('/images/header.jpg') top center no-repeat;\n";
  echo "  margin:0 auto;\n";
  echo "  height:245px;\n";
  echo "  border-bottom:1px black solid;\n";
  echo "  overflow:none;\n";
  echo "  }\n";
  echo "#navigation {\n";
  echo "  width:200px;\n";
  echo "  background:#fff;\n";
  echo "  float:right;\n";
  echo "  border:1px black solid;\n";
  echo "  padding:20px;\n";
  echo "  margin-top:20px;\n";
  echo "  margin-right:20px;\n";
  echo "  margin-left:20px;\n";
  echo "}\n";
  echo "#navigation ul {\n";
  echo "  list-style-type:none;\n";
  echo "}\n";
  echo "  #tags,#recent_comments{\n";
  echo "  float:left;\n";
  echo "  margin-left:20px;\n";
  echo "  text-align:center;\n";
  echo "}\n";
  echo "#recent_comments a{\n";
  echo " border-bottom:1px black dashed;\n";
  echo "}\n";
  echo "#recent_comments p{\n";
  echo "  font-size:80%;\n";
  echo "  line-height:1.4em;\n";
  echo "  margin-bottom:-5px;\n";
  echo "}\n";
  echo "#tags a{\n";
  echo "  text-decoration:none;\n";
  echo "}\n";
  echo "#tags span           { padding:5px; float:left;     }\n";
  echo "#tags span.first a   { color:#000; font-size:2.6em; }\n";
  echo "#tags span.second a  { color:#111; font-size:2.4em; }\n";
  echo "#tags span.third a   { color:#222; font-size:2.2em; }\n";
  echo "#tags span.fourth a  { color:#333; font-size:2em;   }\n";
  echo "#tags span.fifth a   { color:#444; font-size:1.8em; }\n";
  echo "#tags span.sixth a   { color:#555; font-size:1.6em; }\n";
  echo "#tags span.seventh a { color:#666; font-size:1.4em; }\n";
  echo "#tags span.eighth a  { color:#777; font-size:1.2em; }\n";
  echo "#tags span.ninth a   { color:#888; font-size:1em;   }\n";
  echo "#tags span.tenth a   { color:#999; font-size:0.8em; }\n";
  echo "p.post_preview_date {\n";
  echo "  font-style:italic;\n";
  echo "}\n";
  echo "#content {\n";
  echo "  text-align: justify;\n";
  echo "  padding-bottom:130px;\n";
  echo "}\n";
  echo "#footer {\n";
  echo "  position:relative;\n";
  echo "  margin:0 auto;\n";
  echo "  width:760px;\n";
  echo "  height:60px;\n";
  echo "  padding-top:30px;\n";
  echo "  background: #FFF url('/images/footer.jpg') top center no-repeat;\n";
  echo "  font-size:80%;\n";
  echo "  text-align:center;\n";
  echo "  line-height:0.7em;\n";
  echo "  border-top:1px black solid;\n";
  echo "}\n";
  echo "#footer a, #content a {\n";
  echo "  text-decoration:none;\n";
  echo "  color: #222;\n";
  echo "}\n";
  echo "#footer a:visited, #content a:visited {\n";
  echo "  color: #222;\n";
  echo "}\n";
  echo "#footer a:hover, #content a:hover {\n";
  echo "  color: #333;\n";
  echo "}\n";
  echo ".text-based_only {\n";
  echo "  display:none;\n";
  echo "}\n";
}


if ($diFonts == "on"){ //Adds support for the custom header generation script. See our other project!
  require_once('images/gen.php');
}

function redirect($url){ // A three stage method of making sure virtually any browser redirects.
  global $http_path;
	if (!headers_sent()){
    header('Location: '.$http_path.$url); exit;
  } else {
    echo '<script type="text/javascript">window.location.href="'.$http_path.$url.'";</script>';
    echo '<noscript><meta http-equiv="refresh" content="0;url='.$http_path.$url.'" /></noscript>';
    exit;
  }
}

function mysqlsanitize(&$array) { // Clean mysql input
  foreach ($array as &$data) {
    if (!is_array($data)) { // If it's not an array, clean it
      trim($data);
      mysql_real_escape_string($data);
    } else { // If it IS an array, call the function on it
      mysqlsanitize($data);
    }
  }
}

function phpsanitize(&$array) { // Clean PHP POST input.
  foreach ($array as &$data) {
    if (!is_array($data)) { // If it's not an array, clean it
      str_replace("'", '&#38;', $data);
      trim($data);
      stripslashes($data);
    } else { // If it IS an array, call the function on it
      phpsanitize($data);
    }
  }
}

function countComments($post_id){ // Count all comments for a given post
  if ($commentslist = mysql_query("SELECT comment_id FROM comments WHERE comment_post='$post_id'")) {
    $comment_count = mysql_num_rows($commentslist);
  } else {
    $comment_count = 0;
  }
  return $comment_count;
}

function viewPage($pagenum){ // Output paginated lists of posts with comment counts and tags
  global $per_page, $install, $diFonts, $http_path;
  $sel_offset = (($pagenum-1)*$per_page) . "," . ($pagenum*$per_page-1);
	$db_has_posts = false;
  if (($blog_query = mysql_query('SELECT * FROM posts ORDER BY post_date DESC LIMIT ' . $sel_offset)) && $install = "no") {
    while ($current_row = mysql_fetch_array($blog_query)) {
			$db_has_posts = true;
      echo "<div class=\"post_preview\">\n";
      echo "  <h2><a href=\"".$http_path.$current_row['post_permalink']."\">";
      if ($diFonts == "on") {
        diFonts($current_row['post_title'],"h2");
      } else {
        echo $current_row['post_title'];
      }
      echo "</a></h2>\n";
      echo "  <p class=\"post_preview_date\">".date('D, d M Y H:i',strtotime($current_row['post_date']))."</p>\n";
      echo "  <div class=\"post_preview\">".$current_row['post_prev']."</div>\n";
      echo "  <p class=\"post_comment_count\"><a href=\"".$http_path.$current_row['post_permalink'];
      $comment_count = countComments($current_row['post_id']);
      if ($comment_count == 0) {
        echo "#new_comment\">No comments";
      } elseif ($comment_count == 1) {
        echo "#comments\">".$comment_count." comment";
      } else {
        echo "#comments\">".$comment_count." comments";
      }
      echo "</a> - Tags: ";
      if ($current_row['post_tags']) {
        $post_tags = explode(",", $current_row['post_tags']);
        while ($post_tags) {
          $curr_tag = trim(array_shift($post_tags));
          if ($post_tags[0]) echo " <a href=\"".$http_path."tag/".$curr_tag."\" class=\"post_tag\">".$curr_tag."</a>, ";
          else echo " <a href=\"".$http_path."tag/".$curr_tag."\" class=\"post_tag\">".$curr_tag."</a>";
        }
      }
      echo "</p>\n";
      echo "</div>\n";
    }
		if (!$db_has_posts) {
			redirect("admin");
		}
    // fixme: This is an ugly, ugly way to create the tables. Figure out a better way. fixme
  } elseif (mysql_query ('CREATE TABLE posts (post_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,post_permalink CHAR(70),post_date DATETIME NOT NULL,post_title TINYTEXT NOT NULL,post_prev TEXT NOT NULL,post_body TEXT NOT NULL,post_tags TINYTEXT )')) {
    if (mysql_query('CREATE TABLE comments (comment_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,comment_date DATETIME NOT NULL,comment_name TINYTEXT NOT NULL,comment_subject TINYTEXT NOT NULL,comment_email TINYTEXT,comment_url TINYTEXT,comment_text TEXT NOT NULL,comment_post INT UNSIGNED NOT NULL)')) {
      echo "Error creating comments table." . mysql_error();
    }
    echo "<em>Database created</em>";
  } else {
    die("Could not parse or create posts table. Check database for sanity. Error: " . mysql_error());
  }
}


function viewTag($tag) { // Generate a list of posts that contain a given tag.
  // Just a note: Finding a way to put the output code in its own function could clean up this and viewPage. TODO
  global $diFonts, $http_path;
  if ($blog_query = mysql_query('SELECT * FROM posts WHERE post_tags LIKE "%'.$tag.'%" ORDER BY post_date DESC')) { // This won't scale well until post_tags is indexed.
    while ($current_row = mysql_fetch_array($blog_query)) {
      echo "<div class=\"post_preview\">\n";
      echo "  <h2><a href=\"".$http_path.$current_row['post_permalink']."\">";
      if ($diFonts == "on") {
        diFonts($current_row['post_title'],"h2");
      } else {
        echo $current_row['post_title'];
      }
      echo "</a></h2>\n";
      echo "  <p class=\"post_preview_date\">".date('D, d M Y H:i',strtotime($current_row['post_date']))."</p>\n";
      echo "  <div class=\"post_preview\">".$current_row['post_prev']."</div>\n";
      echo "  <p class=\"post_comment_count\"><a href=\"".$http_path.$current_row['post_permalink'];
      $comment_count = countComments($current_row['post_id']);
      if ($comment_count == 0) {
        echo "#new_comment\">No comments";
      } elseif ($comment_count == 1) {
        echo "#comments\">".$comment_count." comment";
      } else {
        echo "#comments\">".$comment_count." comments";
      }
      echo "</a> -";
      $post_tags = explode(",", $current_row['post_tags']);
      while ($post_tags) {
        $curr_tag = trim(array_shift($post_tags));
        if ($post_tags[0]) echo " <a href=\"".$http_path."tag/".$curr_tag."\" class=\"post_tag\">".$curr_tag."</a>, ";
        else echo " <a href=\"".$http_path."tag/".$curr_tag."\" class=\"post_tag\">".$curr_tag."</a>";
      }
      echo "</p>\n";
      echo "</div>\n";
    }
  } else {
    echo "Something went wrong in the mysql search. You shouldn't see this. Mail us about it, please.";
  }
}

function viewSitemap(){
  header("Content-Type: application/xml; charset=UTF-8");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";
  if ($blog_query = mysql_query('SELECT * FROM posts ORDER BY post_date')) {
    while ($current_row = mysql_fetch_assoc($blog_query)) {
      echo "  <url>\n";
      echo "    <loc>".$http_path."".$current_row['post_permalink']."</loc>\n";
      echo "    <lastmod>".date('Y-m-d\TH:i:sP',strtotime($current_row['post_date']))."</lastmod>\n";
      echo "    <changefreq>weekly</changefreq>\n";
      echo "  </url>\n"; 
    }
  }
  echo "</urlset>\n";
}

function viewRSS(){ //This provides all of the output for the virtual rss.xml file
  global $blog_title, $blog_tagline, $blog_lang, $http_path;
  header("Content-Type: application/xml; charset=UTF-8");
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  echo "<rss version=\"2.0\"\n";
  echo "        xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"\n";
  echo "        xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"\n";
  echo "        xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n";
  echo "        xmlns:atom=\"http://www.w3.org/2005/Atom\"\n";
  echo "        xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"\n";
  echo ">\n";
  echo "  <channel>\n";
  echo "    <title>".$blog_title."</title>\n";
  echo "    <link>".$http_path."</link>\n";
  echo "    <description>".$blog_tagline."</description>\n";
  echo "    <language>".$blog_lang."</language>\n";
  echo "    <atom:link href=\"".$http_path."rss.xml\" rel=\"self\" type=\"application/rss+xml\" />\n";
  if ($blog_query = mysql_query('SELECT * FROM posts ORDER BY post_date DESC LIMIT 10')) {
    while ($current_row = mysql_fetch_assoc($blog_query)) {
      echo "  <item>\n";
      echo "    <title>".$current_row['post_title']."</title>\n";
      echo "    <link>".$http_path."".$current_row['post_permalink']."</link>\n";
      echo "    <pubDate>".date('D, d M Y H:i:s T',strtotime($current_row['post_date']))."</pubDate>\n";
      echo "    <description>".$current_row['post_prev']."</description>\n";
      echo "  </item>\n";
    }
  }
  echo "</channel>\n";
  echo "</rss>";
}

function viewPost($permalink){ //When passed the permalink form of a post title, will output the post.
  global $headergen, $diFonts, $http_path;
  if ($postslist = mysql_query("SELECT post_date,post_title,post_body,post_tags,post_id FROM posts WHERE post_permalink='$permalink'")) {
    $curr_post = mysql_fetch_assoc($postslist);
    $post_id = $curr_post['post_id'];
    if ($headergen == "on") {
    echo "<h2>";
      if ($diFonts == "on") {
        diFonts($curr_post['post_title'], "h2");
      } else {
        echo $curr_post['post_title'];
      }
    echo "</h2>\n";
    }
    echo "<p class=\"blog_entry_date\"><em>Posted on ".date('D, d M Y H:i:s T',strtotime($curr_post['post_date']))."</em></p>\n";
    echo "<div class=\"blog_entry_body\">".$curr_post['post_body']."</div>\n";
    if ($commentlist = mysql_query("SELECT comment_id,comment_date,comment_subject,comment_name,comment_text,comment_email,comment_url FROM comments WHERE comment_post='$post_id' ORDER BY comment_date DESC")) {
      if (mysql_num_rows($commentlist) >=1) {
        echo "<div class=\"blog_comment_display\">\n";
        echo "<h2>";
        if ($diFonts == "on") {
          diFonts("Current Comments:", "h2");
        } else {
          echo "Current Comments:";
        }
        echo "</h2>\n";
        while ($current_comment = mysql_fetch_assoc($commentlist)) {
          echo "<div>\n";
          echo "<h3><a name=\"cid_".$current_comment['comment_id']."\">";
          if ($diFonts == "on") {
            diFonts($current_comment['comment_subject'], "h3");
          } else {
            echo $current_comment['comment_subject'];
          }
          echo "</a></h3>";
          echo "<p class=\"comment_name-date\"> by ";
          if ($current_comment['comment_email']) echo "<a href=\"mailto:".$current_comment['comment_email']."\">";
          echo $current_comment['comment_name'];
          if ($current_comment['comment_email']) echo "</a>";
          echo " on ".date('D, d M Y H:i:s T',strtotime($current_comment['comment_date']))."</p>\n";
          echo "<p class=\"body\">".$current_comment['comment_text']."</p>\n";
          if ($current_comment['comment_url']) echo "<p class=\"comment_url\">URL: <a href=\"".$current_comment['comment_url']."\">".$current_comment['comment_url']."</a></p>\n";
          echo "</div>\n";
        }
				echo "</div>\n";
      }
    } else {
      die("Error displaying comments." . mysql_error());
    }

  } else {
    echo "Error fetching posts: " . mysql_error();
  }
}

function listPosts(){ // Return a list of posts. This is used in the admin panel.
	global $http_path;
  if ($postslist = mysql_query('SELECT post_title,post_id FROM posts')) {
    echo "<p>Edit or delete an existing post:</p>\n";
    echo "<ul>";
    while ($cur_row = mysql_fetch_assoc($postslist)) {
      echo "<li>Title: \"".$cur_row['post_title']."\"";
      echo "<a href=\"".$http_path."admin/edit/post/".$cur_row['post_id']."\"> edit</a>";
      echo "<a href=\"".$http_path."admin/delete/post/".$cur_row['post_id']."\"> delete</a>";
      echo "</li><br>\n";
    }
    echo "</ul>";
  } else {
    mysql_error();
  }
}

function listComments($post_id){ // Return a list of comments. This is used in the admin panel.
	global $http_path;
  if ($commentslist = mysql_query("SELECT comment_subject,comment_name,comment_id FROM comments WHERE comment_post='$post_id'")) {
    echo "<p>Edit or delete an existing comment:</p>\n<ul>\n";
    while ($cur_row = mysql_fetch_assoc($commentslist)) {
      echo "<li>Subject: \"".$cur_row['comment_subject']."\" Posted by: \"".$cur_row['comment_name']."\"";
      echo "<a href=\"".$http_path."admin/edit/comment/".$cur_row['comment_id']."\"> edit</a>";
      echo "<a href=\"".$http_path."admin/delete/comment/".$cur_row['comment_id']."\"> delete</a>";
      echo "</li><br>\n";
    } 
    echo "</ul>\n";
  } else {
    die("Could not list comments" . mysql_error());
  }
}

function viewArchives() {
  global $install, $diFonts, $http_path;
  if (($blog_query = mysql_query('SELECT * FROM posts ORDER BY post_date DESC')) && $install = "no") {
    while ($current_row = mysql_fetch_array($blog_query)) {
      $post_date = explode("-", $current_row['post_date']);
      if ($post_date[0] != $current_year) {
        if ($current_year) { echo "</ul>\n"; }
        $current_year = $post_date[0];
        $current_month = $post_date[1];
        echo "<h3>";
        if ($diFonts == "on") {
          diFonts($current_year,"h3", NULL ,"archives_h3");
        } else {
          echo "$current_year";
        }
        echo "</h3>\n";
        echo "  <ul>\n";
        echo "    <li><h4>".date("F", strtotime("2008-".$current_month."-01"))."</h4>\n";
        echo "      <ul>\n";
      } elseif ($current_year == $post_date[0] && $current_month != $post_date[1]) {
        if ($current_month) { echo "</ul>\n"; }
        $current_month = $post_date[1];
        echo "  <li><h4>".date("F", strtotime("2008-".$current_month."-01"))."</h4>\n";
        echo "<ul>\n";
      } 
      echo "<li>".date("jS", strtotime($current_row['post_date']))." - <a href=\"".$http_path.$current_row['post_permalink']."\">".$current_row['post_title']."</a></li>\n";
    }
    echo "</ul>\n</ul>\n";
  }
}

function deletePost($post_id){ // Delete a given post from database.
	global $http_path;
  if (!$post_to_delete = mysql_query("SELECT post_title FROM posts WHERE post_id='$post_id'")){
    die("Could not find a title to match the post with an id of $post_id: ".mysql_error());
  } else {
    $post_title = mysql_result($post_to_delete,0);
  }
  if ( $_POST['delete'] == "no" ) {
    redirect('admin');
  } 
  if ( $_POST['delete'] == "yes" ) {
    if (!mysql_query("DELETE FROM posts WHERE post_id='$post_id'")) {
      die("Could not delete post with an id of $post_id: ".mysql_error());
    }
    mysql_query("DELETE FROM comments WHERE comment_post='$post_id'");
    echo "<p>".$post_title." has been successfully deleted from the database</p>\n";
  } else {
    echo "<form method=\"POST\" action=\"".$http_path."admin/delete/post/$post_id\" >\n";
    echo "<p>Are you sure you want to delete the post titled <em>$post_title</em> and any associated comments?<p>\n";
    echo "<input type=\"submit\" name=\"delete\" value=\"yes\">\n";
    echo "<input type=\"submit\" name=\"delete\" value=\"no\">\n";
    echo "</form>\n";
  }
}

function deleteComment($comment_id){ // Delete a given comment form the database.
  if ($find_post_id = mysql_query("SELECT comment_post FROM comments WHERE comment_id='$comment_id'")) {
    $post_id = mysql_result($find_post_id,0);
  } else {
    die("Could not find comment with an id of $comment_id: ".mysql_error());
  }
  if (mysql_query("DELETE FROM comments WHERE comment_id='$comment_id'")) {
    redirect("admin/edit/post/".$post_id."");
  } else {
    die("Could not delete post with an id of $post_id: ".mysql_error());
  }
} 

function loginForm($message="Please log in:"){ // Display admin panel login form.
	global $http_path;
  echo "<form method=\"POST\" action=\"".$http_path."admin\"><p>$message</p>\n";
  echo "<p>Username: <input type=\"text\" name=\"username\" size=\"16\"></p>\n";
  echo "<p>Password: <input type=\"password\" name=\"password\" size=\"16\"></p>\n";
  echo "<input type=\"submit\" value=\"submit\" >\n</form>\n<div>";
}

function commentForm($permalink = NULL, $comment_id = NULL) { // Display form to make or edit a comment.
  global $diFonts, $http_path;
  if($comment_id){
    if ($cid_query = mysql_query("SELECT comment_name,comment_email,comment_url,comment_date,comment_subject,comment_text,comment_id,comment_post FROM comments WHERE comment_id='$comment_id'")) {
      $fetch_results = mysql_fetch_assoc($cid_query);
      $c_name    = $fetch_results['comment_name'];
      $c_email   = $fetch_results['comment_email'];
      $c_url     = $fetch_results['comment_url'];
      $c_date    = $fetch_results['comment_date'];
      $c_subject = $fetch_results['comment_subject'];
      $c_text    = $fetch_results['comment_text'];
      $c_id      = $fetch_results['comment_id'];
      $c_post    = $fetch_results['comment_post'];
    } else {
      die("Unable to look up comment with an id of \"$comment_id\": " . mysql_error());
		}
	} elseif($_POST) {
		phpsanitize($_POST);
		if ( !$_POST['comment_human'] == "yes" ) {
			sleep(20);
			echo "<a href=\"".$_SERVER['HTTP_HOST']."\">Comment posted to /dev/null. Pass the human check next time.</a>";
		} else {
			if ( $_POST['comment_name'] )    $c_name    = $_POST['comment_name'];
			if ( $_POST['comment_email'] )   $c_email   = $_POST['comment_email'];
			if ( $_POST['comment_url'] )     $c_url     = $_POST['comment_url'];
			if ( $_POST['comment_date'] )    $c_date    = $_POST['comment_date'];
			if ( $_POST['comment_subject'] ) $c_subject = $_POST['comment_subject'];
			if ( $_POST['comment_text'] )    $c_text    = $_POST['comment_text'];
			if ( $_POST['comment_id'] )      $c_id      = $_POST['comment_id'];
			if ( $_POST['comment_post'] )    $c_post    = $_POST['comment_post'];
		}
	} else {
    if ($postslist = mysql_query("SELECT post_id FROM posts WHERE post_permalink='$permalink'")) {
      $curr_post = mysql_fetch_assoc($postslist);
      $c_post = $curr_post['post_id'];
    } else {
      die("Unable to fetch post id for \"$permalink\" :" . mysql_error());
    }
  }
  if ( $_POST['comment_human'] == "yes" && $_POST['comment_subject'] && $_POST['comment_text'] ) {
    $c_date = date("Y-m-d H:i:s");
    $mysql_input = array($c_name,$c_email,$c_url,$c_date,$c_subject,$c_text,$c_id,$c_post);
    mysqlsanitize($mysql_input);
    if (!mysql_query("INSERT comments (comment_name,comment_email,comment_url,comment_date,comment_subject,comment_text,comment_id,comment_post)
          VALUES (
            '".$mysql_input[0]."',
            '".$mysql_input[1]."',
            '".$mysql_input[2]."',
            '".$mysql_input[3]."',
            '".$mysql_input[4]."',
            '".$mysql_input[5]."',
            '".$mysql_input[6]."',
            '".$mysql_input[7]."'
            ) ON DUPLICATE KEY UPDATE
          comment_name='".$mysql_input[0]."',
          comment_email='".$mysql_input[1]."',
          comment_url='".$mysql_input[2]."',
          comment_date='".$mysql_input[3]."',
          comment_subject='".$mysql_input[4]."',
          comment_text='".$mysql_input[5]."',
          comment_id='".$mysql_input[6]."',
          comment_post='".$mysql_input[7]."'")) {
      die("Could not update comment with an id of \"$c_id\" :" . mysql_error());
  }
  }
  if ($c_id){
    echo "<h2>";
    if ($diFonts == "on" ) {
      diFonts("Editing comment: $c_id: $c_subject by $c_name", "h2");
    } else {
      echo "Editing comment: $c_id: $c_subject by $c_name";
    }
    echo "</h2>";
  } else {
    echo "<h2>";
    if ($diFonts == "on") {
      diFonts("Make a Comment:", "h3");
    } else {
      echo "Make a Comment:";
    }
    echo "</h2>";
  }
  echo "<div class=\"blog_comment_form\">\n";
  echo "<form method=\"POST\" action=\"";
  if ($c_id){
    echo $http_path."admin/edit/comment/$c_id";
  } else {
    echo $http_path."".$permalink;
  }
  echo "\">\n";
  echo "<p><label>Name:</label><input type=\"text\" name=\"comment_name\" value=\"".htmlentities($c_name)."\" size=\"30\"></p>\n";
  echo "<p><label>Email:</label><input type=\"text\" name=\"comment_email\" value=\"".htmlentities($c_email)."\" size=\"30\"></p>\n";
  echo "<p><label>URL:</label><input type=\"text\" name=\"comment_url\" value=\"".htmlentities($c_url)."\" size=\"30\">\n";
  echo "<input type=\"hidden\" name=\"comment_date\" value=\"".htmlentities($c_date)."\"></p>\n";
  echo "<p><label>Subject:</label><input type=\"text\" name=\"comment_subject\" value=\"".htmlentities($c_subject)."\" size=\"30\"></p>\n";
  echo "<p><label>Body:</label><textarea cols=\"40\" rows=\"5\" name=\"comment_text\">".htmlentities($c_text)."</textarea>\n";
	echo "<p><label>Enter \"yes\" if you are a human:</label><input type=\"text\" name=\"comment_human\" size=\"10\"></p>\n";
  echo "<input type=\"hidden\" name=\"comment_id\" value=\"$c_id\" >\n";
  echo "<input type=\"hidden\" name=\"comment_post\" value=\"".htmlentities($c_post)."\" ></p>\n";
  echo "<p><input class=\"submit\" type=\"submit\" value=\"submit\" size=\"30\"></p>\n";
  echo "</form>\n";
  echo "</div>\n";
}

function postForm($post_id = NULL) { // Display form to create a new post, or to edit an existing one.
  global $preview_max, $http_path;
  if($post_id){
    if ($pid_query = mysql_query("SELECT post_title,post_date,post_permalink,post_body,post_prev,post_tags FROM posts WHERE post_id='$post_id'")) {
      $fetch_results = mysql_fetch_assoc($pid_query);
      $p_title = $fetch_results['post_title'];
      $p_date = $fetch_results['post_date'];
      $p_permalink = $fetch_results['post_permalink'];
      $p_body = $fetch_results['post_body'];
      $p_preview = $fetch_results['post_prev'];
      $p_tags = $fetch_results['post_tags'];
      $p_id = $post_id;
    } else {
      die('Looking for post ID failed: '.mysql_error());
    }
  } elseif($_POST) {
    phpsanitize($_POST);
    if ( $_POST['title'] ) $p_title = $_POST['title'];
    if ( $_POST['permalink'] ){
      $p_permalink = $_POST['permalink'];
    } else {
      $p_permalink = str_replace(" ","_", $p_title);
    }
    $p_permalink = preg_replace("/[^a-zA-Z0-9_]/","",$p_permalink);
    if ( $_POST['body'] ) $p_body = $_POST['body'];
    if ( $_POST['preview'] ){
      $p_preview = $_POST['preview'];
    } else {
      $body_words = explode(' ',$p_body);
      if(count($body_words) > $preview_max ){
        $p_preview = implode(" ", array_splice($body_words, 0, $preview_max))."...";
      }
    }
    if ( $_POST['tags'] ) $p_tags = $_POST['tags'];
    if ( $_POST['date'] ){
      $p_date = $_POST['date'];
    } else {
      $p_date = date("Y-m-d H:i:s");
    }
    if ( $_POST['id'] ) $p_id = $_POST['id'];
  }
  if ( $_POST['title'] && $_POST['body'] ) {
    $mysql_input = array($p_title,$p_permalink,$p_preview,$p_body,$p_tags,$p_date,$p_id);
    mysqlsanitize($mysql_input);
    if (mysql_query("INSERT posts (post_title,post_permalink,post_prev,post_body,post_tags,post_date,post_id)
          VALUES (
            '".$mysql_input[0]."',
            '".$mysql_input[1]."',
            '".$mysql_input[2]."',
            '".$mysql_input[3]."',
            '".$mysql_input[4]."',
            '".$mysql_input[5]."',
            '".$mysql_input[6]."'
            ) ON DUPLICATE KEY UPDATE
          post_title='".$mysql_input[0]."',
          post_permalink='".$mysql_input[1]."',
          post_prev='".$mysql_input[2]."',
          post_body='".$mysql_input[3]."',
          post_tags='".$mysql_input[4]."',
          post_date='".$mysql_input[5]."',
          post_id='".$mysql_input[6]."'")) {
      $last_post = mysql_insert_id();
    if ($last_post) $p_id = $last_post;
  } else {
    echo mysql_error();
  }
  }
  echo "<div id=\"blog_login\">\n";
  echo "<form method=\"POST\" action=\"".$http_path."admin\">\n";
  echo "<p>";
  if (!$p_title) {
    echo "Create new entry:";
  } else {
    echo "You are currently editing: \"$p_title\"<br>\n";
    echo "To start a new entry click here: <a href=\"".$http_path."admin/new\">[ New Post ]</a>";
  }
  echo "</p>\n";
  echo "<p>Title:<br><input type=\"text\" name=\"title\" size=\"50\" value=\"".stripslashes($p_title)."\"></p>\n";
  echo "<p>Date:<br><input type=\"text\" name=\"date\" size=\"20\" value=\"".stripslashes($p_date)."\"></p>\n";
  echo "<p>Permalink: (Leave blank to have one generated from title)<br>\n";
  echo "<input type=\"text\" name=\"permalink\" size=\"50\" value=\"".stripslashes($p_permalink)."\"></p>\n";
  echo "<p>Preview: ($preview_max words max. Leave blank to have one generated from body)<br>\n";
  echo "<textarea name=\"preview\" cols=\"50\" rows=\"5\">".stripslashes($p_preview)."</textarea></p>\n";
  echo "<p>Body:<br><textarea name=\"body\" cols=\"50\" rows=\"15\">".stripslashes($p_body)."</textarea></p>\n";
  echo "<p>Tags: (Comma seperated.)<br><input type=\"text\" name=\"tags\" size=\"50\" value=\"".stripslashes($p_tags)."\"></p>\n";
  echo "<input type=\"hidden\" name=\"id\" value=\"$p_id\">\n";
  echo "<input type=\"submit\" value=\"";
  if (!$p_title){ echo "Post"; } else { echo "Save"; }
  echo " Entry\" >\n";
  echo "</form>\n</div>\n";
}

function tags($max = NULL){ // Return a cloud of the $max most used tags, sized and colored from least to most occurring.
	global $http_path;
  if ( $tagquery = mysql_query("SELECT post_tags FROM posts")) {
    $tagslist = array();
    while ( $tags = mysql_fetch_assoc($tagquery) ) {
      foreach (explode(",", $tags['post_tags']) as $tag) {
        $tag = strtolower(trim($tag));
        if ( in_array($tag, array_keys($tagslist)) ) {
          $tagslist[$tag]++;
        } else {
          $tagslist[$tag] = 1;
        }
      }
    }
    $most  = max($tagslist);
    $least = min($tagslist);
    $tenpercent = ceil(($most - $least)/10);
    foreach($tagslist as $tag => $number){
       if (      $number == $most            ) $class = "first";
       else if ( $number >= ($tenpercent*9)  ) $class = "second"; 
       else if ( $number >= ($tenpercent*8)  ) $class = "third";
       else if ( $number >= ($tenpercent*7)  ) $class = "fourth"; 
       else if ( $number >= ($tenpercent*6)  ) $class = "fifth"; 
       else if ( $number >= ($tenpercent*5)  ) $class = "sixth";
       else if ( $number >= ($tenpercent*4)  ) $class = "seventh";
       else if ( $number >= ($tenpercent*3)  ) $class = "eighth";
       else if ( $number >= ($tenpercent*2)  ) $class = "ninth";
       else if ( $number >= $least           ) $class = "tenth";
       echo "<span class=\"".$class."\"><a href=\"".$http_path."tag/".$tag."\">".$tag."</a></span>";
    } 
  } else {
    echo mysql_error();
  }
}

function recentComments($max = NULL){ // Display the $max most recient comments in the database, and their corresponding post links.
	global $http_path;
	if (!$max) {
		$max = 5;
	}
  // todo - Modify this to use a join - http://www.keithjbrown.co.uk/vworks/mysql/mysql_p5.php
  // todo - This needs to actually stop at $max. - LIMIT should take care of this
  if ( $commentlist = mysql_query("SELECT comment_date,comment_subject,comment_name,comment_text,comment_email,comment_url,comment_id,comment_post FROM comments ORDER BY comment_date DESC LIMIT $max")) {
    while ($current_comment = mysql_fetch_assoc($commentlist)) {
      if ($selectpost = mysql_query("SELECT post_permalink,post_title FROM posts WHERE post_id=".$current_comment['comment_post']." LIMIT $max")) {
        if ($this_post = mysql_fetch_assoc($selectpost)) {

          echo "<p><a href=\"".$http_path.$this_post['post_permalink']."#cid_".$current_comment['comment_id']."\">\"".$current_comment['comment_subject']."\"</a> by <a href=\"mailto:".$current_comment['comment_email']."\">".$current_comment['comment_name']."</a> on \"<a href=\"".$http_path.$this_post['post_permalink']."\">".$this_post['post_title']."</a>\"</p>";
        } else {
					die(mysql_error());
				}
      } else {
				die(mysql_error());
		  }
    }
  }
}

function pageHeader() {
  global $page_header, $http_path;
  if ($page_header){
	  require($page_header);
	}	else {
    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n";
    echo "<html lang=\"en\">\n";
    echo "  <head>\n";
    echo "    <title></title>\n";
    echo "    <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" >\n";   
    echo "    <meta name=\"resource-type\" content=\"document\">\n";
    echo "    <meta http-equiv=\"pragma\" content=\"no-cache\">\n";
    echo "    <meta name=\"revisit-after\" content=\"14 days\">\n";
    echo "    <meta name=\"robots\" content=\"ALL\">\n";
    echo "    <meta name=\"distribution\" content=\"Global\">\n";
    echo "    <meta name=\"language\" content=\"English\">\n";
    echo "    <meta name=\"doc-type\" content=\"Public\">\n";
    echo "    <meta name=\"doc-class\" content=Completed\">\n";
    echo "    <meta name=\"doc-rights\" content=\"Public\">\n";   
    echo "    <link rel=\"alternate\" type=\"application/rss+xml\" title=\"RSS\" href=\"".$http_path."rss.xml\" >\n";
    echo "    <link rel=\"alternate\" type=\"application/atom+xml\" title=\"Atom\" href=\"".$http_path."atom.xml\" >\n";
    echo "    <link href=\"".$http_path."built-in.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\" >\n";
    echo "  </head>\n";
    echo "  <body>\n";
    echo "    <div id=\"wrapper\">\n";
    echo "    <div id=\"header\"></div>\n";  
    echo "    <div id=\"navigation\">\n";
    echo "      <h1 class=\"text-based_only\">Navigation</h1>\n";
    echo "      <ul>\n";
    echo "        <li>\n";
    if ($diFonts == "on") {
	    diFonts('');
		} else {
      echo "<a href=\"".$http_path."\">Blog home</a>";
		}
    echo "        </li>\n";
    echo "        <li>\n";
    if ($diFonts == "on") {
	    diFonts('');
		} else {
      echo "<a href=\"".$http_path."archives\">Archives</a>";
		}
    echo "        </li>\n";
    echo "        <li>\n";
    if ($diFonts == "on") {
	    diFonts('');
		} else {
      echo "<a href=\"\"></a>";
		}
    echo "        </li>\n";
    echo "        <li>\n";
    if ($diFonts == "on") {
	    diFonts('');
		} else {
      echo "<a href=\"\"></a>";
		}
    echo "        </li>\n";
    echo "      </ul>\n";
    echo "<div id=\"recent_comments\">";
    echo "<hr \>\n";
    echo "<h3>Recent Comments</h3>\n";
    recentComments($max);
    echo "</div>\n";
    echo "<div id=\"tags\">\n";
    echo "<hr \>\n";
    echo "  <h3>Tag Cloud</h3>\n";
    tags();
    echo "</div>\n";
    echo "    </div>\n";
    echo "    <div id=\"content\">\n";
	}
}

function pageFooter() {
  global $page_footer, $start_time;
  if ($page_footer) {
	  require($page_footer);
	}	else {
    echo "  <div id=\"footer\">\n";
		echo "    Page generated in " . round(((microtime(true) - $start_time)*1000), 2) . " milliseconds.<br>";
    echo "    <a href=\"http://jigsaw.w3.org/css-validator/check/referer\">VALID:CSS</a> |\n";
    echo "    <a accesskey=\"3\" href=\"/sources.crosstechnical.net/p/diblog\">Powered By diBlog</a> |\n";
    echo "    <a href=\"http://validator.w3.org/check/referer\">VALID:HTML</a>\n";
    echo "  </div>\n";
	  echo "</div>\n";
	  echo "</div>\n";
	  echo "</body>\n";
	  echo "</html>\n";
  }
}

if (!mysql_select_db($db_name, mysql_connect($db_server, $db_username, $db_password))) {
  if (mysql_errno() == "1044" || mysql_errno() == "1045") {
			die("Error: Incorrect login information for database ");
	} else {
			die(mysql_error());
	}
}

error_reporting(0);
$http_path = preg_replace('/\.php.*/','/',"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
$args = explode('/',stripslashes($_SERVER['PATH_INFO']));
array_shift($args);
$post_password = stripslashes($_POST['password']);
$post_username = stripslashes($_POST['username']);
if ( $post_username == $blog_username && $post_password == $blog_password ){
  $authenticated = "yes";
  setcookie('bloglogin', md5($post_password.$passwordsalt));
} else if ( !$authenticated && $_COOKIE['bloglogin'] == md5($blog_password.$passwordsalt)) {
  $authenticated = "yes";
} else if ( $args[0] == "admin" && !$authenticated) {
  if ($post_password)
    $text = "Incorrect User/pass. Please try again:";
  $page_title="Admin: Please Log-In";
  pageHeader();
  echo "<div id=\"blog\">";
  loginForm($text);
  echo "</div>";
  pageFooter();
}
if (preg_match("(blog|index)", $_SERVER['PHP_SELF'])) {
  if ($args[0] && $args[0] == "rss.xml") { //RSS doesnt need header or footer, so check for it first
    viewRSS();
  } elseif ($args[0] && $args[0] == "built-in.css") {
    viewCSS();
  } elseif ($args[0] && $args[0] == "sitemap.xml") {
    viewSitemap();
  } elseif (in_array($args[0],array("admin","page","tag","archives"))) {
    if ($authenticated && $args[0] == "admin"){
      if ($args[1] == "delete" && $args[2] == "post"){
        pageHeader();
        echo "<div id=\"blog\">";
        deletePost($args[3]);
      } elseif ($args[1] == "delete" && $args[2] == "comment"){
        pageHeader();
        echo "<div id=\"blog\">";
        deleteComment($args[3]);
      } elseif ($args[1] == "edit" && $args[2] == "post" ){
        $page_title="Admin: Editing Existing Entry";
        pageHeader();
        echo "<div id=\"blog\">";
        postForm($args[3]);
        listComments($args[3]);
      } elseif ($args[1] == "edit" && $args[2] == "comment" ){
        $page_title="Admin: Editing Existing Entry";
        pageHeader();
        echo "<div id=\"blog\">";
        commentForm(NULL, $args[3]);
      } elseif ($args[1] == "logout" ){
        $page_title="Admin: Logged Out";
        pageHeader();
        echo "<div id=\"blog\">";
        setcookie('bloglogin', 'deauthenticated');
        unset($authenticated);
        echo '<p>You are now logged out.</p>';
      } else {
        $page_title="Admin: Create New Entry";
        pageHeader();
        echo "<div id=\"blog\">";
        postForm();
        listPosts();
      }
    } else if ($args[0] == "archives") {
      pageHeader();
      echo "<div id=\"blog\">";
      viewArchives();
    } else if ($args[0] == "page") {
      pageHeader();
      echo "<div id=\"blog\">";
      viewPage($args[1]);
    } else if ($args[0] == "tag") {
      $page_title="Blog: Posts tagged with \"".$args[1]."\"";
      pageHeader();
      echo "<div id=\"blog\">";
      viewTag($args[1]);
    }
    echo "</div>";
    pageFooter();
  } elseif ($args[0]) {
    mysql_escape_string($args[0]);
    $title_query = mysql_query("SELECT post_title FROM posts WHERE post_permalink='$args[0]'");
    $title = mysql_fetch_array($title_query);
    $page_title = $title[0];
    pageHeader();
    echo "<div id=\"blog\">";
    viewPost($args[0]);
    commentForm($args[0]);
    echo "</div>";
    pageFooter();
  } elseif (!$args[0]) {
    $page_title="Blog";
    pageHeader();
    echo "<div id=\"blog\">";
    viewPage("1");
    echo "</div>";
    pageFooter();
  }
}
?>

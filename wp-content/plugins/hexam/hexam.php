<?php
/*
Plugin Name: EXAM - Online test system
Plugin URI: http://www.bionicsheep.com
Description: It lets to developer to provide online exams,quizzes and to save user result in mysql database.
Version: 1.2.4
Author: Michael Painter
Author URI: http://www.bionicsheep.com
License: GPL2
*/
/* 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
 
function hexam($content = '') {
  global $wpdb;
  global $wp_query;
    
  $replacement = '';
  $newid=1;
  include(WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__))."/content.php");
  $lefthex=strpos($content,"[exam id=");
  $righthex=strpos($content,"exam]");
  if ($lefthex!==false and $righthex!==false) {
    $newid=substr($content,$lefthex+9,$righthex-$lefthex-10);
  }
  $testnamerow=$wpdb->get_row("select testname,testtype from wp_hexam_testnames where id=".$newid);
  $testname=$testnamerow->testname;
  $testtype=$testnamerow->testtype;
  
 if ($testtype=='QUIZ' or is_user_logged_in()) {

  if (!isset($_POST["qid1"])) {
  	$replacement=$replacement.'<h3><a href="#" id="slick-slidetoggle">Take Test!</a></h3>';
  	$replacement=$replacement.'<div id="toggle-search" style="padding:10px;"><p>id='.$newid.'</p>';
    $replacement=$replacement.'<form method="post" action="" name="hexamform">';
    $testsnet=$wpdb->get_results("select * from wp_hexam_questions where testid=".$newid." order by id asc");
    $i=0;
    foreach ($testsnet as $tests) {
      $i=$i+1;
      $replacement=$replacement.$i.') <input type="hidden" name="qid'.$i.'" value="'.$tests->id.'">'.stripslashes($tests->content).'<br>';
      $answers_ed=explode("~",stripslashes($tests->answers));// echo sizeof($answers_ed);
      for ($j=1;$j<=(sizeof($answers_ed)-1);$j++) {
        $replacement=$replacement.'
        <input type="radio" name="answer_'.$i.'" value="'.$j.'">'.$answers_ed[$j];
      }
     $replacement=$replacement.'<br>';
    }
    $replacement=$replacement.'
    <br><input type="submit" name="'.$word["hsubmit"].'" value="'.$word["hsubmit"].'"> </form>';
    }
    else {
      $question_row=$wpdb->get_results("select answers,correct from wp_hexam_questions where testid=".$newid);
      $question_count=$wpdb->num_rows;
      $acount_row=$wpdb->get_row("select answers from wp_hexam_questions where testid=".$newid." limit 1");
      $answers_count=count(explode("~",$acount_row->answers))-1;
      $i=0;$point=0;
      foreach ($question_row as $tests) {
        $i=$i+1;
        if ($_POST["answer_".$i]==$tests->correct){
          $point=$point+1;
        }
     }
     if ($testnamerow->testtype=='QUIZ') {
	    $replacement= $replacement.'<b>'.$word["hscore_1"].' '.$point.' '.$word["hscore_2"].'.</b>';
     }
	 else {
	 $replacement=$replacement.'<br><b>'.$word["hrec"].'.</b>';
	 }
	 if ( is_user_logged_in() ) {
	      $wpdb->query("select ID from wp_hexam_userdata where testid=".$newid." and userid=".get_current_user_id());
		  if ($wpdb->num_rows==0) {
	          $wpdb->query("insert into wp_hexam_userdata(userid,testid,point) values(".get_current_user_id().",".$newid.",".$point.")");
	          //message for score
	          $percent = $point / $question_count;
			  if ($percent >= .7) {
			  	$replacement=$replacement.'<br><b>'.$word["hcongrat"].'</b>';
			  } else {
			  	$replacement=$replacement.'<br><b>'.$word["hbest"].'</b>';	
			  }
	      } 
		  else {
				//compare previous scores
		  		$points = $wpdb->get_row("select point from wp_hexam_userdata where testid=".$newid." and userid=".get_current_user_id());
		  		$percent = @($points->point / $question_count);
		  		$replacement=$replacement.'<p>Best so far: '.$points->point.'. Points this time: '.$point.'. Percent: '.$percent.'</p>';
		  		//update query if points is greater than previous entry
		  		if ($point > $points->point) {
		  			$wpdb->query("update wp_hexam_userdata set point = ".$point." where testid=".$newid." and userid=".get_current_user_id());
		  		} 
		  		if ($percent >= .7) {
					$replacement=$replacement.'<br><b>'.$word["hcongrat"].'</b>';
				} else {
					$replacement=$replacement.'<br><b>'.$word["hbest"].'</b>';	
				}
		  		//$replacement=$replacement.'<br><b>'.$word["hbut"].'.</b>';
		  		
		}
		$prodid = $wpdb->get_row("select prodid from wp_hexam_testnames where id =".$newid);
		//$guid = $wpdb->get_row("select guid from wp_posts where id = ".$prodid->prodid);
		//$replacement=$replacement.'<p>productid:'.$prodid->prodid.' and guid: '.$guid->guid.'</p>';	  
		//$replacement=$replacement.'		<div class="wpsc_buy_button_container">';
		//$replacement=$replacement.'			<input id="product_'.$prodid->prodid.'_submit_button" class="wpsc_buy_button" type="submit" name="Buy" value="Add To Cart">';
		//$replacement=$replacement.'			<div class="wpsc_loading_animation">';
		//$replacement=$replacement.'		</div>';
		$replacement=$replacement.'[add_to_cart='.$prodid->prodid.']</div>';

	 }
	}
 }
 else {
   $replacement='<span style="color:#FF0000"><b>'.$word["hlogin"].'!</b></span>';
 }
    $pattern="[exam id=".$newid." exam]";
	return str_replace($pattern, $replacement, $content);
}

function hexam_admin() {
  global $wpdb;
  global $wp_query;
  $tb_ex = get_option('hexam_tables');
  if ($tb_ex!=1) {
      $wpdb->query( "create table if not exists wp_hexam_userdata (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,userid INT,testid INT,point INT) CHARACTER SET utf8 COLLATE utf8_general_ci");
      $wpdb->query( "create table if not exists wp_hexam_testnames (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,testname TEXT,testtype VARCHAR(5))  CHARACTER SET utf8 COLLATE utf8_general_ci");
      $wpdb->query( "create table if not exists wp_hexam_questions (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,testid INT,content TEXT,answers TEXT,correct INT) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
      update_option("hexam_tables", '2');
  }
  add_menu_page('admin-menu', 'EXAM settings', 5, __FILE__, 'hexam_settings');
}

function hexam_settings() {
  global $wpdb;
  global $wp_query;
  $cuurl="?page=hexam/hexam.php";
  echo '<div class="wrap"><h2>Exam settings</h2>';
	  ?>
<form name="hexamform1" method="post" action="<?php echo $cuurl;?>&do=edittest">
<br><a href="<?php echo $cuurl;?>">Plugin settings home page</a><br><br>

<a href="<?php echo $cuurl;?>&do=newtest">Create new test	</a>  
<br><?php 
$wpdb->query("select testid from wp_hexam_questions group by testid ");
$testcount=$wpdb->num_rows;
if ($testcount>0)
  {
    ?><br>Edit your tests <select name="edittest"> <?php
    $testnet=$wpdb->get_results("select id,testname from wp_hexam_testnames ");
    foreach ($testnet as $tests) {
	    echo '<option value="'.$tests->id.'">Test '.$tests->id.'-'.$tests->testname.'</option>';
      }
   ?>  </select><input type="submit" name="Edit it" value="Edit it"><br><?php
 }
?>
</form>
<?php
	  
$doing='';
if (isset($_GET["do"])) {$doing=$_GET["do"];} 

//USER DATA PART
if ($doing=='userdata') {
echo '<h3>Users data</h3>';
  $newid=$wpdb->escape($_GET["edittest"]);

  $usernet=$wpdb->get_results("SELECT a.display_name AS dn,b.point as pt from wp_users a INNER JOIN wp_hexam_userdata b ON a.ID=b.userid where b.testid=".$newid." order by b.point desc");
   foreach ($usernet as $unet) {
   echo  '<b>'.$unet->dn.'-'.$unet->pt.'</b><br>';
  }
  echo 'You can copy the results from here and post it in your site<br>'; 
}

//DELETE PART
elseif ($doing=='deltest') {
echo '<h3>Delete part</h3>';
  $newid=$wpdb->escape($_GET["edittest"]);
  if (isset($_GET["sure"]) and $_GET["sure"]==1){
  $wpdb->query("delete from wp_hexam_testnames where id=".$newid);
  $wpdb->query("delete from wp_hexam_questions where testid=".$newid);
  echo 'Selected test has been removed from your test base';
  }
  else {
    echo 'Are you sure to delete chosen test? <a href="'.$cuurl.'&do=deltest&edittest='.$newid.'&sure=1">Yes<a/>, <a href="'.$cuurl.'">No</a>';
  }
}

//EDIT PART
elseif ($doing=='edittest') {
echo '<h3>Edit part</h3>';
  if (isset($_POST["tdesc"])) {
    $testname=$wpdb->escape($_POST["tdesc"]);
	$testtype=$wpdb->escape($_POST["ttype"]);
    $newid=$wpdb->escape($_POST["edittest"]);
    $wpdb->query("UPDATE wp_hexam_testnames set testname='".$testname."',testtype='".$testtype."' where id=".$newid);
    $update='';
    for ($i=1;$i<=$_POST["qcount"];$i++) {  
      $answers='';
      for ($j=1;$j<=$_POST["acount"];$j++) {
       $answers=$answers."~".$_POST["answer".$i."_".$j];
      }
  
      $wpdb->query("update wp_hexam_questions set content='".$wpdb->escape($_POST["question".$i])."',answers='".$wpdb->escape($answers)."',correct=".$wpdb->escape($_POST["correct".$i])." where testid=".$newid." and id=".$wpdb->escape($_POST["qid".$i]));
   }

   echo 'Your test has been updated succesfully...';
   }
   else {
     $newid=$wpdb->escape($_POST["edittest"]);
     $testnamerow=$wpdb->get_row("select testname,testtype from wp_hexam_testnames where id=".$newid);
     $testname=$testnamerow->testname;
	 $testtype=$testnamerow->testtype;
    ?>
    <form method="post" action="" name="hexamform">
    Test name(or description): <input name="tdesc" type="text" value="<?php echo $testname;?>">  (<a href="<?php echo $cuurl;?>&do=deltest&edittest=<?php echo $newid;?>">Delete this test</a>)
	<br>
	<input type="hidden" name="ttype" value="QUIZ">
	<input type="hidden" name="edittest" value="<?php echo $newid;?>">
    <br><br>
    <?php
    $testsnet=$wpdb->get_results("select * from wp_hexam_questions where testid=".$newid." order by id asc");
    $i=0;
    foreach ($testsnet as $tests) {
      $i=$i+1;
      echo 'Question '.$i.': <input type="hidden" name="qid'.$i.'" value="'.$tests->id.'"> <input type="text" size="100" name="question'.$i.'" value="'.htmlentities(stripslashes($tests->content)).'"><br>';
      $answers_ed=explode("~",htmlentities(stripslashes($tests->answers)));// echo sizeof($answers_ed);
      for ($j=1;$j<=(sizeof($answers_ed)-1);$j++) {echo 'Answer '.$j.': <input type="text" size="10" name="answer'.$i.'_'.$j.'" value="'.$answers_ed[$j].'"><br>';}
      echo 'Correct(Type 1,2,3... - Field number) : <input type="text" size="10" name="correct'.$i.'" value="'.$tests->correct.'"><br><br>';// burda qalmisan
    }

    ?>
    <input type="hidden" name="qcount" value="<?php echo $i;?>">
    <input type="hidden" name="acount" value="<?php echo (sizeof($answers_ed)-1);?>">
    <input type="submit" name="Submit this exam" value="Submit this exam">
    </form>
    <p>Copy and paste this into that page you want to see this test: [exam id=<?php echo $newid; ?> exam]</p>
    <?php
   }

}
//INSERT PART
elseif ($doing=='newtest') {
echo '<h3>Create test</h3>';
  if (isset($_POST["tdesc"])) {
    $testname=$wpdb->escape($_POST["tdesc"]);
	$testtype=$wpdb->escape($_POST["ttype"]);
	//query to get prodid - SELECT * FROM `wp_posts` WHERE post_status = 'publish' and post_title = 'How to Break a Horses Hearts'
	$prodid = $wpdb->get_row("SELECT id FROM wp_posts WHERE post_type = 'wpsc-product' and post_status = 'publish' and post_title = '.$testname.'");
	
    $wpdb->query("insert into wp_hexam_testnames(`testname`,`testtype`,`prodid`) values('".$testname."','".$testtype."','".$prodid->id."')");
    $newidrow = $wpdb->get_row("SELECT id FROM wp_hexam_testnames order by id desc limit 1;");
    $newid=$newidrow->id;
    $insert='';
    for ($i=1;$i<=$_POST["qcount"];$i++) {
      $answers='';
      for ($j=1;$j<=$_POST["acount"];$j++){
        $answers=$answers."~".$_POST["answer".$i."_".$j];
      }
	  if ($_POST["correct".$i]=='') {$corr=0;}else {$corr=$_POST["correct".$i];}
      $insert=$insert.",(".$newid.",'".$wpdb->escape($_POST["question".$i])."','".$wpdb->escape($answers)."',".$wpdb->escape($corr).")";
    }
  $insert=substr($insert,1);
  $wpdb->query("insert into wp_hexam_questions(testid,content,answers,correct)  values ".$insert);
  echo 'Your test has been added succesfully...';
  }
  elseif(!isset($_POST["qcount"])) {
  ?>
  <form method="post" action="" name="hexamform1">
  How many questions do you want to have?(max 100) <input type="text" name="qcount" value="10"><br>
  How many answers do you want each question to have?(max 10) <input type="text" name="acount" value="5"><br>
  <input type="submit" name="Submit" value="Go to questions page">
  </form>
  <?php
  }
  else {
    ?>
    <form method="post" action="" name="hexamform">
    Test name (or description): <input name="tdesc" type="text"> <br>
	<input type="hidden" name="ttype" value="QUIZ">
    <input name="qcount" type="hidden" value="<?php echo htmlentities($_POST["qcount"]);?>">
    <input name="acount" type="hidden" value="<?php echo htmlentities($_POST["acount"]);?>">
    <br><br>
    <?php
    for ($i=1;$i<=min($_POST["qcount"],100);$i++) {
      echo 'Question '.$i.': <input type="text" size="100" name="question'.$i.'"><br>';
      for ($j=1;$j<=min($_POST["acount"],10);$j++) {
	    echo 'Answer '.$j.': <input type="text" size="10" name="answer'.$i.'_'.$j.'"><br>';
	  }
      echo 'Correct(Type a number: 1,2,3 ... - Field number) : <input type="text" size="10" name="correct'.$i.'"><br><br>';
    }
    ?>
    <input type="submit" name="Submit this exam" value="Submit this exam">
    </form>
    <?php
  }
}

echo'  <br><br>
You can make your text rich, you can use images in test questions or answers.';

}
add_action('admin_menu', 'hexam_admin');
add_filter('the_content', 'hexam');
?>

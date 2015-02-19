<?php

if(strstr($_SERVER['HTTP_HOST'],".com")) {
  define("PTH","/");
}
else {
  define("PTH","/projects/safetyvisa/");
}

define('PUBLIC_PATH', PTH.'public/');
define("FPTH","http://www.remikuti.com/");
define("TITLE","Remikuti");
define("DOMAIN","remikuti.com");
define("EMAIL","no-reply@remikuti.com");
define("CEMAIL","me@remikuti.com");
define("HOSTID",1);
define("HTITTLE",'<img src="'.PTH.'remikuti.png" alt="'.TITLE.'" title="'.TITLE.'" />');
define("HSTITLE",TITLE."&rsquo;s");
define("HTCSS",'style="vertical-align:top;"');
define("SUBSCRIBE_EMAIL_SUFFIX","xEM____");
ini_set("safe_mode",0);

//TWITTER
define('CONSUMER_KEY', 'cMavPzut7OkNxPl0YzDRKg');
define('CONSUMER_SECRET', 'gXeWF7tXQY6YHYCfOr8XVka90tKIRQVmxOjzKsPXU');
define('OAUTH_CALLBACK', "http://".$_SERVER['HTTP_HOST'].PTH.'RK/callback.php');

$scriptsArray = array('scripts/json2','lib/lodash/dist/lodash.min','lib/moment/moment', 'lib/angular/angular.min', 'lib/angular-ui-router/release/angular-ui-router.min', 'lib/angular-animate/angular-animate', 'lib/angular-aria/angular-aria', 'lib/angular-cookies/angular-cookies', 'lib/angular-elastic/elastic', 'lib/hammerjs/hammer', 'lib/angular-material/angular-material', 'js/application');
$stylesArray = array("lib/angular-material/angular-material");
$menuitems = array("Download","About"/*,"Contact"*/);
class db
{
	function __construct()
	{
		$this->database = '';
	}

  public $database;

  public function c()
	{

		if(!strstr($_SERVER['HTTP_HOST'],".com"))
		  $connect = mysqli_connect("localhost","root","","godson") or false;
		/*else
		  $connect = connection to your production Database
    */
		return $connect;
	}

	public function query($table,$vars,$where)
	{
			$nc = $this->c();
			$q = mysqli_query($nc,"SELECT $vars FROM $table WHERE $where");
			return array(mysqli_num_rows($q),$q,$nc);
	}

	public function delete($table,$where)
	{
		$nc = $this->c();

		$q = mysqli_query($nc,"DELETE FROM $table WHERE $where");
		$this->close_db_con($nc);
		return $q?true:false;
	}
	public function update($table,$vars,$where)
	{
		$nc = $this->c();
		$q = mysqli_query($nc,"UPDATE $table SET $vars WHERE $where");
		$this->close_db_con($nc);
		return $q?true:false;
	}
	public function close_db_con($nc)
	{
			mysqli_kill($nc,mysqli_thread_id($nc));
			return mysqli_close($nc);
	}
	public function fromTable($table,$vars,$where)
	{
			$nc = $this->c();
			$q = mysqli_query($nc,"SELECT $vars FROM `$table` WHERE $where");
			$r = mysqli_fetch_array($q);
			$this->close_db_con($nc);
			return $r;
	}
	public function insertInto($table,$values)
	{
		if(is_array($values))
		{
			$str="INSERT INTO `$table` VALUES (NULL,";
			foreach($values as $value)
			{
				$str.="'".$value."',";
			}

			$str = substr($str,0,strlen($str) - 1);
			$str.=")";
			$nc = $this->c();
			$q = mysqli_query($nc,$str);
			$this->close_db_con($nc);
			if($q)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}
function strclean($input)
{
 	return stripslashes(htmlentities($input,ENT_QUOTES));
}
function unstrclean($input,$rm=false)
{
	$t = html_entity_decode($input,ENT_QUOTES,'UTF-8');
	if($rm)$t = preg_replace("/\&\#(\d+)\;/","",$input);
	return $t;
}
function unclean($str)
{
	$str=str_replace("&#039;","'",$str);
	$str=str_replace("&#147;",'"',$str);
	$str=str_replace("&lt;","<",$str);
	$str=str_replace("&gt;",">",$str);
	$str = preg_replace("/\&\#039\;/", "`", $str);
	$str = preg_replace("/\&\#\d+\;/", "", $str);
	$str = preg_replace("/\&amp\;\#\d+\;/", "", $str);
	$str=trim($str);
	return $str;
}
function clean($str)
{
	$str=str_replace("'","&#039;",$str);
	$str=str_replace('"',"&#147;",$str);
	$str=trim($str);
	return $str;
}
function removeTag($html)
{
	$text = preg_replace("/<\w+>|<\/\w+>|<\w+>|<\w+\/>/i",' ',$html);
	return $text;
}
function filtercomments($com)
{
	if(stristr($com,"[/bot/]"))
	{
		list($nm,$txt) =explode("[/bot/]",$com);
		return array($nm,$txt);
	}
	else return false;
}
function blogurl($pid,$title="",$ext=false)
{
	$title = cuttitle($title,67,true);
	$title = preg_replace("/[\\/\\\:*?\"<>,()|%#$\s]/","-",unclean($title));
	$title = preg_replace("/“|”|’|‘/", "", $title);
	$title = preg_replace("/--|---|----/","-",$title);
	return ($ext?FPTH:PTH).BLOG.$pid."/".strtolower($title).".htm";
}
function tagger($str,$issql)
{
	$str = unstrclean($str);
	$str = preg_replace("/\-|\,|\’s|\:|\(|\)|\&\#039\;s|\&\#147\;s|\&|\’|'|\?|\–|\!|\&amp|\;|\"|\/\\|\'|\‘|\“|\”/i", " ", $str);
	$w = explode(" ",$str,35);
	$verbs = array("have","i","will","every","would","when","day","out","us","good","without","and","your","you","re","close","open","far","near","me","not","been","did","do","done","make","made","but","by","both","with","while","where","whom","who","since","seen","act","had","has","the","this","they","de","them","even","before","of","off","if","she","him","her","his","he","way","due","that","in","at","those","be","is","to","coming","own","after","pay","paid","only","are","more","whose","say","said","says","side","on","from","come","for","now","it","its","can","all","as","a","an","was","|","ft","ft."," ","","0","k","b","remix","ur","ya","prod","prod.","ft","ft.");
	$out="";
	$i=0;
	foreach($w as $k=>$ww)
	{
		$ww = trim($ww);
		if(in_array(strtolower($ww),$verbs)||strlen($ww)<2)continue;
		if($issql)$out.=$i>0?" OR ":"";
		else $out.=$i>0?",":"";
		if($issql)$out.="title LIKE '%".strclean($ww)."%'";
		else $out.=$ww;
		$i++;
	}
	return $out;
}
function lepause($i)
{
	return '<span class="'.($i?"btss":"bts").' topright pp" onClick="__pp__()" title="Pause/Play Tiles"><img src="'.PTH.'img/p.png" height="15" class="ds"/></span>';
}
function rnd()
{
	return rand(4500,6500);
}
function ogvideo($video)
{
	$str= str_replace("embed","v",$video);
	if(stristr($str,"?"))$str.="&amp;version=3&amp;autohide=1";
	else $str.="?version=3&amp;autohide=1";
	return $str;
}
function notFound($str)
{
	return "<h3 class='chd'>Content not found</h3><div style='font-size:5em;display:inline-block;'>:(</div><div class='nf'>$str</div>";;
}
function cuttitle($title,$len,$_end=false)
{
	$len=intval($len);
	return trim(strlen(trim($title))>$len?substr($title,0,($len-3)).($_end?"":"..."):$title);
}
function array_join($a,$j,$isMysqlQuery)
{
	$str="";
	if(is_array($a))
	{
		//$str="";
		foreach($a as $i=>$b)
		{
			$str .= ($i>0?($j):"").($isMysqlQuery?"id<>".$b:$b);
		}
		return $str;
	}
	$str = strlen($str)<3?"id>0":$str;
	return $str;
}

function comment_remind($id,$pid,$nm,$com,$date)
{
	$con = new db();$id=intval($id);
	$q=$con->query("pedia_comment","uid","pid=$pid and var3=1 and uid<>0 and uid<>$id and date<$date");
	while($r = mysqli_fetch_array($q[1]))
	{
		$pid=intval($pid);
		$blg = $con->fromTable("pedia_post","title","id=$pid");
		$fc = filtercomments($com);
		if($fc)$com=$fc[1];
		sendmail($r[0],FALSE,"$nm dropped a comment after you","<h4><a href='".blogurl($pid)."' target='_blank'>$blg[0]</a></h4><h5>$nm said:</h5><h3>$com</h3>");
	}
	$con->close_db_con($q[2]);
}
function validateEmail($emailAddress)
{
	return preg_match("|^(((\w)+\.)*\w)+@(\w)+(\.(\w)+)+$|", $emailAddress);
}
function sendmail($id,$isem,$subj,$html)
{
	$con=new db();
	if($isem)$em=$id;
	else
	{
		$id=intval($id);if($id==0)return false;
		$em = $con->fromTable("pedia_user","em","id=$id");
		if($em)$em=$em[0];else return false;
	}
	if(!validateEmail($em))return false;
	$html = "<div>$html</div>";
	$headers = 'From:'.TITLE.' <'.EMAIL.'>' . "\r\n" .
			'Reply-To: <'.EMAIL.'>' . "\r\n" .
			'MIME-Version: 1.0'."\r\n".
			'Content-Type: text/html; charset=ISO-8859-1'."\r\n".
			'X-Mailer: PHP/' . phpversion();
	$email ="<!doctype html><html><head><meta charset='utf-8'/><style type='text/css'>.d{display:inline-block;vertical-align:top;}a{text-decoration:none;color:#09c;}h1,h2,h3,h4,h5,p{padding:0;margin:5px 0;} img{max-width:100%;border:0;}</style></head><body style='font:1em \"Segoe UI Light\",\"Open Sans\",century gothic,Verdana;color:#fff;background-color:#3e0952;padding:10px;'>
	<a href='".FPTH."' style='color:#fff'><h1><img src='".FPTH."img/icon.png' height='32'/> ".TITLE."</h1></a><br/>
	<div style='width:100%;margin:0px auto 10px;color:#3e0952;background-color:#fff;'><div style='padding:10px;'><h3  align='center'>".$subj."</h3><br/>".$html."</div></div><br/><p><a href='".FPTH."'>".TITLE."</a> &copy;".date("Y")."</p></body></html>";
	@mail($em,TITLE." | ".$subj,$email,$headers);
	unset($email);
}


function showError($msg,$type)
	{
		$errt="alert-";
		switch($type)
		{
			case 1:
			$errt=$errt."error";
			break;
			case 2:
			$errt=$errt."danger";
			break;
			case 3:
			$errt=$errt."info";
			break;
			case 4:
			$errt=$errt."success";
			break;
		}
		return "<div class=\"alert $errt\" style=\"display:inline-block;\">".$msg."</div>";
	}
	function gtime($date)
    {
        $cTime = date("U") - $date;
        $yy = intval(($cTime / 365 / 24 / 60 / 60));
        $MM = intval(($cTime / 30 / 24 / 60 / 60));
        $ww = intval(($cTime / 7 / 24 / 60 / 60));
        $dd = intval(($cTime / 24 / 60 / 60));
        $hh = intval(($cTime / 60 / 60));
        $mm = intval(($cTime / 60));
        $ss = $cTime;
        $aTime = $yy == 0?$MM == 0 ?$ww == 0 ?$dd == 0 ?$hh == 0 ?$mm == 0 ?($ss == 1?" a second ago":"$ss seconds ago"):($mm == 1?" a minute ago":" $mm minutes ago"):($hh == 1?" an hour ago":" $hh hours ago"):($dd == 1?" a day ago":" $dd days ago"):date("l.d.M",$date):date("d.M.Y",$date):date("l.d.F",$date);//l d F h:ia  //D d M Y h:ia
        return $aTime;
    }

function strLength($str)
{
		if(is_array($str))
		{
			foreach($str as $value)
			{
				if(strlen($value) < 5)
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
		return true;
}
function adjustimg($str)
{
	$str = preg_replace("/https\:\/\/|http:\/\//", "", $str);
	return $str;
}

function imgsize($img,$w=100,$h=100)
{

	return "http://img.remikuti.com/".$w."/".$h."/i/".adjustimg($img);
	//return PTH."scripts/req.php?w=".$w."&h=".$h."&imgthumb=".urlencode($img);
}
function headerCache()
{
	$cache_expire = 60*60*24*365;
	header("Pragma: public");
	header("Cache-Control: max-age=".$cache_expire);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
}
function resize_pic($img,$x,$y)
    {
		$img = urldecode($img);
        if($img&&strlen($img)>5)
        {
          // $f_img = strtolower(substr($img,-4,4));
         //  $t_img = strtolower(substr($img,-3,3));
           $final_ext;
           $img_old;
           if(preg_match("/\.jpg|\.jpeg/i", $img))
           {
                $img_old = imagecreatefromjpeg($img);
                $final_ext = ".jpg";
				$t = 1;
           }
           else if(stristr($img,".gif"))
           {
               $img_old = imagecreatefromgif($img);
               $final_ext = ".gif";
			   $t = 2;
           }
           else if(stristr($img,".png"))
           {
                 $img_old = imagecreatefrompng($img);
               $final_ext = ".png";
			   $t = 3;
           }
           else
           {
               $img_old = false;
			   $t= false;
           }
           if($img_old && $t)
           {
               list($xx, $yy) = getimagesize($img);
               $newx;
               $newy;
               if($xx < $x || $yy < $y)
               {
                  // $newx = $xx;
                  // $newy = $yy;
				  header("location: $img");exit();
               }
			   if($xx < $yy)
               {
                   $newx = $x;
                   $newy = intval(($yy / $xx) * $x);
               }
               else
               {
                   $newy = $y;
                   $newx = intval(($xx / $yy) * $y);
               }
               try
               {
                   $new_img = imagecreatetruecolor($newx,$newy);
				   if($final_ext == ".gif" || $final_ext == ".png"){
					imagecolortransparent($new_img, imagecolorallocatealpha($new_img, 0, 0, 0, 127));
					imagealphablending($new_img, false);
					imagesavealpha($new_img, true);
					}
                  if(!$new_img);
                   {
                      //throw new Exception("could not save");
                   }
                   imagecopyresampled($new_img,$img_old,0,0,0,0,$newx,$newy,$xx,$yy);
               }
               catch(Exception $err)
               {
                   echo $err->getMessage();
                   return false;
               }
             switch($t)
			  {
				  case 1:
					  headerCache();
					  header("Content-type:image/jpg");
					  imagejpeg($new_img);
				  break;
					case 2:
						headerCache();
						header("Content-type:image/gif");
						imagegif($new_img);
					break;
					case 3:
						headerCache();
						header("Content-type:image/png");
						imagepng($new_img);
					break;
					default:
						header("location: $img");
					break;
			  }
			 exit();
		   }
		   else
		   {
				header("location: $img");
		   }
        }
		else
		{

		}
  }
?>
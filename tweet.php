<?php 

/**
 * @author Vinit Shahdeo
 * @copyright miTweet | 2017
 */

//for removing extra spaces
function test_input($data) {
  $data = trim($data);
  $data = preg_replace('/\s{2,}/',' ', $data);
  $data = str_replace("\0","", $data);
  return $data;
}

$msg='';  //variable used for storing the textbox input i.e. tweet

//tweet now
if (isset($_POST['tweetnow'])) {
  
  if(empty($_POST['msg']))
  { 
  	$developer='&via=Vinit_Shahdeo';
  	$hashtags='&hashtags=miTweet';
  	$msg='Hello there! You can create links for your tweets!';
  	$msg.=' Made with love! ';
  	$msg.=$developer;
  	$msg.=$hashtags;
  	@header("location:https://twitter.com/intent/tweet?text=$msg");
  }
  else
  {
  $msg = test_input($_POST['msg']);
  $hashtags='&hashtags=miTweet';
  if(strlen($msg)<132)
  {
  $msg.=$hashtags;
  }
  $msg=htmlspecialchars($msg);
  
  file_put_contents("tweets.txt", date("Y-m-d h:i:sa").PHP_EOL,FILE_APPEND);
  file_put_contents("tweets.txt", $msg. PHP_EOL,FILE_APPEND);
  
  @header("location:https://twitter.com/intent/tweet?text=$msg") 
  or die("Use only required characters. Please don't include hashtags here!");
  }

}

//link generator
if(isset($_POST['link']))
{

if(!empty($_POST['msg']))
{
function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
{
  $bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
  $response = file_get_contents($bitly);

  if(strtolower($format) == 'json')
  {
    $json = @json_decode($response,true);
    return $json['results'][$url]['shortUrl'];
  }
  else 
  {
    $xml = simplexml_load_string($response);
    return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
  }
}

$msg = test_input($_POST['msg']);
$hashtags='&hashtags=miTweet';

file_put_contents("tweets.txt", date("Y-m-d h:i:sa").PHP_EOL,FILE_APPEND);
file_put_contents("tweets.txt", $msg. PHP_EOL.PHP_EOL,FILE_APPEND);

if(strlen($msg)<132)
{
  $msg.=$hashtags;
}
$url='https://twitter.com/intent/tweet?text='.$msg;
$short = make_bitly_url($url,'mitweet','R_ff691c7d55584c13b8a3af003459dc48','json');
@header("location:./link.php?q=$short");
}
else
{
  @header("location:./result.php");
}
}
?>
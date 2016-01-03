<?php

require_once './inc/database.class.php';


$db = new Database;

$appIds = $db->appIds();
foreach($appIds as $appId)
{
  echo $appId['app_id'];
}


if(isset($_GET['id']))
{
  $id = $_GET['id'];
}
else
{
  $id = 'com.Slack';
}

function display($id, $type)
{
  $db = new Database;

  $res = $db->query($id, $type);

  foreach($res as $r)
  {
    echo "<li>{$r['comment']}</li>";
  }
}

echo '<h3>Likes</h3>';
display($id, 'TRUE');

echo '<h3>Dislikes</h3>';
display($id, 'FALSE');

echo '<h3>Spam</h3>';
display($id, 'SPAM');

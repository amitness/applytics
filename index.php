<?php

require_once './inc/database.class.php';


$db = new Database;

$likes =0;
$dislikes=0;


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
    echo "<ul>";
    echo "<li> {$r['comment']} </li>";
    echo "</ul>";
  }
}

$senti = $db->senti($id);

$profile = $db->profile($id);
$profile = $profile[0];



	$main_app_name = $id;
	$main_app_build = "";
	$main_app_avg_rating = $profile['average_rating'];
	$main_app_last_update_at = $profile['last_update'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Material Design fonts -->
  <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

   <!-- Bootstrap Material Design -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/css/bootstrap-material-design.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.7/css/ripples.css" rel="stylesheet">

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<link href="css/style.css" rel="stylesheet">

	<title> Applytics </title>
</head>
<body>
	<div class="container">
<!-- # Bootstrap navbar -->
		<div class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="javascript:void(0)">Applytics</a>
              </div>
              <div class="navbar-collapse collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                  <li class="active"><a href="javascript:void(0)">Home<div class="ripple-container"></div></a></li>
                  <li><a href="javascript:void(0)">About</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                <form class="navbar-form navbar-left">
                  <div class="form-group is-empty">
                    <input type="text" class="form-control col-md-8" placeholder="Search apps">
                  <span class="material-input"></span></div>
                </form>
                  <li class="dropdown">
                    <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Top Apps
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
<?php
	$appIds = $db->appIds();
foreach($appIds as $appId)
{
?>
		            <li><a href="./?id=<?php echo $appId['appid']; ?>"><?php echo $appId['appname']; ?></a></li>
<?php
}
?>
		          </ul>
		        </li>
		      </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          </nav>
<!--Navbar finish-->
		<div class="app-main clearfix col-sm-offset-1 col-md-offset-2 col-lg-offset-3 comments-nav jumbotron">
			<div class="main-app-img">
      	<img height="100" width="100" src="<?php echo $profile['icon_url']; ?>" class="main-app-img">
			</div>
			<div class="main-app-details table-responsive">
				<h2><?php echo $profile["appname"]; ?></h2>
				<table class="table table-hover">
					<tr>
						<td>Category:</td>
						<td><?php echo $profile["category"] ?></td>
					</tr>
					<tr>
						<td>Total Downloads:</td>
						<td><?php echo $profile["downloads"] ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><a href="mailto:<?php echo $profile["email"] ?>"><?php echo $profile["email"] ?></a></td>
					</tr>
					<tr>
						<td>Website:</td>
						<td><a href="<?php echo $profile["website_url"] ?>">url</a></td>
					</tr>
					<tr>
						<td>Average rating:</td>
						<td><?php echo $main_app_avg_rating; ?></td>
					</tr>
					<tr>
						<td>Last update:</td>
						<td><?php echo $main_app_last_update_at; ?></td>
					</tr>
				</table>
			</div>
					<div class="sentiment-icons clearfix ">
		  <span class="col-sm-4 col-lg-offset-2 col-lg-3 materialgreen materialshift" style="opacity: <?php echo $likes; ?>"><i class="material-icons md-48">thumb_up</i></span>
		  <!-- <span class="col-sm-4 col-lg-4 fa fa-exclamation fa-5x"></span> -->
		  <span class="col-sm-4 col-lg-3 materialred materialshift" style="opacity: <?php echo $dislikes; ?>"><i class="material-icons md-48">thumb_down</i></span>
		</div>
				  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Likes</a></li>
		    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Dislikes</a></li>
		    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Spam</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="home">
        <h3>Likes</h3>
						<?php display($id, 'TRUE'); ?>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="profile">
          <h3>Dislikes</h3>
						<?php display($id, 'FALSE'); ?>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="messages">
        <h3>Spam</h3>
						<?php display($id, 'SPAM'); ?>
		    </div>
		  </div>
		</div>
		<!-- <div class="graph">
			<h4><i>Graph</i></h4>
			<hr>
		</div> -->
		<!-- <div class="comments-nav">
			<ul class="nav nav-tabs">
			  <li role="presentation" class="active" id="tab1">
			  	<a href="#">Home</a>
			  	foo
			  </li>
			  <li role="presentation" id="tab2">
			  	<a href="#">Profile</a>
			  	bar
			  </li>
			  <li role="presentation" id="tab3">
			  	<a href="#">Messages</a>
			  	baz
			  </li>
			</ul>
		</div> -->

		<hr>
		<div class="footer">
			<h4>Developed at Hackclash
				<span class="pull-right git-icon">
					<!-- <img src= github icon> -->
					<a href="https://github.com/studenton/applytics"><img src="images/github-32.png"></a>
				</span>
			</h4>
		</div>
	</div>
</body>
</html>

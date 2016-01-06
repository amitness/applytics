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

	<link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link href="css/style.css" rel="stylesheet">

	<title> Applytics </title>
</head>
<body>
	<div class="container">
		<!-- # Bootstrap navbar -->
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">Applytics</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <!-- <ul class="nav navbar-nav">
		        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
		        <li><a href="#">Link</a></li>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
		          <ul class="dropdown-menu">
		            <li><a href="#">Action</a></li>
		            <li><a href="#">Another action</a></li>
		            <li><a href="#">Something else here</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		            <li role="separator" class="divider"></li>
		            <li><a href="#">One more separated link</a></li>
		          </ul>
		        </li>
		      </ul> -->


		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Top apps <span class="caret"></span></a>
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
		      <form class="navbar-form navbar-right" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control" placeholder="Search apps">
		        </div>
		        <button type="submit" class="btn btn-default">Go</button>
		      </form>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="app-main clearfix col-sm-offset-1 col-md-offset-2 col-lg-offset-3">
			<div class="main-app-img">
      	<img height="100" width="100" src="<?php echo $profile['icon_url']; ?>" class="main-app-img">
			</div>
			<div class="main-app-details table-responsive">
				<h2><?php echo $profile["appname"]; ?></h2>
				<table class="table table-hover">
					<tr>
						<td>Build:</td>
						<td><?php echo $main_app_build; ?></td>
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
		</div>
		<div class="sentiment-icons clearfix">
		  <span class="col-sm-4 col-lg-offset-1 col-lg-3 fa fa-thumbs-o-up fa-5x" style="opacity: <?php echo $likes; ?>"></span>
		  <!-- <span class="col-sm-4 col-lg-4 fa fa-exclamation fa-5x"></span> -->
		  <span class="col-sm-4 col-lg-3 fa fa-thumbs-o-down fa-5x" style="opacity: <?php echo $dislikes; ?>"></span>
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

		<div class="comments-nav">

		  <!-- Nav tabs -->
		  <!-- <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Likes</a></li>
		    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Dislikes</a></li>
		    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Spam</a></li>
		  </ul> -->

		  <!-- Tab panes -->
		  <!-- <div class="tab-content"> -->
		    <!-- <div role="tabpanel" class="tab-pane active" id="home"> -->
        <h3>Likes</h3>
						<?php display($id, 'TRUE'); ?>
		    <!-- </div> -->
		    <!-- <div role="tabpanel" class="tab-pane" id="profile"> -->
          <h3>Dislikes</h3>
						<?php display($id, 'FALSE'); ?>
		    <!-- </div> -->
		    <!-- <div role="tabpanel" class="tab-pane" id="messages"> -->
        <h3>Spam</h3>
						<?php display($id, 'SPAM'); ?>
		    <!-- </div> -->
		  </div>

		</div>
		<hr>
		<div class="footer">
			<h4>Developed at Hackclash 2016
				<span class="pull-right git-icon">
					<!-- <img src= github icon> -->
					<img src="images/github-32.png">
				</span>
			</h4>

		</div>
	</div>

</body>
</html>

<?php
session_start();
if(isset($_SESSION['username']))
{
    $user = $_SESSION['username'];
    $check = false;

    $username = 'root';
    $password = 'root';
    $port     = '8889';
    $database = 'comp3015';
    $host     = 'localhost';

    $link = mysqli_connect($host, $username, $password, $database, $port);

    if($link != false)
    {
        if($_FILES['picture']['type'] == 'image/jpeg' && $_FILES['picture']['size'] < 4000000)
        {
            $filename = md5(date('Y-m-d H:i:s:u'));
            move_uploaded_file($_FILES['picture']['tmp_name'], 'profiles/'.$filename.'.jpeg');
            $sql = "INSERT INTO profiles (username, picture) VALUES ('$user', '$filename')";
            $results = mysqli_query($link, $sql);
        }
    }
    mysqli_close($link);

}
else
{
    header("Location: index.php");
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Assignment 2</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<div id="wrapper">

    <div class="container">

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h1 class="login-panel text-center text-muted">
                    Assignment 2
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <hr/>
                <button class="btn btn-default" data-toggle="modal" data-target="#newPost"><i class="fa fa-comment"></i> New Profile</button>
                <a href="logout.php" class="btn btn-default pull-right"><i class="fa fa-sign-out"> </i> Logout</a>
                <hr/>
            </div>
        </div>

    </div>
</div>

<div id="newPost" class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <form role="form" method="post" action="profiles.php" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">New Profile</h4>
        </div>
        <div class="modal-body">
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control disabled" disabled value="<?php echo $user ?>">
                </div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input class="form-control" type="file" name="picture">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Submit!"/>
        </div>
    </div><!-- /.modal-content -->
    </form>
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php 

$username = 'root';
$password = 'root';
$port     = '8889';
$database = 'comp3015';
$host     = 'localhost';

$link = mysqli_connect($host, $username, $password, $database, $port);

$query = "select * from profiles";

$results = mysqli_query($link, $query);

while( $row = mysqli_fetch_array($results)  )
{

    $idFromMySql = $row['id'];
    $userFromMySql = $row['username'];
    $pictureFromMySql = $row['picture'];
    $profileBox = '
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <span>
                    '.$userFromMySql.'
                </span>
                <span class="pull-right text-muted">
                    <a class="" href="delete.php?id='.$idFromMySql.'">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </span>
            </div>
            <div class="panel-body">
                <p class="text-muted">
                </p>
                <p>
                    <img style="display: block;
                                margin-left: auto;
                                margin-right: auto;"
                    src= profiles/'.$pictureFromMySql.'.jpeg width="300" height="300"/>
                </p>
            </div>
            <div class="panel-footer">
                <p></p>
            </div>
        </div>
    </div>';
    echo $profileBox;
}

mysqli_close($link);
?>

</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
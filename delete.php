<?php 
session_start();
if(isset($_SESSION['username']))
{
    $user = $_SESSION['username'];
    $id = $_GET['id'];

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
        $pictureFromMySql = $row['picture'];
        $userFromMySql = $row['username'];
        if($idFromMySql == $id && $userFromMySql == $user)
        {
            $sql = "DELETE FROM profiles WHERE id='$id'";
        }
        
    }
    if(mysqli_query($link, $sql)){
        echo "Records were deleted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    mysqli_close($link);
    header("Location: profiles.php");

}
else
{
    header("Location: profiles.php");
}
?>
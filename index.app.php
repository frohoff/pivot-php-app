<?php

if($_POST['password']){
    $dbconn = pg_connect("host=localhost dbname=app user=postgres password=postgres")    
        or die('Could not connect: ' . pg_last_error());
    $user = $_POST['username'];
    $pass = $_POST['password'];     
    $query = "select * from users where username = '$user' and password = '$pass'";
    $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
    $row = pg_fetch_assoc($result);
    setcookie("query",$query);
    #if(pg_num_rows($result) == 0){       
    #    $error = $error . "Invalid credentials";
    #}

    if ($error) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode($error));
        die();
    }else{
        $logged_in = $row["username"];
        setcookie("logged_in",$logged_in);
        header("Location: " . $_SERVER['PHP_SELF']);
        die();
    }
}


$logged_in = $_COOKIE["logged_in"];
$error = $_GET['error'];


?>
<html>
<body>

<?php if($error) { ?>
<font color="red">
<?= $error ?>
</font>
<?php } ?>

<?php if($logged_in) { ?>
<font color="green">
Logged in as <?= $logged_in ?>
</font>
<?php } ?>




<?php if($logged_in) { ?>


<form action="" method="get">
<table width="50%">
    <tr>
        <td>Search</td>
        <td><input type="text" name="search"></td>
    </tr>
</table>
    <input type="submit" value="Search" name="s">
</form>

<?php if($_GET['search']) { 
    $command = "cat /usr/share/dict/words | grep " . $_GET['search'] . " | head";
    setcookie("command",$command);
?>
<pre>
<?= passthru($command) ?>
</pre>
<?php } ?>

<?php } else { ?>
<form action="" method="post">
<table width="50%">
    <tr>
        <td>Username</td>
        <td><input type="text" name="username"></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><input type="text" name="password"></td>
    </tr>
</table>
    <input type="submit" value="OK" name="s">
</form>
<?php } ?>


</body>
</html>

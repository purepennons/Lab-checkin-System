<?php
    include_once("DB_Conf.php");
    include_once("DB_Class.php");
    $db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
    $sectionUsername = 'test03';
    $sectionPassword = '123';
    $sql = sprintf("SELECT * FROM ACCOUNT WHERE username='%s' AND password='%s'", mysql_real_escape_string($sectionUsername), mysql_real_escape_string($sectionPassword));
    $db->query($sql);
    header('Location:index.php');
    die();
    while($result = $db->fetch_array())
    {
        echo $result[0] . "  " . $result[1];
    }
?>
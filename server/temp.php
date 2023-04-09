<?php
setcookie('a', "1", time() + 30*24*60*60, "/");
if (isset($_COOKIE["a"]))
    echo $_COOKIE["a"];
?>
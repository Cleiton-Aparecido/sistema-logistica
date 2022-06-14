<?php
require_once("config.php");
date_default_timezone_set('America/Sao_Paulo');
$interaction = new interaction();
?>

<img src="../img/user.png">
<div id="inf_user"> <?php $interaction->IpSearch(); ?></div>
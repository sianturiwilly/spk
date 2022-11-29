<?php

session_start();
require_once 'config.php';

session_destroy();
exit("<script>window.location='".$www."';</script>");

?>
<?php
session_start();
session_unset();
header('refresh:0;url=index.php');

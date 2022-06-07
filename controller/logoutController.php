<?php
session_unset();
session_destroy();

header( 'Location: ' . __SITE_URL . '/index.php' );
?>
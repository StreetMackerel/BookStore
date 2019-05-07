<?php
require_once 'utils/functions.php';

if (!is_logged_in()) {
    header("Location: login_form.php");
}
else {
	unset($_SESSION['user']);

	header("Location: login_form.php");
}
?>

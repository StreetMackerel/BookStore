<?php
require_once 'classes/Book.php';
require_once 'classes/User.php';
require_once 'classes/Publisher.php';
require_once 'classes/Gump.php';
require_once 'classes/Purchase.php';
require_once 'utils/functions.php';


if (!is_logged_in()) {
    header("Location: login_form.php");
}

$user = $_SESSION['user'];

try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

   $validation_rules = array(
        'id' => 'required|integer|min_numeric,1'
    );
    $filter_rules = array(
    	'id' => 'trim|sanitize_numbers'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_GET);

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
        throw new Exception("Invalid book id: " . $errors['id']);
    }
    
    Book::buyBook($user->id, $validated_data['id']);

    header("Location: user_home.php");
}
catch (Exception $ex) {
    require 'user_home.php';
}
?>
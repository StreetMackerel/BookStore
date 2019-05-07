<?php
require_once 'utils/functions.php';
require_once 'classes/User.php';
require_once 'classes/Gump.php';

start_session();

try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

    $validation_rules = array(
        'username' => 'required|alpha_numeric|max_len,50|min_len,6',
	    'password' => 'required|min_len,6'
    );
    $filter_rules = array(
    	'username' => 'trim|sanitize_string',
    	'password' => 'trim'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_POST);

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else {
        $errors = array();

        $username = $validated_data['username'];
        $password = $validated_data['password'];

        $user = User::findByUsername($username);
        if ($user === false) {
            $errors['username'] = "Username not valid";
        }
        else {
            $hash = $user->password;
            if (!password_verify($password, $hash)) {
                $errors['password'] = "Password not valid";
            }
        }
        
        if($user->active == 0) {
            $errors['username'] = "Account inactive. Please Contact Administrator";
        }
    }

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }

    if ($user->role_id == 1) {
        $home = 'admin_home.php';
    }
    else if ($user->role_id == 2) {
        $home = 'manager_home.php';
    }
    else if ($user->role_id == 3) {
        $home = 'user_home.php';
    }

    $_SESSION['user'] = $user;

    header('Location: ' . $home);
}
catch (Exception $ex) {
    require 'login_form.php';
}
?>

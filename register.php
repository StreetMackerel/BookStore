<?php
require_once 'utils/functions.php';
require_once 'classes/User.php';
require_once 'classes/Gump.php';

start_session();

try {
    $validator = new GUMP();

    $sanitized_data = $validator->sanitize($_POST);

    $validation_rules = array(
        'username' => 'required|alpha_numeric|max_len,50|min_len,6',
	    'password' => 'required|min_len,6',
        'password_confirmation' => 'required|min_len,6'
    );
    $filter_rules = array(
    	'username' => 'trim|sanitize_string',
    	'password' => 'trim',
        'password_confirmation' => 'trim'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($sanitized_data);

    if ($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else {
        $errors = array();

        $username = $validated_data['username'];
        $password = $validated_data['password'];
        $password_confirmation = $validated_data['password_confirmation'];

        if ($password !== $password_confirmation) {
            $errors['password_confirmation'] = "Password confirmation does not match";
        }
        else {
            $user = User::findByUsername($username);
            if ($user !== false) {
                $errors['username'] = "Username already registered";
            }
            else {
                $user = new User();
                $user->username = $username;
                $user->password = password_hash($password, PASSWORD_DEFAULT);
                $user->role_id = 3;
                $user->save();
            }
        }
    }

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }

    $home = 'user_home.php';

    $_SESSION['user'] = $user;

    header('Location: ' . $home);
}
catch (Exception $ex) {
    require 'register_form.php';
}
?>

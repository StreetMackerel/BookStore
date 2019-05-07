<?php
require_once 'classes/User.php';
require_once 'classes/Gump.php';
require_once 'utils/functions.php';

try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

    $validation_rules = array(
        'id' => 'required|integer|min_numeric,1',
	    'password' => 'required|min_len,6',
        'password_confirmation' => 'required|min_len,6'  
    );
    $filter_rules = array(
    	'password' => 'trim',
        'password_confirmation' => 'trim'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_POST);

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else{
        
        
        $errors = array();
        
        $password = $validated_data['password'];
        $password_confirmation = $validated_data['password_confirmation'];

        if ($password !== $password_confirmation) {
            $errors['password_confirmation'] = "Password confirmation does not match";
        }
        else {
            
            $id = $validated_data['id'];
            $userPass = User::find($id);
            $userPass->password = password_hash($password, PASSWORD_DEFAULT);
            $userPass->save();
            
        }
        
        
    }

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }

   

    header("Location: users_index.php");
}
catch (Exception $ex) {
    require 'users_password_form.php';
}
?>
<?php
require_once 'classes/User.php';
require_once 'classes/Publisher.php';
require_once 'classes/Gump.php';
require_once 'utils/functions.php';

try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

    $validation_rules = array(
        'id' => 'required|integer|min_numeric,1',
        'username' => 'required|alpha_numeric|max_len,50|min_len,6',
        'role_id' => 'required|min_len,1|max_len,1'      
    );
    $filter_rules = array(
    	'username' => 'trim|sanitize_string',
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_POST);

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else{
        
        
        $errors = array();
        $username = $validated_data['username']; 
        $id = $validated_data['id'];
        $userUpdate = User::find($id);
        $userUpdate->username = $validated_data['username'];
        $userUpdate->role_id = $validated_data['role_id'];
        $userUpdate->save();
            
        }
        
        
    

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }

    header("Location: users_index.php");
}
catch (Exception $ex) {
    require 'users_edit.php';
}
?>

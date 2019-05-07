<?php
require_once 'classes/Book.php';
require_once 'classes/Publisher.php';
require_once 'classes/Gump.php';
require_once 'utils/functions.php';


try {
    $validator = new GUMP();

    $_POST = $validator->sanitize($_POST);

    $validation_rules = array(
        'name' => 'required|min_len,1|max_len,100',
        'address' => 'required|min_len,1|max_len,50',
        'phone' => 'required|numeric|max_len,12|min_numeric,0',
        'email' => 'required',
        'website' => 'required'
        
    );
    $filter_rules = array(
        'name' => 'trim|sanitize_string',
        'address' => 'trim|sanitize_string',
        'phone' => 'trim|sanitize_numbers',
        'email' => 'trim',
        'website' => 'trim'
    );

    $validator->validation_rules($validation_rules);
    $validator->filter_rules($filter_rules);

    $validated_data = $validator->run($_POST);

    if($validated_data === false) {
        $errors = $validator->get_errors_array();
    }
    else {
        $errors = array();
	
	}

    if (!empty($errors)) {
        throw new Exception("There were errors. Please fix them.");
    }
	

	
	$id = $validated_data['id'];
	$publisher = Publisher::find($id);
    $publisher->name = $validated_data['name'];
    $publisher->address = $validated_data['address'];
    $publisher->phone = $validated_data['phone'];
    $publisher->email = $validated_data['email'];
    $publisher->website = $validated_data['website'];
    
    $publisher->save();

    header("Location: publishers_index.php");
}
catch (Exception $ex) {
    require 'publishers_edit.php';
}
?>
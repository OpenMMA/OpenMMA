<?php
include_once "includes/form_generator.php";

$form = new Form("test", array(
    (object)array('name' => 'admin_email', 'title' => 'Admin email address', 'type' => 'email'),
    (object)array('name' => 'member_additional_data', 'title' => 'Additional member data', 'type' => 'textarea'),
    (object)array('name' => 'text_editor', 'title' => 'TinyMCE editor', 'type' => 'texteditor')
));

$form->generate();
var_dump($form->extract());
?>
<?php

require 'CommentClass.php';

try{
    if(empty($_POST['comment'])){
        throw new Exception("comment section can't be empty");
    }
}catch(Exception $e){
    echo $e->getMessage();
    exit;
}

$comment = new MyNamespace\Comment($_POST['comment']);
$comment->display();

?>
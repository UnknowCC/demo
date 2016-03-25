<?php

require_once 'Message.php';
require_once 'connectDb.php';

$message = array();

$validate = Message::validate($message);

if ($validate) {
    $sql = "INSERT INTO `message` (`username`, `email`, `face`, `content`, `pubtime`) VALUES (?,?,?,?,?);";
    $stmt = $mysqli->prepare($sql);
    $message['pubtime'] = time();
    $stmt->bind_param('ssssi', $message['username'],$message['email'],$message['face'],$message['content'],$message['pubtime']);
    $stmt->execute();
    if ($stmt->insert_id) {
        echo json_encode(array('status' => 1, 'html' => Message::output($message)));
    } else {
        echo '{"status":0,"errors":'.json_encode('Inserted faild').'}';
    }
} else {
    echo '{"status":0,"errors":'.json_encode($message).'}';
}

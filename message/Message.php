<?php


class Message
{
    /**
     * validate the POST data
     * @param  array $validatedMessage
     * @return boolean                   
     */
    public static function validate(&$validatedMessage)
    {
        if (! ($message['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
            $errors['email'] = 'Invalid email.';
        }
        if (! ($message['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING))) {
            $errors['content'] = 'Invalid message.';
        }
        if (! ($message['username'] = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING))) {
            $errors['username'] = 'Invalid name.';
        }
        $options = array(
            'options' => array(
                'min_range' => 1,
                'max_range' => 9
            )
        );
        if (! ($message['face'] = filter_input(INPUT_POST, 'face', FILTER_VALIDATE_INT, $options))) {
            $errors['face'] = 'Choose a head portrait please.';
        }

        if (empty($errors)) {
            $validatedMessage = $message;
            $validatedMessage['email'] = strtolower(trim($validatedMessage['email']));
            return true;
        } else {
            $validatedMessage = $errors;
            return false;
        }
    }

    public static function output($message)
    {
        $dateStr = date("Y-m-d H:i", $message['pubtime']);
        $msgStr = <<<EOF
        <div class='message'>
            <div class='face'>
            <a>
                <img width='50' height='50' src="img/{$message['face']}.jpg" />
            </a>
            </div>
            <div class='username'>
                <a>{$message['username']}</a>
            </div>
            <div class='date' title='post {$dateStr}'>
                {$dateStr}
            </div>
            <p>{$message['content']}</p>
        </div>
EOF;
        return $msgStr;
    }
}

<?php
    require_once 'Message.php';
    require_once 'connectDb.php';

    $sql = "SELECT `username`, `email`, `face`, `content`, `pubtime` FROM `message` ORDER BY `pubtime` DESC";
    $sqlResult = $mysqli->query($sql);
    if ($sqlResult && $sqlResult->num_rows > 0) {
        while ($row = $sqlResult->fetch_assoc()) {
            $messages[] = $row;
        }
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>MESSAGE</h1>

    <div id="wrap">
        <div id="main">
            <form action="" method="post" id="form">
                <div>
                    <label for="username">username</label>
                    <input type="text" id="username" name="username" placeholder="Your name.." required>

                    <label for="face">Face</label>
                    <div id="face">
                        <?php for($i=1;$i<9;$i++): ?>
                            <input type="radio" name="face" value="<?php echo $i; ?>" id="<?php echo $i; ?>">
                            <label for="<?php echo $i; ?>">
                                <img src="img/<?php echo $i; ?>.jpg" alt="" width="78" height="78"/>
                            </label>
                        <?php endfor; ?>
                    </div>

                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required placeholder="a valid email.." />

                    <label for="content">Comment:</label>
                    <textarea name="content" rows="10" cols="20" id="content" required placeholder="Say something.."></textarea>

                    <input type="submit" id="submit" value="Send">
                </div>
            </form>
        </div>

        <?php
            if (isset($messages)) {
                foreach ($messages as $message) {
                    echo Message::output($message);
                }
            }
         ?>
    </div>
    <script type="text/javascript" src='js/jquery.min.js'></script>
    <script type="text/javascript" src='js/message.js'></script>
</body>
</html>

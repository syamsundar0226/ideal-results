<?php
function isMobile() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = array('Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi');
    foreach ($mobile_agents as $mobile_agent) {
        if (strpos($user_agent, $mobile_agent) !== false) {
            return true;
        }
    }
    return false;
}

if (!isMobile()) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Device Detection</title>
    <link rel = "icon" href = "../../ideal_logo.jpg" type = "image/x-icon">
</head>
<body style="background-color: lightgrey;">
    <p style="text-align: center; color: red;">NOTE...!</p>
    <br>
    <p style="text-align: center; color: black;"><b>Please switch to desktop view to access this page.</b></p>
    <img src="desptopimg.jpg" alt="Desktop guide Image" style="display: block; margin: auto; max-width: 80%; max-height: 80%;">
    <script>
        function promptDesktopView() {
            if (window.confirm("This page is best viewed on a desktop device. Do you want to switch to desktop view?")) {
            }
        }
        promptDesktopView();
    </script>
</body>
</html>
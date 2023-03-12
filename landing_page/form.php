<?
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die();
}

if (empty($_POST['email']) || empty($_POST['message']) || empty($_POST['h-captcha-response'])) {
    echo json_encode(array('status' => 'missing_params'));
    die();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array('status' => 'invalid_email'));
    die();
}

$verify = curl_init();
curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
curl_setopt($verify, CURLOPT_POST, true);
curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query(array('secret' => require('hcaptcha_key.php'), 'response' => $_POST['h-captcha-response'])));
curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($verify));

if($response->success) {
    if (mail("info@openmma.nl", "Form message from " . $_POST['email'], "Message from " . $_POST['email'] . ":\r\n\r\n" . $_POST['message'])) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'mail_not_sent'));
    }
    die();
} else {
    echo json_encode(array('status' => 'captcha_fail'));
    die();
}
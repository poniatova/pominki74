<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$name    = htmlspecialchars(trim(isset($_POST['name'])    ? $_POST['name']    : ''));
$phone   = htmlspecialchars(trim(isset($_POST['phone'])   ? $_POST['phone']   : ''));
$date    = htmlspecialchars(trim(isset($_POST['date'])    ? $_POST['date']    : ''));
$guests  = htmlspecialchars(trim(isset($_POST['guests'])  ? $_POST['guests']  : ''));
$pkg     = htmlspecialchars(trim(isset($_POST['pkg'])     ? $_POST['pkg']     : ''));
$addr    = htmlspecialchars(trim(isset($_POST['addr'])    ? $_POST['addr']    : ''));
$comment = htmlspecialchars(trim(isset($_POST['comment']) ? $_POST['comment'] : ''));

if (!$name || !$phone) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(array('ok' => false, 'error' => 'missing fields'));
    exit;
}

$to      = 'megaproekt.operdir@gmail.com';
$subject = '=?UTF-8?B?' . base64_encode('Новая заявка с сайта pominki74.ru') . '?=';

$body  = "Новая заявка с сайта pominki74.ru\n\n";
$body .= "Имя: " . $name . "\n";
$body .= "Телефон: " . $phone . "\n";
if ($date)    $body .= "Дата: " . $date . "\n";
if ($guests)  $body .= "Гостей: " . $guests . "\n";
if ($pkg)     $body .= "Пакет: " . $pkg . "\n";
if ($addr)    $body .= "Адрес/доставка: " . $addr . "\n";
if ($comment) $body .= "Пожелания: " . $comment . "\n";

$headers  = "From: no-reply@pominki74.ru\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($to, $subject, $body, $headers);

header('Content-Type: application/json');
echo json_encode(array('ok' => $sent));

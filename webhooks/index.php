<?php
date_default_timezone_set('Europe/Moscow');

if (isset($_SERVER['HTTP_X_HOOK_SECRET'])) {
    $log = date(DATE_ATOM);
    $log .= ': secret: '.$_SERVER['HTTP_X_HOOK_SECRET'].PHP_EOL;
    file_put_contents('logs.txt', $log, FILE_APPEND);

    header(sprintf('HTTP/1.1 %s %s', 204, 'No Content'));
    header('X-Hook-secret: '.$_SERVER['HTTP_X_HOOK_SECRET']);
    die;
}
if (isset($_SERVER['HTTP_X_HOOK_SIGNATURE'])) {
    $log = date(DATE_ATOM);
    $log .= ': signature: '.$_SERVER['HTTP_X_HOOK_SIGNATURE'];
    $log .= ' input: '.file_get_contents('php://input').PHP_EOL;
    file_put_contents('logs.txt', $log, FILE_APPEND);

    header(sprintf('HTTP/1.1 %s %s', 200, 'OK'));
    die;
}
header(sprintf('HTTP/1.1 %s %s', 400, 'Bad Request'));
header('Content-Type: application/json');
echo "{'code': 400, 'error': 'bad request'}".PHP_EOL;
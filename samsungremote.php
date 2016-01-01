<?
$tvIP = "10.0.1.3"; // IP address of your TV
$myIP = "10.0.1.8"; // IP address of this app in local network
$myMAC = "A4:4E:31:44:E5:04"; // Used for the access control/validation
$appString = "iphone..iapp.samsung"; // This app string (iphone should be recognizable by all TV sets)
$tvAppString = "iphone.LE40C650.iapp.samsung"; // Your TV type
$remoteName = "Samsung PHP Remote"; // Displayed first time while permission request on your TV

$sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
$result = socket_connect($sock, $tvIP, '55000');
if ($result === false) {
    die ("Could not create socket: \n");
}

$myIPEncoded = base64_encode($myIP);
$myMACEncoded = base64_encode($myMAC);
$messagePart1 = chr(0x64) . chr(0x00) . chr(strlen($myIPEncoded)) . chr(0x00) . $myIPEncoded . chr(strlen($myMACEncoded))
    . chr(0x00) . $myMACEncoded . chr(strlen(base64_encode($remoteName))) . chr(0x00) . base64_encode($remoteName);

$part1 = chr(0x00) . chr(strlen($appString)) . chr(0x00) . $appString . chr(strlen($messagePart1)) . chr(0x00) . $messagePart1;

socket_write($sock, $part1, strlen($part1));
$messagePart2 = chr(0xc8) . chr(0x00);
$part2 = chr(0x00) . chr(strlen($appString)) . chr(0x00) . $appString . chr(strlen($messagePart2)) . chr(0x00) . $messagePart2;
socket_write($sock, $part2, strlen($part2));
if (isset($_REQUEST["key"])) {
    $key = "KEY_" . $_REQUEST["key"];
    $messagePart3 = chr(0x00) . chr(0x00) . chr(0x00) . chr(strlen(base64_encode($key))) . chr(0x00) . base64_encode($key);
    $part3 = chr(0x00) . chr(strlen($tvAppString)) . chr(0x00) . $tvAppString . chr(strlen($messagePart3)) . chr(0x00) . $messagePart3;
    socket_write($sock, $part3, strlen($part3));
} else if (isset($_REQUEST["text"])) {
    $text = $_REQUEST["text"];
    $messagePart3 = chr(0x01) . chr(0x00) . chr(strlen(base64_encode($text))) . chr(0x00) . base64_encode($text);
    $part3 = chr(0x01) . chr(strlen($appString)) . chr(0x00) . $appString . chr(strlen($messagePart3)) . chr(0x00) . $messagePart3;
    socket_write($sock, $part3, strlen($part3));
}
socket_close($sock);

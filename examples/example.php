<?PHP 
/* Client Example */
include __DIR__ . "/../vendor/autoload.php";

$Key = 'TestKey_Develop2020';
$Callback = 'http://host-sn-53.galgo.io';

$Client = new \galgo\api\Client($Key, $Callback);

$Route = 'cas/providers/list';
$Args = [];
$Results = $Client->Get(  $Route, $Args );

var_dump($Results);

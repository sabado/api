<?PHP 
/* Client Example */
include __DIR__ . "/../vendor/autoload.php";

$Key = 'A Test Key';
$Callback = 'http://test-host.com';

$Client = new \galgo\api\Client($Key, $Callback);

$Route = 'cas/providers/list';
$Args = [];
$Results = $Client->Get(  $Route, $Args );

var_dump($Results);

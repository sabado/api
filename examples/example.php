<?PHP 
/* Client Example */
include __DIR__ . "/../vendor/autoload.php";

$Key = 'A Test Key';
$Callback = 'http://test-host.come';

$Client = new \galgo\api\Client($Key, $Callback);

$Route = 'some/route';
$Args = [];
$Results = $Client->Get(  $Route, $Args );

var_dump($Results);

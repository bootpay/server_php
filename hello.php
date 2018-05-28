<?php
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

?>
<html>
<head>
    <title>PHP 테스트</title>
</head>
<body>
<script type="text/javascript">


</script>

<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO">
    <?php
    $instance = BootpayApi::setConfig('rest application_id', 'pk');
    $responseCancel = BootpayApi::cancel([
        'receipt_id' => 'receipt_id',
        'name' => 'name',
        'reason' => 'reason'
    ]);

    echo "status: {$responseCancel->status}, code: {$responseCancel->code}, message: {$responseCancel->message}";

    $responseConfirm = BootpayApi::confirm([
        'receipt_id' => 'receipt_id'
    ]);

    echo "status: {$responseConfirm->status}, code: {$responseConfirm->code}, message: {$responseConfirm->message}";
    ?>
</form>
</body>
</html>
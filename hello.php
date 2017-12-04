<?php
spl_autoload_register();

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
    BootpayApi::cancel([
        'receipt_id' => 'receipt_id',
        'name' => 'name',
        'reason' => 'reason'
    ]);

    BootpayApi::confirm([
        'receipt_id' => 'receipt_id'
    ]);
    ?>
</form>
</body>
</html>
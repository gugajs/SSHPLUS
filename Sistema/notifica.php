<?php
// IPN MERCADO PAGO BY @CRAZY_VPN
//ADICIONE O LINK DESSE ARQUIVO
//EM (https://www.mercadopago.com.br/developers/panel/notifications/ipn)
// Include Mercadopago
require_once('./lib/mercadopago.php');
$mp = new MP("CLIENT_ID_AQUI", "SECRET_ID_AQUI");
$params = ["access_token" => $mp->get_access_token()];
// Checa parametros
if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
	http_response_code(400);
	$erro1 = 'erro400';
	file_put_contents('erro.txt', $erro1, FILE_APPEND);
	return;
}

if($_GET["topic"] == 'payment'){
	$payment_info = $mp->get("/v1/payments/" . $_GET["id"], $params, false);
	$merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["order"]["id"], $params, false);
}else if($_GET["topic"] == 'merchant_order'){
	$merchant_order_info = $mp->get("/merchant_orders/" . $_GET["id"], $params, false);
}
if ($merchant_order_info["status"] == 200) {
	$transaction_amount_payments= 0;
	$transaction_amount_order = $merchant_order_info["response"]["total_amount"];
    $payments=$merchant_order_info["response"]["payments"];
    foreach ($payments as  $payment) {
    	if($payment['status'] == 'approved'){
	    	$transaction_amount_payments += $payment['transaction_amount'];
	    }	
    }
    $iduser=$merchant_order_info["response"]["external_reference"];
	$vlarray=$merchant_order_info["response"]["items"];
	
    foreach ($vlarray as $vlr) {
    	$quantia = $vlr["description"];
	}
    if($transaction_amount_payments >= $transaction_amount_order){
    	$idtran = $_GET["id"];
		file_put_contents('_file_/'.$iduser, $quantia, FILE_APPEND);
    }
}else{
    $linha = date('d/m/Y H:i:s') . ' Erro 2 '."\n";
    file_put_contents('erro.txt', $linha, FILE_APPEND);
}
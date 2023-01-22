<?php
//PAYMENT MERCADO PAGO BY @CRAZY_VPN
// Verifica o Get
if (!empty($_GET['id'])) {
    $refer_id = $_GET['id'];
    $limite = $_GET['login'];
} else {
    header("Location: https://www.google.com.br");
}
// Define variavel valor
if($limite == 1){
    $valorfinal=10;  //DEFINA COMO VALOR INTEIRO (EX 10) EQUIVALE 10R$
}elseif($limite == 2){
    $valorfinal=15; 
}elseif($limite == 3){
    $valorfinal=20; 
}else{
    header("Location: https://www.google.com.br");
}

// Faz a requicicao
require_once('./lib/mercadopago.php');
$mp = new MP ("CLIENT_ID_AQUI", "SECRET_ID_AQUI");
	$id=rand();
    $preference_data = array(
        "external_reference" => $refer_id,
        "items" => array( 
            array(
                "id" => $id,
                "title" => "LOGIN 30 DIAS",
                "currency_id" => "BRL",
                "picture_url" =>"https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
                "description" => $limite,
                "unit_price" => $valorfinal,
                "category_id" => "Category",
                "quantity" => 1,
            )
        )
    );
    $preference = $mp->create_preference($preference_data);
$MYURL = $preference["response"]["init_point"];
header('Location: '.$MYURL);

<?php
/*
tarayici url
http://localhost/mobileAppBackEnd/api/derslerApileri/create.php

ornek json
{
	"dersAdi" : "Ders 23",
	"dersKisaBaslik" : "Python ile tuple kullanimi",
	"dersKucukResim" : "http://www.meb.gov.tr/assets/images/header-meb-yeni-logo.png"
}
*/


/*
gerekli headers(baslik) bildirimleri
burada icerik tipinin json olacagini bildirdim.
baglanti süresi 300 saniye
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//veritabani baglantisini ve uzerinde calisacagim nesnemi burada cagiriyorum
include_once '../config/database.php';
include_once '../objects/dersler.php';
 
// nesnelerimin bir örneğini olusturuyorum
$database = new Database();
$db = $database->getConnection();
 
$dersler = new Dersler($db);

//post metoduyla gonderilmis veriyi okuyorum
$data = json_decode(file_get_contents("php://input"));

//burada sadece gelen bilgiler istendiği gibi dolu mu diye kontrol yapiyorum
//validation ve sanitation burada degil dersler nesnesinin icindedir.
if( !empty($data->dersAdi) &&
    !empty($data->dersKisaBaslik) &&
    !empty($data->dersKucukResim)
  ){
    $dersler->dersAdi = $data->dersAdi;
    $dersler->dersKisaBaslik = $data->dersKisaBaslik;
    $dersler->dersKucukResim = $data->dersKucukResim;


    if($dersler->create()){
        // response code - 201 created olarak ayarladim
        http_response_code(201);
        //kullaniciya geribildirim yaptim
        echo json_encode(array("message" => "Ders eklendi."));
    }
    else{
        // set response code - 503 servis kullanilamaz hatasi dondurdum
        http_response_code(503);
    
        //kullaniciya geribildirim yaptim
        echo json_encode(array("message" => "Ders eklenemedi."));
    }
}else{
       // set response code - 400 bad request
    http_response_code(400);
 
    //kullaniciya geribildirim yaptim
    echo json_encode(array("message" => "Ders oluşturulamadı. Gönderilen bilgiler istendiği gibi degil."));
}

  




?>
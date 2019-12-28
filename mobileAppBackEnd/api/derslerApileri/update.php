<?php
/*
tarayici url
http://localhost/mobileAppBackEnd/api/derslerApileri/update.php

ornek json
{
	"id" : "2"
	"dersAdi" : "Ders 23",
	"dersKisaBaslik" : "Python ile tuple kullanimi",
	"dersKucukResim" : "http://www.meb.gov.tr/assets/images/header-meb-yeni-logo.png"
}
*/



/*
gerekli headers(baslik) bildirimleri
burada icerik tipinin json olacagini bildirdim.
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

//guncellenecek olan dersin id bilgisini diger bilgilerini aliyorum
$data = json_decode(file_get_contents("php://input"));
$dersler->dersAdi = $data->dersAdi;
$dersler->dersKisaBaslik = $data->dersKisaBaslik;
$dersler->dersKucukResim = $data->dersKucukResim;

//update islemi
if($dersler->update()){
    //200 işlem başarılı
    http_response_code(200);
    echo json_encode(array("message" => "Ders guncellendi."));
}
else{
    //503 servis erisilebilir degil
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Ders guncelleme basarisiz oldu."));
}
?>
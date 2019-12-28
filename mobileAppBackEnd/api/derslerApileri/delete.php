<?php 
/*
tarayici url
http://localhost/mobileAppBackEnd/api/derslerApileri/delete.php

ornek json
{
	"id" : "2"
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


$data = json_decode(file_get_contents("php://input"));

$dersler->id = $data->id;

if($dersler->delete()){
    //200 işlem başarılı
    http_response_code(200);
    echo json_encode(array("message" => "Ders silindi."));
}
else{
    //503 servis erisilebilir degil
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Ders silme basarisiz oldu."));
}


?>
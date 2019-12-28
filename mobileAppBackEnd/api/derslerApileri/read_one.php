<?php
/*
tarayici url
http://localhost/mobileAppBackEnd/api/derslerApileri/read_one.php?id=3


*/

/*
gerekli headers(baslik) bildirimleri
burada icerik tipinin json olacagini bildirdim.
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


//veritabani baglantisini ve uzerinde calisacagim nesnemi burada cagiriyorum
include_once '../config/database.php';
include_once '../objects/dersler.php';
 
// nesnelerimin bir örneğini olusturuyorum
$database = new Database();
$db = $database->getConnection();
 
$dersler = new Dersler($db);

//id bilgisine gore okuma yapiyorum
$dersler->id = isset($_GET['id']) ? $_GET['id'] : die();
$dersler->readOne();

if($dersler->dersAdi != null){
    $dersler_dizisi = array(
        "id" => $dersler->id,
        "dersAdi" => $dersler->dersAdi,
        "dersKisaBaslik" => $dersler->dersKisaBaslik,
        "dersKucukResim" => $dersler->dersKucukResim 
    );

    //200 işlem başarılı
    http_response_code(200);
    echo(json_encode($dersler_dizisi));
}
else{
    //kayit bulunamadi
    http_response_code(404);
    echo(json_encode(
        array(
            "message" => "Ders bulunamadı."
        )
    ));
}



?>


<?php
/*
tarayici url
http://localhost/mobileAppBackEnd/api/derslerApileri/read.php
*/



/*
gerekli headers(baslik) bildirimleri
burada icerik tipinin json olacagini bildirdim.
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//veritabani baglantisini ve uzerinde calisacagim nesnemi burada cagiriyorum
include_once '../config/database.php';
include_once '../objects/dersler.php';
 
// nesnelerimin bir örneğini olusturuyorum
$database = new Database();
$db = $database->getConnection();
 
$dersler = new Dersler($db);

//veritabanindan okuma islemi yapip bunlari json datasina dönüştürüyorum
$stmt = $dersler->read();
$num = $stmt->rowCount();

if($num > 0){
    $dersler_dizisi = array();
    //$dersler_dizisi["kayitlar"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $ders_item = array(
            "id" => $id,
            "dersAdi" => $dersAdi,
            "dersKisaBaslik" => $dersKisaBaslik,
            "dersKucukResim" => $dersKucukResim 
        );
        //array_push($dersler_dizisi["kayitlar"], $ders_item);
        array_push($dersler_dizisi,$ders_item);
    }

    //200 işlem başarılı
    http_response_code(200);
    echo(json_encode($dersler_dizisi));
}
else
{
    //kayit bulunamadi
    http_response_code(404);
    echo(json_encode(
        array(
            "message" => "Ders bulunamadı."
        )
    ));
}

?>
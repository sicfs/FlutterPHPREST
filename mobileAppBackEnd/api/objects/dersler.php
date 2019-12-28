<?php
class Dersler{
 
    //veritabani baglantisi ve tablo adi
    private $conn;
    private $table_name = "dersler";
 
    // nesnemde hangi veriler var?
    public $id;                 	//id
    public $dersAdi;               	//adi
    public $dersKisaBaslik;        	//aciklama
	public $dersKucukResim;			//ders icin kullanilabilecek kucuk bir gorsel (url'si)
 
    // nesnenin yaratılmasında veritabani baglantisinin verilmesini zorunlu tutuyorum
    public function __construct($db){
        $this->conn = $db;
    }



    /*
    veritabnindaki dersler tablosunun tamamini okur ve döndürür
    */
    function read(){
        $sorgu = "SELECT * from dersler";
        $stmt = $this->conn->prepare($sorgu);
        $stmt->execute();
        return $stmt;
    }


    /*
    veritabanina yeni gir kayit ekleme
    eger islem basariliysa true doner degilse false
    create

    NOT: sanitize ve validation islemleri bir web sitesindeki gibi yapilmistir.
    mobil uygulama icin daha sonrasinda gerekli guncellemeler yapilmalidir.
    su anki haliyle sadece web saldrilarina karsi guvenlidir.
    */
    function create(){
        $sorgu = "INSERT INTO " . $this->table_name . 
        " SET dersAdi = :dersAdi, dersKisaBaslik = :dersKisaBaslik, dersKucukResim = :dersKucukResim";
        
        $stmt = $this->conn->prepare($sorgu);

        //sanitize ve validation burada
        $this->dersAdi =        htmlspecialchars(strip_tags($this->dersAdi));
        $this->dersKisaBaslik = htmlspecialchars(strip_tags($this->dersKisaBaslik));
        $this->dersKucukResim = htmlspecialchars(strip_tags($this->dersKucukResim));

        //bilgileri sorguma bagliyorum
        $stmt->bindParam(":dersAdi", $this->dersAdi);
        $stmt->bindParam(":dersKisaBaslik", $this->dersKisaBaslik);
        $stmt->bindParam(":dersKucukResim", $this->dersKucukResim);

        if($stmt->execute()){
            return true;
        }

        return false;
    }


    /*
    sadece id bilgisine gore bir kayit okuma
    */
    function readOne(){
        $sorgu = "SELECT * FROM " . $this->table_name . " where id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sorgu);

        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->dersAdi = $row["dersAdi"];
        $this->dersKisaBaslik = $row["dersKisaBaslik"];
        $this->dersKucukResim = $row["dersKucukResim"];
    }


    /*
    update - guncelleme islemi
    islem basariliysa true degilse false dondurur
    */

    function update(){
        $sorgu = "UPDATE " . $this->table_name . 
        " SET dersAdi = :dersAdi, dersKisaBaslik = :dersKisaBaslik, dersKucukResim = :dersKucukResim" . 
        " WHERE id = :id";

        $stmt = $this->conn->prepare($sorgu);
        //sanitize ve validation burada
        $this->dersAdi =        htmlspecialchars(strip_tags($this->dersAdi));
        $this->dersKisaBaslik = htmlspecialchars(strip_tags($this->dersKisaBaslik));
        $this->dersKucukResim = htmlspecialchars(strip_tags($this->dersKucukResim));
        $this->id =             htmlspecialchars(strip_tags($this->id));

        //bilgileri sorguma bagliyorum
        $stmt->bindParam(":dersAdi", $this->dersAdi);
        $stmt->bindParam(":dersKisaBaslik", $this->dersKisaBaslik);
        $stmt->bindParam(":dersKucukResim", $this->dersKucukResim);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }


    /*
    silme islemi
    */
    function delete(){
        $sorgu = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($sorgu);

        //sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>
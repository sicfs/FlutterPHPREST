import 'dart:async';
import 'dart:convert';
import 'package:flutter/cupertino.dart';
import 'package:http/http.dart' as http;


class Ders{
  String id;
  String dersAdi;
  String dersKisaBaslik;
  String dersKucukResim;

  static final columns = ["id","dersAdi", "dersKisaBaslik", "dersKucukResim"];

  Ders({this.dersAdi, this.dersKisaBaslik, this.dersKucukResim});

  //yardimci metodlar (serialize and deserialize)
  factory Ders.fromMap(Map<String, dynamic> json){
    return Ders(
        dersAdi: json["dersAdi"],
        dersKisaBaslik: json["dersKisaBaslik"],
        dersKucukResim: json["dersKucukResim"]
    );
  }

  Map<String, dynamic> toMap() => {
    "id" : id,
    "dersAdi" : dersAdi,
    "dersKisaBaslik" : dersKisaBaslik,
    "dersKucukResim" : dersKucukResim
  };

}


//CRUD operation (ekle,listele,guncelle,sil) for rest_api
class DersRestApiProvider{
  final String apiBaseURL = "http://localhost/mobileAppBackEnd/api/derslerApileri/";
  Map<String, String> apiAdresleri = {
    "listele" : "read.php",
    "ekle" : "create.php",
    "sil" : "delete.php",
    "guncelle" : "update.php"
  };

  DersRestApiProvider();


  //CRUD
  Future<Ders> birDersGetir(int id) async{
    String url = "http://192.168.1.101:80/mobileAppBackEnd/api/derslerApileri/read_one.php?id=" + id.toString();
    final response = await http.get(url);
    if(response.statusCode == 200){
      return Ders.fromMap(json.decode(response.body));
    }
    else{
      throw Exception("Bilgiye erisim saglanamadi");
    }
  }

  Future<List<Ders>> TumDersleriListele() async{
    String url = "http://192.168.1.101:80/mobileAppBackEnd/api/derslerApileri/read.php";
    final response = await http.get(url);
    if(response.statusCode == 200){
      //List<Ders> dersler;
      //Map<String, dynamic> gelenVeriListesi = jsonDecode(response.body);
      //return gelenVeriListesi["kayitlari"].foreach((value) => Ders.fromMap(value));

      Iterable i = json.decode(response.body);
      List<Ders> dersler = i.map((data) => Ders.fromMap(data)).toList();
      return dersler;
    }
    else{
      throw Exception("Bilgiye erisim saglanamadi");
    }
  }

  void Ekle(Ders ders){
    debugPrint("ekle");
  }
}





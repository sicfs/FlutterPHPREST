import 'package:flutter/material.dart';
import 'package:flutter_rest_api_kullanimi/entities/entity_ders.dart';

class Dersler extends StatefulWidget {
  Dersler({Key key}) : super(key: key);

  @override
  _DerslerState createState() => _DerslerState();
}

class _DerslerState extends State<Dersler> {
  Future<Ders> ders;
  Future<List<Ders>> dersler;
  DersRestApiProvider dersProvider = DersRestApiProvider();

  @override
  void initState() {
    super.initState();
    ders = dersProvider.birDersGetir(1);
    dersler = dersProvider.TumDersleriListele();
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: <Widget>[
        Center(
          child: FutureBuilder<Ders>(
            future: ders,
            builder: (context, snapshot) {
              if (snapshot.hasData) {
                return Text(snapshot.data.dersKisaBaslik);
              } else if (snapshot.hasError) {
                return Text("${snapshot.error}");
              }

              return CircularProgressIndicator();
            },
          ),
        ),
        Center(
            child: FutureBuilder<List<Ders>>(
                future: dersler,
                builder: (context, snapshot) {
                  if (snapshot.hasData) {
                    //return Text(snapshot.data[0].dersKisaBaslik);

                    return ListView.builder(
                      scrollDirection: Axis.vertical,
                      shrinkWrap: true,
                      itemCount: snapshot.data.length,
                      itemBuilder: (BuildContext context, int index) {
                        return Card(
                          color: Colors.indigoAccent,
                          margin: EdgeInsets.all(10),
                          elevation: 10,
                          child: ListTile(
                            leading: CircleAvatar(
                              child: Icon(Icons.android),
                              radius: 24,
                            ),
                            title: Text(snapshot.data[index].dersAdi),
                            subtitle: Text(snapshot.data[index].dersKisaBaslik),
                            trailing: Image.network(snapshot.data[index].dersKucukResim),
                          ),
                        );
                      },
                    );
                  } else if (snapshot.hasError) {
                    return Text("${snapshot.error}");
                  }

                  return CircularProgressIndicator();
                })),
      ],
    );
  }
}

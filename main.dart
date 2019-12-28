import 'package:flutter/material.dart';
import "package:flutter_rest_api_kullanimi/pages/page_dersler.dart";

void main() => runApp(Tasiyici());


class Tasiyici extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    return MaterialApp(
      title: "Demo",
      home: Scaffold(
          appBar: AppBar(
            title: Text("Dinamik veri"),
          ),
          body: DersSecimi()
      ),
    );
  }
}


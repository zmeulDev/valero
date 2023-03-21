import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Car/addCar.dart';
import 'package:valero/pages/Car/editCar.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';

import '../../models/carModel.dart';

class ViewCar extends StatefulWidget {
  const ViewCar({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _ViewCar();
  }
}

class _ViewCar extends State<ViewCar> {
  final Stream<QuerySnapshot> collectionReference = CarsCrud.readCar();

  //FirebaseFirestore.instance.collection('Employee').snapshots();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: getAppBar('Garage'),
      body: StreamBuilder(
        stream: collectionReference,
        builder: (BuildContext context, AsyncSnapshot<QuerySnapshot> snapshot) {
          if (snapshot.hasData) {
            return Container(
              margin: const EdgeInsets.all(8),
              child: ListView(
                children: snapshot.data!.docs.map((car) {
                  return Container(
                    margin: const EdgeInsets.only(top: 12),
                    height: Get.height * 0.15,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(12),
                      color: tertiaryColor,
                    ),
                      child: Column(children: [
                        ListTile(
                          title: Text(
                            car["vin"],
                            style: style2,
                          ),
                          subtitle: Container(
                            child: (Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: <Widget>[
                                Text("Maker: " + car['maker'], style: style2),
                                Text("Model: " + car['model'], style: style2),
                              ],
                            )),
                          ),
                        ),
                        ButtonBar(
                          alignment: MainAxisAlignment.spaceBetween,
                          children: <Widget>[
                            TextButton(
                              child: const Text('Edit'),
                              onPressed: () {
                                Navigator.pushAndRemoveUntil<dynamic>(
                                  context,
                                  MaterialPageRoute<dynamic>(
                                    builder: (BuildContext context) => EditCar(
                                      car: Car(
                                          uid: car.id,
                                          vin: car["vin"],
                                          plates: car["plates"],
                                          maker: car["maker"],
                                          model: car["model"],
                                          year: car["year"],
                                          fuel: car["fuel"],
                                          inspection: car["inspection"],
                                          insurance: car["insurance"],
                                          vignette: car["vignette"],
                                          note: car["note"]

                                      ),
                                    ),
                                  ),
                                  (route) => true, //if you want to disable back feature set to false
                                );
                              },
                            ),
                            TextButton(
                              child: const Text('Delete'),
                              onPressed: () async {
                                var response = await CarsCrud.deleteCar(docId: car.id);
                                if (response.code != 200) {
                                  Helper.showSnack(context, response.message.toString(), color: fifthColor);
                                }
                              },
                            ),
                          ],
                        ),
                      ],),);
                }).toList(),
              ),
            );
          }

          return Container(
            child: Text(
              'empty',
              style: style2.copyWith(color: tertiaryColor),
            ),
          );
        },
      ),
    );
  }
}

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/models/carModel.dart';
import 'package:valero/pages/Car/editCar.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

class ViewCar extends StatefulWidget {
  const ViewCar({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _ViewCar();
  }
}

class _ViewCar extends State<ViewCar> {
  final Stream<QuerySnapshot> collectionReference = CarsCrud.readCar();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: getAppBar('Garage'),
      body: Container(
        margin: const EdgeInsets.all(8),
        child: StreamBuilder(
          stream: collectionReference,
          builder: (BuildContext context, AsyncSnapshot<QuerySnapshot> snapshot) {
            if (snapshot.hasData) {
              return ListView(
                children: snapshot.data!.docs.map((car) {
                  return Container(
                    margin: EdgeInsets.only(top: 8),
                    padding: EdgeInsets.all(8),
                    height: Get.height * 0.3,
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(12),
                      color: tertiaryColor,
                    ),
                    child: Column(
                      children: [
                        ClipOval(
                          child: Container(
                            height: 100,
                            width: 100,
                            color: secondaryColor,
                            child: SvgPicture.asset(
                              'assets/svg/car-driving.svg',
                            ),
                          ),
                        ),
                        Text(
                          car["plates"],
                          style: style2,
                        ),
                        ButtonBar(
                          alignment: MainAxisAlignment.spaceBetween,
                          children: <Widget>[
                            Text(
                              'Insurance: ${car["insurance"]}',
                              style: style2,
                            ),
                            Text(
                              'Inspection: ${car["inspection"]}',
                              style: style2,
                            ),
                            Text(
                              'Vignette: ${car["vignette"]}',
                              style: style2,
                            ),

                          ],
                        ),
                        ButtonBar(
                          alignment: MainAxisAlignment.spaceBetween,
                          children: <Widget>[
                            TextButton(
                              child: Text(
                                'Details',
                                style: style2,
                              ),
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
                                          note: car["note"]),
                                    ),
                                  ),
                                      (route) => true,
                                );
                              },
                            ),
                            TextButton(
                              child: Text(
                                'Delete',
                                style: style2,
                              ),
                              onPressed: () async {
                                var response = await CarsCrud.deleteCar(docId: car.id);
                                if (response.code != 200) {
                                  Helper.showSnack(context, response.message.toString(), color: fifthColor);
                                }
                              },
                            ),
                          ],
                        ),
                      ],
                    ),

                  );
                }).toList(),
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
      ),
    );
  }
}

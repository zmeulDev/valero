import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/models/carModel.dart';
import 'package:valero/pages/Car/addCar.dart';
import 'package:valero/pages/Car/carsCrud.dart';
import 'package:valero/pages/Car/editCar.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/createVerticalCard.dart';
import 'package:flutter_svg/flutter_svg.dart';

// https://github.com/niamulhasan/Flutter-Cards/tree/main/lib
// https://undraw.co/illustrations
// https://storyset.com/car

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
            if (!snapshot.hasData) {
              return CircularProgressIndicator();
            } else if (snapshot.data?.size == 0) {
              return Column(
                children: [
                  Text(
                    'There are no cars yet.',
                    style: style2.copyWith(color: tertiaryColor),
                  ),
                  TextButton(
                      onPressed: () {
                        Navigator.pushAndRemoveUntil<dynamic>(
                          context,
                          MaterialPageRoute<dynamic>(
                            builder: (BuildContext context) => AddCar(),
                          ),
                          (route) => false, //if you want to disable back feature set to false
                        );
                      },
                      child: const Text('Add new car')),
                  SvgPicture.asset(
                    'assets/svg/nodata-cuate.svg',
                    alignment: Alignment.bottomCenter,
                  ),
                ],
              );
            } else {
              return ListView(
                children: snapshot.data!.docs.map((car) {
                  return Stack(fit: StackFit.loose, children: [
                    CreateVerticalCard(
                      subTitle: car["model"],
                      title: car["plates"],
                      duration: car["year"],
                      color: tertiaryColor,
                      textColor: secondaryColor,
                      image: SvgPicture.asset(
                        'assets/svg/delorean.svg',
                        alignment: Alignment.topRight,
                      ),
                    ),
                    Positioned(
                      top: 105,
                      left: 295,
                      height: 35,
                      width: 80,
                      child: MaterialButton(
                        color: secondaryColor,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12.0),
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
                        child: Text("Details", style: style3.copyWith(color: fourthColor)),
                      ),
                    ),
                  ]);
                }).toList(),
              );
            }
          },
        ),
      ),
    );
  }
}

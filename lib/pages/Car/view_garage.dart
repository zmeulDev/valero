import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/models/car_model.dart';
import 'package:valero/pages/Car/add_car.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/Car/edit_car.dart';
import 'package:valero/pages/app_bar.dart';
import 'package:valero/utils/create_viewcar_card.dart';
import 'package:valero/utils/create_wide_card.dart';

// https://www.svgrepo.com/

class ViewGarage extends StatefulWidget {
  const ViewGarage({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _ViewGarage();
  }
}

class _ViewGarage extends State<ViewGarage> {
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
          builder:
              (BuildContext context, AsyncSnapshot<QuerySnapshot> snapshot) {
            if (!snapshot.hasData) {
              return const CircularProgressIndicator();
            } else if (snapshot.data?.size == 0) {
              return Column(
                children: [
                  CreateWideCard(
                    cardColor: Theme.of(context).colorScheme.secondaryContainer,
                    textColor: Theme.of(context).colorScheme.onSecondaryContainer,
                    subTitle: 'you have',
                    title: '0',
                    paragraph: 'cars',
                    image: SvgPicture.asset(
                      'assets/svg/garage.svg',
                      width: 65,
                      height: 65,
                    ),
                    buttonText: 'Add',
                    navigate: const AddCar(),
                  ),
                  SvgPicture.asset(
                    'assets/svg/nodata-cuate.svg',
                  ),
                ],
              );
            } else {
              return Column(children: [
                CreateWideCard(
                  cardColor: Theme.of(context).colorScheme.secondaryContainer,
                  textColor: Theme.of(context).colorScheme.onSecondaryContainer,
                  subTitle: 'you have',
                  title: snapshot.data!.docs.length.toString(),
                  paragraph: snapshot.data!.docs.length.isEqual(1)
                      ? 'car added'
                      : 'cars added',
                  image: SvgPicture.asset(
                    'assets/svg/garage.svg',
                    width: 65,
                    height: 65,
                  ),
                  buttonText: 'Add',
                  navigate: const AddCar(),
                ),
                SizedBox(
                  height: Get.height * 0.65,
                  child: GridView(
                    gridDelegate:
                        const SliverGridDelegateWithFixedCrossAxisCount(
                            crossAxisCount: 2,
                            crossAxisSpacing: 8,
                            childAspectRatio: 0.7),
                    children: snapshot.data!.docs.map((car) {
                      return CreateViewCarCard(
                        subTitle: car["model"].toString().isEmpty
                            ? car["maker"]
                            : car["model"],
                        title: car["plates"],
                        paragraph: car["year"],
                        image: SvgPicture.asset(
                          'assets/svg/offRoad.svg',
                        ),
                        buttonText: 'Details',
                        navigate: editCarButton(car),
                      );
                    }).toList(),
                  ),
                ),
              ]);
            }
          },
        ),
      ),
    );
  }

  Widget editCarButton(QueryDocumentSnapshot<Object?> car) {
    return EditCar(
      car: Car(
        uid: car.id,
        vin: car["vin"],
        plates: car["plates"],
        maker: car["maker"],
        model: car["model"],
        year: car["year"],
        fuel: car["fuel"],
        note: car["note"],
        inspection: car["inspection"].toDate(),
        insurance: car["insurance"].toDate(),
        vignette: car["vignette"].toDate(),
        maintenance: car["maintenance"].toDate(),
      ),
    );
  }
}

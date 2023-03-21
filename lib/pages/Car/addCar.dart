import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/inputwidget.dart';

class AddCar extends StatefulWidget {
  const AddCar({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _AddCar();
  }
}

class _AddCar extends State<AddCar> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();
  // car form fields
  final carVin = TextEditingController();
  final carPlates = TextEditingController();
  final carMaker = TextEditingController();
  final carModel = TextEditingController();
  final carYear = TextEditingController();
  final carFuel = TextEditingController();
  final carInspection = TextEditingController();
  final carInsurance = TextEditingController();
  final carVignette = TextEditingController();
  final carNote = TextEditingController();


  @override
  Widget build(BuildContext context) {

    final fieldVin = input('VIN', 'Car VIN number', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carVin);
    final fieldPlates = input('Plates', 'Car plates', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carPlates);
    final fieldMaker = input('Maker', 'Car maker', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carMaker);
    final fieldModel = input('Model', 'Car model', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carModel);
    final fieldYear = input('Year', 'Car year', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carYear);
    final fieldFuel = input('Fuel', 'Car fuel type', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carFuel);
    final fieldInspection = input('Inspection', 'Next inspection date', TextInputType.datetime, CupertinoIcons.arrow_up_down_circle, carInspection);
    final fieldInsurance = input('Insurance', 'Next insurance date', TextInputType.datetime, CupertinoIcons.arrow_up_down_circle, carInsurance);
    final fieldVignette = input('Vignette', 'Vignette expires on', TextInputType.datetime, CupertinoIcons.arrow_up_down_circle, carVignette);
    final fieldNote = input('Note', 'anything else', TextInputType.text, CupertinoIcons.arrow_up_down_circle, carNote);


    final viewListButton = TextButton(
        onPressed: () {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => ViewCar(),
            ),
            (route) => false, //To disable back feature set to false
          );
        },
        child: const Text('View all your cars'));

    final saveButton = Material(
      elevation: 2.0,
      borderRadius: BorderRadius.circular(12.0),
      color: tertiaryColor,
      child: MaterialButton(
        minWidth: MediaQuery.of(context).size.width,
        padding: const EdgeInsets.fromLTRB(20.0, 15.0, 20.0, 15.0),
        onPressed: () async {
          if (carVin.text.isEmpty) {
            Helper.showSnack(context, 'Car VIN not valid', color: fifthColor);
          } else {
            if (_formKey.currentState!.validate()) {
              var response = await CarsCrud.addCar(
                vin: carVin.text,
                maker: carMaker.text,
                model: carModel.text,
                plates: carPlates.text,
                year: carYear.text,
                fuel: carFuel.text,
                inspection: carInspection.text,
                insurance: carInsurance.text,
                vignette: carVignette.text,
                note: carNote.text,
              );
              if (response.code != 200) {
                Helper.showSnack(context, response.message.toString(), color: tertiaryColor);
              } else {
                Helper.showSnack(context, response.message.toString(), color: fifthColor);
              }
            }
          }
        },
        child: Text(
          "Save",
          style: style2.copyWith(color: fifthColor),
          textAlign: TextAlign.center,
        ),
      ),
    );

    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: getAppBar('Add car'),
      body: Form(
        key: _formKey,
        child:
        Column(
          children: [
            fieldVin,
            SizedBox(
              height: Get.height * 0.01,
            ),
            Row(
              children: [
                Expanded(
                  child: fieldPlates
                ),
                SizedBox(
                  width: Get.width * 0.02,
                ),
                Expanded(
                  child: fieldYear
                ),
              ],
            ),
            Row(
              children: [
                Expanded(
                    child: fieldMaker
                ),
                SizedBox(
                  width: Get.width * 0.02,
                ),
                Expanded(
                    child: fieldModel
                ),
              ],
            ),
            Row(
              children: [
                Expanded(
                    child: fieldInsurance
                ),
                SizedBox(
                  width: Get.width * 0.02,
                ),
                Expanded(
                    child: fieldInspection
                ),
              ],
            ),
            Row(
              children: [
                Expanded(
                    child: fieldFuel
                ),
                SizedBox(
                  width: Get.width * 0.02,
                ),
                Expanded(
                    child: fieldVignette
                ),
              ],
            ),
            fieldNote,
            saveButton,
          ],
        ),
      ),
    );
  }
}

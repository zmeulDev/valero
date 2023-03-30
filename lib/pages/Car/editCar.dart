import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/models/carModel.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Car/carsCrud.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/createInputField.dart';

class EditCar extends StatefulWidget {
  final Car? car;

  EditCar({Key? key, this.car}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _EditCar();
  }
}

class _EditCar extends State<EditCar> {
  bool isLoading = false;
  final docId = TextEditingController();
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

  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  @override
  void initState() {
    // TODO: implement initState
    docId.value = TextEditingValue(text: widget.car!.uid.toString());
    carVin.value = TextEditingValue(text: widget.car!.vin.toString());
    carPlates.value = TextEditingValue(text: widget.car!.plates.toString());
    carMaker.value = TextEditingValue(text: widget.car!.maker.toString());
    carModel.value = TextEditingValue(text: widget.car!.model.toString());
    carYear.value = TextEditingValue(text: widget.car!.year.toString());
    carFuel.value = TextEditingValue(text: widget.car!.fuel.toString());
    carInspection.value =
        TextEditingValue(text: widget.car!.inspection.toString());
    carInsurance.value =
        TextEditingValue(text: widget.car!.insurance.toString());
    carVignette.value = TextEditingValue(text: widget.car!.vignette.toString());
    carNote.value = TextEditingValue(text: widget.car!.note.toString());
  }

  @override
  Widget build(BuildContext context) {
    final fieldVin = inputField('VIN', 'Car VIN number', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carVin);
    final fieldPlates = inputField('Plates', 'Car plates', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carPlates);
    final fieldMaker = inputField('Maker', 'Car maker', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carMaker);
    final fieldModel = inputField('Model', 'Car model', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carModel);
    final fieldYear = inputField('Year', 'Car year', TextInputType.number,
        CupertinoIcons.arrow_up_down_circle, carYear);
    final fieldFuel = inputField('Fuel', 'Car fuel type', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carFuel);
    final fieldInspection = inputField(
        'Inspection',
        'Next inspection date',
        TextInputType.datetime,
        CupertinoIcons.arrow_up_down_circle,
        carInspection);
    final fieldInsurance = inputField(
        'Insurance',
        'Next insurance date',
        TextInputType.datetime,
        CupertinoIcons.arrow_up_down_circle,
        carInsurance);
    final fieldVignette = inputField(
        'Vignette',
        'Vignette expires on',
        TextInputType.datetime,
        CupertinoIcons.arrow_up_down_circle,
        carVignette);
    final fieldNote = inputField('Note', 'anything else', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carNote);

    final viewListButton = TextButton(
        onPressed: () {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => const ViewCar(),
            ),
            (route) => false, //if you want to disable back feature set to false
          );
        },
        child: const Text('View List of car'));

    final updateButon = Material(
      elevation: 2.0,
      borderRadius: BorderRadius.circular(12.0),
      color: tertiaryColor,
      child: MaterialButton(
        // TODO change width to Get
        minWidth: MediaQuery.of(context).size.width,
        padding: const EdgeInsets.fromLTRB(20.0, 15.0, 20.0, 15.0),
        onPressed: () async {
          if (carVin.text.isEmpty) {
            Helper.successMsg('VIN number is not valid');
          } else {
            if (_formKey.currentState!.validate()) {
              var response = await CarsCrud.updateCar(
                docId: docId.text,
                userId: UserModel().uid.toString(),
                vin: carVin.text.toUpperCase(),
                plates: carPlates.text.toUpperCase(),
                maker: carMaker.text.toUpperCase(),
                model: carModel.text.toUpperCase(),
                year: carYear.text,
                fuel: carFuel.text.toUpperCase(),
                inspection: carInspection.text,
                insurance: carInsurance.text,
                vignette: carVignette.text,
                note: carNote.text,
              );
              if (response.code != 200) {
                Helper.errorMsg(response.message.toString());
              } else {
                Helper.successMsg(response.message.toString());
              }
            }
          }
        },
        child: Text(
          "Update",
          style: style2.copyWith(color: fifthColor),
          textAlign: TextAlign.center,
        ),
      ),
    );

    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: getAppBar('Update car'),
      body: Form(
        key: _formKey,
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            children: [
              fieldVin,
              SizedBox(
                height: Get.height * 0.01,
              ),
              Row(
                children: [
                  Expanded(child: fieldPlates),
                  SizedBox(
                    width: Get.width * 0.02,
                  ),
                  Expanded(child: fieldYear),
                ],
              ),
              Row(
                children: [
                  Expanded(child: fieldMaker),
                  SizedBox(
                    width: Get.width * 0.02,
                  ),
                  Expanded(child: fieldModel),
                ],
              ),
              Row(
                children: [
                  Expanded(child: fieldInsurance),
                  SizedBox(
                    width: Get.width * 0.02,
                  ),
                  Expanded(child: fieldInspection),
                ],
              ),
              Row(
                children: [
                  Expanded(child: fieldFuel),
                  SizedBox(
                    width: Get.width * 0.02,
                  ),
                  Expanded(child: fieldVignette),
                ],
              ),
              fieldNote,
              updateButon,
              viewListButton,
              TextButton(
                child: Text(
                  'Delete',
                  style: style2,
                ),
                onPressed: () async {
                  var response = await CarsCrud.deleteCar(docId: docId.text);
                  if (response.code != 200) {
                    Helper.errorMsg(response.message.toString());
                  } else {
                    Helper.successMsg(response.message.toString());
                    PersistentNavBarNavigator.pushNewScreen(
                      context,
                      screen: const ViewCar(),
                      withNavBar: true,
                    );
                  }
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}

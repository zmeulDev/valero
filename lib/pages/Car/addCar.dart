import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Car/carsCrud.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/createInputField.dart';

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
    final fieldInspection = inputField('Inspection', 'Next inspection date',
        TextInputType.datetime, CupertinoIcons.alt, carInspection);
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

    final allCarsButton = Material(
      borderRadius: BorderRadius.circular(12.0),
      color: fourthColor,
      child: MaterialButton(
        minWidth: Get.width * 0.03,
        onPressed: () {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => const ViewCar(),
            ),
            (route) => false, //To disable back feature set to false
          );
        },
        child: Text(
          "My garage",
          style: style2,
          textAlign: TextAlign.center,
        ),
      ),
    );

    final saveButton = Material(
      borderRadius: BorderRadius.circular(12.0),
      color: tertiaryColor,
      child: MaterialButton(
        minWidth: Get.width * 0.02,
        onPressed: () async {
          if (carVin.text.isEmpty) {
            Helper.errorMsg('Invalid Vin number');
          } else {
            if (_formKey.currentState!.validate()) {
              var response = await CarsCrud.addCar(
                userId: UserModel().uid.toString(),
                vin: carVin.text.toUpperCase(),
                maker: carMaker.text.toUpperCase(),
                model: carModel.text.toUpperCase(),
                plates: carPlates.text.toUpperCase(),
                year: carYear.text,
                fuel: carFuel.text,
                inspection: carInspection.text,
                insurance: carInsurance.text,
                vignette: carVignette.text,
                note: carNote.text,
              );
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
            }
          }
        },
        child: Text(
          "Save",
          style: style2,
        ),
      ),
    );

    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: getAppBar('Add car'),
      body: Form(
        key: _formKey,
        child: Stack(
          children: [
            SvgPicture.asset('assets/svg/delorean.svg',
                alignment: Alignment.bottomCenter,
                width: Get.width,
                height: Get.height),
            Column(
              children: [
                Container(
                    padding: const EdgeInsets.all(15),
                    color: tertiaryColor,
                    child: fieldVin),
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
                Container(
                  margin: const EdgeInsets.all(8),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      allCarsButton,
                      SizedBox(
                        width: Get.width * 0.01,
                      ),
                      saveButton,
                    ],
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}

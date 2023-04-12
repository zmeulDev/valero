import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:line_icons/line_icons.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/models/car_model.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/Car/view_garage.dart';
import 'package:valero/pages/app_bar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/create_input_field.dart';

class EditCar extends StatefulWidget {
  final Car? car;

  const EditCar({Key? key, this.car}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _EditCar();
  }
}

class _EditCar extends State<EditCar> {
  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  @override
  void initState() {
    super.initState();
    // TODO: implement initState
    docId.value = TextEditingValue(text: widget.car!.uid.toString());
    carVin.value = TextEditingValue(text: widget.car!.vin.toString());
    carPlates.value = TextEditingValue(text: widget.car!.plates.toString());
    carMaker.value = TextEditingValue(text: widget.car!.maker.toString());
    carModel.value = TextEditingValue(text: widget.car!.model.toString());
    carYear.value = TextEditingValue(text: widget.car!.year.toString());
    carFuel.value = TextEditingValue(text: widget.car!.fuel.toString());
    carNote.value = TextEditingValue(text: widget.car!.note.toString());
  }

  bool isLoading = false;
  final docId = TextEditingController();
  final carVin = TextEditingController();
  final carPlates = TextEditingController();
  final carMaker = TextEditingController();
  final carModel = TextEditingController();
  final carYear = TextEditingController();
  final carFuel = TextEditingController();
  final carNote = TextEditingController();
  late DateTime? carInspectionDate = widget.car!.inspection!;
  late DateTime? carInsuranceDate = widget.car!.insurance!;
  late DateTime? carMaintenanceDate = widget.car!.maintenance!;
  late DateTime? carVignetteDate = widget.car!.vignette!;

  @override
  Widget build(BuildContext context) {
    final fieldVin = inputField(
        'VIN', 'Car VIN number', TextInputType.text, Icons.factory, carVin);
    final fieldPlates = inputField(
        'Plates', 'Car plates', TextInputType.text, Icons.factory, carPlates);
    final fieldMaker = inputField(
        'Maker', 'Car maker', TextInputType.text, Icons.factory, carMaker);
    final fieldModel = inputField(
        'Model', 'Car model', TextInputType.text, Icons.factory, carModel);
    final fieldYear = inputField(
        'Year', 'Car year', TextInputType.number, Icons.factory, carYear);
    final fieldFuel = inputField(
        'Fuel', 'Car fuel type', TextInputType.text, Icons.factory, carFuel);
    final fieldNote = inputField('Note', 'anything else', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carNote);

    final fieldInsurance = Stack(
      alignment: AlignmentDirectional.centerEnd,
      children: [
        Container(
          width: Get.width,
          padding: const EdgeInsets.only(left: 6, right: 5, top: 11, bottom: 11),
          decoration: BoxDecoration(
            color: widget.car!.insurance!.isBefore(DateTime.now())
                ? fifthColor
                : tertiaryColor,
            borderRadius: BorderRadius.circular(12.0),
          ),
          child: Text(
            'Insurance',
            style: style3,
          ),
        ),
        SizedBox(
          width: Get.width * 0.25,
          child: ElevatedButton.icon(
            style: elevatedButtonStyle,
            icon: const Icon(
              LineIcons.alternateShield,
              color: tertiaryColor,
            ),
            label: carInsuranceDate == null
                ? Text(
                    f.format(widget.car!.insurance!).toString(),
                    style: style3.copyWith(color: tertiaryColor),
                  )
                : Text(
                    f.format(carInsuranceDate!),
                    style: style3.copyWith(color: tertiaryColor),
                  ),
            onPressed: () {
              showDatePicker(
                      context: context,
                      initialDate: carInsuranceDate == null
                          ? widget.car!.insurance!
                          : carInsuranceDate!,
                      firstDate: DateTime(2021),
                      lastDate: DateTime(2035))
                  .then((date) {
                setState(() {
                  carInsuranceDate = date;
                });
              });
            },
          ),
        ),
      ],
    );

    final fieldInspection = Stack(
      alignment: AlignmentDirectional.centerEnd,
      children: [
        Container(
          width: Get.width,
          padding: const EdgeInsets.only(left: 6, right: 5, top: 11, bottom: 11),
          decoration: BoxDecoration(
            color: widget.car!.inspection!.isBefore(DateTime.now())
                ? fifthColor
                : tertiaryColor,
            borderRadius: BorderRadius.circular(12.0),
          ),
          child: Text(
            'Inspection',
            style: style3,
          ),
        ),
        SizedBox(
          width: Get.width * 0.25,
          child: ElevatedButton.icon(
            style: elevatedButtonStyle,
            icon: const Icon(
              LineIcons.alternateMedicalFile,
              color: tertiaryColor,
            ),
            label: carInspectionDate == null
                ? Text(
                    f.format(widget.car!.inspection!).toString(),
                    style: style3.copyWith(color: tertiaryColor),
                  )
                : Text(
                    f.format(carInspectionDate!),
                    style: style3.copyWith(color: tertiaryColor),
                  ),
            onPressed: () {
              showDatePicker(
                      context: context,
                      initialDate: carInspectionDate == null
                          ? widget.car!.inspection!
                          : carInspectionDate!,
                      firstDate: DateTime(2021),
                      lastDate: DateTime(2035))
                  .then((date) {
                setState(() {
                  carInspectionDate = date;
                });
              });
            },
          ),
        ),
      ],
    );

    final fieldMaintenance = Stack(
      alignment: AlignmentDirectional.centerEnd,
      children: [
        Container(
          width: Get.width,
          padding: const EdgeInsets.only(left: 6, right: 5, top: 11, bottom: 11),
          decoration: BoxDecoration(
            color: widget.car!.maintenance!.isBefore(DateTime.now())
                ? fifthColor
                : tertiaryColor,
            borderRadius: BorderRadius.circular(12.0),
          ),
          child: Text(
            'Maintenance',
            style: style3,
          ),
        ),
        SizedBox(
          width: Get.width * 0.25,
          child: ElevatedButton.icon(
            style: elevatedButtonStyle,
            icon: const Icon(
              LineIcons.wrench,
              color: tertiaryColor,
            ),
            label: carMaintenanceDate == null
                ? Text(
                    f.format(widget.car!.maintenance!).toString(),
                    style: style3.copyWith(color: tertiaryColor),
                  )
                : Text(
                    f.format(carMaintenanceDate!),
                    style: style3.copyWith(color: tertiaryColor),
                  ),
            onPressed: () {
              showDatePicker(
                      context: context,
                      initialDate: carMaintenanceDate == null
                          ? widget.car!.maintenance!
                          : carMaintenanceDate!,
                      firstDate: DateTime(2021),
                      lastDate: DateTime(2035))
                  .then((date) {
                setState(() {
                  carMaintenanceDate = date;
                });
              });
            },
          ),
        ),
      ],
    );

    final fieldVignette = Stack(
      alignment: AlignmentDirectional.centerEnd,
      children: [
        Container(
          width: Get.width,
          padding: const EdgeInsets.only(left: 6, right: 5, top: 11, bottom: 11),
          decoration: BoxDecoration(
            color: widget.car!.vignette!.isBefore(DateTime.now())
                ? fifthColor
                : tertiaryColor,
            borderRadius: BorderRadius.circular(12.0),
          ),
          child: Text(
            'Vignette',
            style: style3,
          ),
        ),
        SizedBox(
          width: Get.width * 0.25,
          child: ElevatedButton.icon(
            style: elevatedButtonStyle,
            icon: const Icon(
              LineIcons.passport,
              color: tertiaryColor,
            ),
            label: carVignetteDate == null
                ? Text(
                    f.format(widget.car!.vignette!).toString(),
                    style: style3.copyWith(color: tertiaryColor),
                  )
                : Text(
                    f.format(carVignetteDate!),
                    style: style3.copyWith(color: tertiaryColor),
                  ),
            onPressed: () {
              showDatePicker(
                      context: context,
                      initialDate: carVignetteDate == null
                          ? widget.car!.vignette!
                          : carVignetteDate!,
                      firstDate: DateTime(2021),
                      lastDate: DateTime(2035))
                  .then((date) {
                setState(() {
                  carVignetteDate = date;
                });
              });
            },
          ),
        ),
      ],
    );

    final viewListButton = TextButton(
        onPressed: () {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => const ViewGarage(),
            ),
            (route) => true, //if you want to disable back feature set to false
          );
        },
        child: const Text('View List of car'));

    final editCarButton = Material(
      elevation: 2.0,
      borderRadius: BorderRadius.circular(12.0),
      color: tertiaryColor,
      child: MaterialButton(
        minWidth: Get.width,
        padding: const EdgeInsets.fromLTRB(20.0, 15.0, 20.0, 15.0),
        onPressed: () async {
          if (carVin.text.isEmpty) {
            Helper.successMsg('VIN number is not valid');
          } else {
            if (_formKey.currentState!.validate()) {
              var response = await CarsCrud.editCar(
                docId: docId.text,
                userId: UserModel().uid.toString(),
                vin: carVin.text.toUpperCase(),
                plates: carPlates.text.toUpperCase(),
                maker: carMaker.text.toUpperCase(),
                model: carModel.text.toUpperCase(),
                year: carYear.text,
                fuel: carFuel.text.toUpperCase(),
                inspection: carInspectionDate,
                insurance: carInsuranceDate,
                vignette: carVignetteDate,
                maintenance: carMaintenanceDate,
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
      appBar: getAppBar('Edit car'),
      body: Form(
        key: _formKey,
        child: Column(
          children: [
            Container(
              color: tertiaryColor,
              padding: const EdgeInsets.all(8),
              child: fieldVin,
            ),
            Row(
              children: [
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.06,
                    child: fieldInspection),
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.06,
                    child: fieldInsurance),
              ],
            ),
            Row(
              children: [
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.06,
                    child: fieldMaintenance),
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.06,
                    child: fieldVignette),
              ],
            ),
            Row(
              children: [
                Expanded(child: fieldPlates),
                Expanded(child: fieldYear),
              ],
            ),
            Row(
              children: [
                Expanded(child: fieldMaker),
                Expanded(child: fieldModel),
              ],
            ),
            fieldNote,
            editCarButton,
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
                    screen: const ViewGarage(),
                    withNavBar: true,
                  );
                }
              },
            ),
          ],
        ),
      ),
    );
  }
}

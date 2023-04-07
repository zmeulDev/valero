import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/models/carModel.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Car/carsCrud.dart';
import 'package:valero/pages/Car/viewGarage.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/createInputField.dart';

class EditCar extends StatefulWidget {
  final Car? car;

  const EditCar({Key? key, this.car}) : super(key: key);

  @override
  State<StatefulWidget> createState() {
    return _EditCar();
  }
}

class _EditCar extends State<EditCar> {

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
    widget.car!.vignette;
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

  final carInspection = TextEditingController();
  final carInsurance = TextEditingController();
  final carMaintenance = TextEditingController();
  final carVignette = TextEditingController();


  late DateTime? carInspectionDate = widget.car!.inspection!;
  late DateTime? carInsuranceDate = widget.car!.insurance!;
  late DateTime? carMaintenanceDate = widget.car!.maintenance!;
  late DateTime? carVignetteDate = widget.car!.vignette!;

  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();



  @override
  Widget build(BuildContext context) {
    final fieldVin = inputField('VIN', 'Car VIN number', TextInputType.text,
        Icons.factory, carVin);
    final fieldPlates = inputField('Plates', 'Car plates', TextInputType.text,
        Icons.factory, carPlates);
    final fieldMaker = inputField('Maker', 'Car maker', TextInputType.text,
        Icons.factory, carMaker);
    final fieldModel = inputField('Model', 'Car model', TextInputType.text,
        Icons.factory, carModel);
    final fieldYear = inputField('Year', 'Car year', TextInputType.number,
        Icons.factory, carYear);
    final fieldFuel = inputField('Fuel', 'Car fuel type', TextInputType.text,
        Icons.factory, carFuel);
    final fieldNote = inputField('Note', 'anything else', TextInputType.text,
        CupertinoIcons.arrow_up_down_circle, carNote);



    final fieldInspection = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: const Icon(Icons.check_circle_outline, color: primaryColor,),
        label: carInspectionDate == null
            ? Text(f.format(widget.car!.inspection!).toString(), style: style3.copyWith(color: primaryColor),)
            : Text(f.format(carInspectionDate!), style: style3.copyWith(color: primaryColor),),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate: carInspectionDate == null ? widget.car!.inspection! : carInspectionDate!,
            firstDate: DateTime(2021),
            lastDate: DateTime(2035))
            .then((date) {
          setState(() {
            carInspectionDate = date;
          });
        });
      },
    );

    final fieldInsurance = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: const Icon(Icons.safety_check_sharp, color: primaryColor,),
      label: carInsuranceDate == null
          ? Text(f.format(widget.car!.insurance!).toString(), style: style3.copyWith(color: primaryColor),)
          : Text(f.format(carInsuranceDate!), style: style3.copyWith(color: primaryColor),),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate:
            carInsuranceDate == null ? widget.car!.insurance! : carInsuranceDate!,
            firstDate: DateTime(2021),
            lastDate: DateTime(2035))
            .then((date) {
          setState(() {
            carInsuranceDate = date;
          });
        });
      },
    );

    final fieldMaintenance = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: const Icon(Icons.checklist, color: primaryColor,),
      label: carMaintenanceDate == null
          ? Text(f.format(widget.car!.maintenance!).toString(), style: style3.copyWith(color: primaryColor),)
          : Text(f.format(carMaintenanceDate!), style: style3.copyWith(color: primaryColor),),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate:
            carMaintenanceDate == null ? widget.car!.maintenance! : carMaintenanceDate!,
            firstDate: DateTime(2021),
            lastDate: DateTime(2035))
            .then((date) {
          setState(() {
            carMaintenanceDate = date ?? widget.car!.maintenance!;
          });
        });
      },
    );

    final fieldVignette = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: const Icon(Icons.file_copy_sharp, color: primaryColor,),
      label: carVignetteDate == null
          ? Text(f.format(widget.car!.vignette!).toString(), style: style3.copyWith(color: primaryColor),)
          : Text(f.format(carVignetteDate!), style: style3.copyWith(color: primaryColor),),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate: carVignetteDate == null ? widget.car!.vignette! : carVignetteDate!,
            firstDate: DateTime(2021),
            lastDate: DateTime(2035))
            .then((date) {
          setState(() {
            carVignetteDate = date ;
          });
        });
      },
    );


    final viewListButton = TextButton(
        onPressed: () {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => const ViewGarage(),
            ),
            (route) => false, //if you want to disable back feature set to false
          );
        },
        child: const Text('View List of car'));

    final editCarButton = Material(
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
                  Expanded(child: fieldMaintenance),
                  SizedBox(
                    width: Get.width * 0.02,
                  ),
                  Expanded(child: fieldVignette),
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
      ),
    );
  }
}

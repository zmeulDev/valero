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
import 'package:valero/utils/create_input_field.dart';
import 'package:valero/utils/helper.dart';

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
    final fieldVin = valeroField(
        context, 'VIN', 'Car VIN number', TextInputType.text, LineIcons.digitalTachograph, carVin);
    final fieldPlates = valeroField(
        context, 'Plates', 'Car plates', TextInputType.text, LineIcons.icons, carPlates);
    final fieldMaker = valeroField(
        context, 'Maker', 'Car maker', TextInputType.text, LineIcons.car, carMaker);
    final fieldModel = valeroField(
        context, 'Model', 'Car model', TextInputType.text, LineIcons.carCrash, carModel);
    final fieldYear = valeroField(
        context, 'Year', 'Car year', TextInputType.number, LineIcons.calendar, carYear);
    final fieldFuel = valeroField(
        context, 'Fuel', 'Car fuel type', TextInputType.text, LineIcons.gasPump, carFuel);
    final fieldNote = valeroField(context, 'Note', 'anything else', TextInputType.text,
        LineIcons.stream, carNote);

    final fieldInsurance = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: Icon(
        LineIcons.alternateShield,
        color: Theme.of(context).colorScheme.onTertiary,
      ),
      label: carInsuranceDate == null
          ? Text(
        f.format(widget.car!.insurance!).toString(),
        style: style3.copyWith(color: Theme.of(context).colorScheme.onTertiary),
      )
          : Text(
        f.format(carInsuranceDate!),
        style: style3.copyWith(color: Theme.of(context).colorScheme.onTertiary),
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
    );

    final fieldInspection = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: Icon(
        LineIcons.alternateMedicalFile,
        color: Theme.of(context).colorScheme.tertiary,
      ),
      label: carInspectionDate == null
          ? Text(
        f.format(widget.car!.inspection!).toString(),
        style: style3.copyWith(color: Theme.of(context).colorScheme.tertiary),
      )
          : Text(
        f.format(carInspectionDate!),
        style: style3.copyWith(color: Theme.of(context).colorScheme.tertiary),
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
    );

    final fieldMaintenance = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: Icon(
        LineIcons.wrench,
        color: Theme.of(context).colorScheme.tertiary,
      ),
      label: carMaintenanceDate == null
          ? Text(
        f.format(widget.car!.maintenance!).toString(),
        style: style3.copyWith(color: Theme.of(context).colorScheme.tertiary),
      )
          : Text(
        f.format(carMaintenanceDate!),
        style: style3.copyWith(color: Theme.of(context).colorScheme.tertiary),
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
    );

    final fieldVignette = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: Icon(
        LineIcons.passport,
        color: Theme.of(context).colorScheme.tertiary,
      ),
      label: carVignetteDate == null
          ? Text(
        f.format(widget.car!.vignette!).toString(),
        style: style3.copyWith(color: Theme.of(context).colorScheme.tertiary),
      )
          : Text(
        f.format(carVignetteDate!),
        style: style3.copyWith(color: Theme.of(context).colorScheme.tertiary),
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
    );

    final viewAllCarsButton = Material(
      elevation: 2.0,
      borderRadius: BorderRadius.circular(12.0),
      color: Theme.of(context).colorScheme.secondary,
      child: MaterialButton(
        minWidth: Get.width * 0.02,
        padding: const EdgeInsets.fromLTRB(20.0, 15.0, 20.0, 15.0),
        onPressed: () async {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => const ViewGarage(),
            ),
                (route) => true, //if you want to disable back feature set to false
          );
        },
        child: Text(
          "View all cars",
          style: style2.copyWith(color: Theme.of(context).colorScheme.onError),
          textAlign: TextAlign.center,
        ),
      ),
    );

    final deleteCarButton = Material(
      elevation: 2.0,
      borderRadius: BorderRadius.circular(12.0),
      color: Theme.of(context).colorScheme.error,
      child: MaterialButton(
        minWidth: Get.width * 0.02,
        padding: const EdgeInsets.fromLTRB(20.0, 15.0, 20.0, 15.0),
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
        child: Text(
          "Delete car",
          style: style2.copyWith(color: Theme.of(context).colorScheme.onError),
          textAlign: TextAlign.center,
        ),
      ),
    );

    final updateCarButton = Material(
      elevation: 2.0,
      borderRadius: BorderRadius.circular(12.0),
      color: Theme.of(context).colorScheme.primary,
      child: MaterialButton(
        minWidth: Get.width * 0.02,
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
          "Update car",
          style: style2.copyWith(color: Theme.of(context).colorScheme.onError),
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
              color: Theme.of(context).colorScheme.outline,
              padding: const EdgeInsets.all(8),
              child: fieldVin,
            ),
            Row(
              children: [
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8, top: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.10,
                    child: fieldInspection),
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8, top: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.10,
                    child: fieldInsurance),
              ],
            ),
            Row(
              children: [
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8, top: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.10,
                    child: fieldMaintenance),
                Container(
                    margin: const EdgeInsets.only(right: 8, left: 8, top: 8),
                    width: Get.width * 0.46,
                    height: Get.height * 0.10,
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
            Container(
              margin: const EdgeInsets.all(8),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  viewAllCarsButton,
                  deleteCarButton,
                  updateCarButton,
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

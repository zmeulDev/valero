import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:line_icons/line_icons.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/Car/view_garage.dart';
import 'package:valero/pages/app_bar.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/create_input_field.dart';

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
  final carMaintenance = TextEditingController();
  final carVignette = TextEditingController();
  final carNote = TextEditingController();

  DateTime? carInspectionDate;
  DateTime? carInsuranceDate;
  DateTime? carMaintenanceDate;
  DateTime? carVignetteDate;



  @override
  Widget build(BuildContext context) {
    final fieldVin = valeroField(context, 'VIN', 'Car VIN number', TextInputType.text,
        Icons.factory, carVin);
    final fieldPlates = valeroField(context, 'Plates', 'Car plates', TextInputType.text,
        Icons.factory, carPlates);
    final fieldMaker = valeroField(context, 'Maker', 'Car maker', TextInputType.text,
        Icons.factory, carMaker);
    final fieldModel = valeroField(context, 'Model', 'Car model', TextInputType.text,
        Icons.factory, carModel);
    final fieldYear = valeroField(context, 'Year', 'Car year', TextInputType.number,
        Icons.factory, carYear);
    final fieldFuel = valeroField(context, 'Fuel', 'Car fuel type', TextInputType.text,
        Icons.factory, carFuel);

    final fieldInspection = ElevatedButton.icon(
      style: elevatedButtonStyle,
      icon: const Icon(LineIcons.alternateMedicalFile),
      label: carInspectionDate == null
          ? Text("Inspection", style: style2)
          : Text(f.format(carInspectionDate!), style: style2),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate:
            carInspectionDate == null ? DateTime.now() : carInspectionDate!,
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
      icon:  const Icon(LineIcons.alternateShield),
      label: carInsuranceDate == null
          ? Text("Insurance", style: style2)
          : Text(f.format(carInsuranceDate!), style: style2),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate:
            carInsuranceDate == null ? DateTime.now() : carInsuranceDate!,
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
      icon:  const Icon(LineIcons.wrench),
      label: carMaintenanceDate == null
          ? Text("Maintenance", style: style2)
          : Text(f.format(carMaintenanceDate!), style: style2),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate:
            carMaintenanceDate == null ? DateTime.now() : carMaintenanceDate!,
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
      icon:  const Icon(LineIcons.passport),
      label: carVignetteDate == null
          ? Text("Vignette", style: style2)
          : Text(f.format(carVignetteDate!), style: style2),
      onPressed: () {
        showDatePicker(
            context: context,
            initialDate:
            carVignetteDate == null ? DateTime.now() : carVignetteDate!,
            firstDate: DateTime(2021),
            lastDate: DateTime(2035))
            .then((date) {
          setState(() {
            carVignetteDate = date;
          });
        });
      },
    );

    final fieldNote = valeroField(context, 'Note', 'Anything else', TextInputType.text,
        Icons.factory, carNote);

    final allCarsButton = Material(
      color: darkColorScheme.secondaryContainer,
      borderRadius: BorderRadius.circular(12.0),
      child: MaterialButton(
        minWidth: Get.width * 0.03,
        onPressed: () {
          Navigator.pushAndRemoveUntil<dynamic>(
            context,
            MaterialPageRoute<dynamic>(
              builder: (BuildContext context) => const ViewGarage(),
            ),
            (route) => false, //To disable back feature set to false
          );
        },
        child: Text(
          "My garage",
          style: style2.copyWith(color: darkColorScheme.onSecondaryContainer),
          textAlign: TextAlign.center,
        ),
      ),
    );

    final saveButton = Material(
      color: darkColorScheme.primary,
      borderRadius: BorderRadius.circular(12.0),
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
                inspection: carInspectionDate ?? DateTime.now(),
                insurance: carInsuranceDate  ?? DateTime.now(),
                vignette: carVignetteDate  ?? DateTime.now(),
                maintenance: carMaintenanceDate  ?? DateTime.now(),
                note: carNote.text,
              );
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
            }
          }
        },
        child: Text(
          "Save",
          style: style2.copyWith(color: darkColorScheme.onPrimary),
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
            Column(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                Opacity(
                  opacity: 0.9,
                  child: SvgPicture.asset('assets/svg/add.svg',
                    fit: BoxFit.fitWidth,
                    width: Get.width * 0.85,),
                ),
              ],
            ),
            Column(
              children: [
                Container(
                  color: darkColorScheme.secondary,
                    padding: const EdgeInsets.all(15),
                    child: fieldVin),
                SizedBox(
                  height: Get.height * 0.01,
                ),
                Container(
                  margin: const EdgeInsets.all(8),
                  child: Row(
                    children: [
                      Expanded(child: fieldInspection
                      ),
                      SizedBox(
                        width: Get.width * 0.05,
                      ),
                      Expanded(child: fieldInsurance),
                    ],
                  ),
                ),
                Container(
                  margin: const EdgeInsets.all(8),
                  child: Row(
                    children: [
                      Expanded(child: fieldMaintenance),
                      SizedBox(
                        width: Get.width * 0.05,
                      ),
                      Expanded(child: fieldVignette),
                    ],
                  ),
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

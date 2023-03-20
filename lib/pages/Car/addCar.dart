import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
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
  final _car_name = TextEditingController();
  final _car_maker = TextEditingController();
  final _car_model = TextEditingController();


  @override
  Widget build(BuildContext context) {

    final nameField = input('Name', 'Car name', TextInputType.text, CupertinoIcons.arrow_up_down_circle, _car_name);
    final makerField = input('Maker', 'Car maker', TextInputType.text, CupertinoIcons.arrow_up_down_circle, _car_maker);
    final modelField = input('Model', 'Car model', TextInputType.text, CupertinoIcons.arrow_up_down_circle, _car_model);


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
          if (_car_name.text.isEmpty) {
            Helper.showSnack(context, 'car name not valid', color: fifthColor);
          } else {
            if (_formKey.currentState!.validate()) {
              var response = await CarsCrud.addCar(name: _car_name.text, maker: _car_maker.text, model: _car_model.text);
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
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Form(
            key: _formKey,
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  nameField,
                  const SizedBox(height: 25.0),
                  makerField,
                  const SizedBox(height: 35.0),
                  modelField,
                  viewListButton,
                  const SizedBox(height: 45.0),
                  saveButton ,
                  const SizedBox(height: 15.0),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

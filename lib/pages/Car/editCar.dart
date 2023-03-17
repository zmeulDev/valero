import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/models/carModel.dart';
import 'package:valero/pages/Car/cars_crud.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/inputwidget.dart';

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
  final _car_name = TextEditingController();
  final _car_maker = TextEditingController();
  final _car_model = TextEditingController();
  final _docid = TextEditingController();

  final GlobalKey<FormState> _formKey = GlobalKey<FormState>();

  @override
  void initState() {
    // TODO: implement initState
    _docid.value = TextEditingValue(text: widget.car!.uid.toString());
    _car_name.value = TextEditingValue(text: widget.car!.name.toString());
    _car_maker.value = TextEditingValue(text: widget.car!.maker.toString());
    _car_model.value = TextEditingValue(text: widget.car!.model.toString());
  }

  @override
  Widget build(BuildContext context) {
    final DocIDField = TextField(
        controller: _docid,
        readOnly: true,
        autofocus: false,
        decoration: InputDecoration(
            contentPadding: const EdgeInsets.fromLTRB(20.0, 15.0, 20.0, 15.0),
            hintText: "Name",
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(32.0))));

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
            (route) => false, //if you want to disable back feature set to false
          );
        },
        child: const Text('View List of car'));

    final updateButon = Material(
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
              var response = await CarsCrud.updateCar(name: _car_name.text, maker: _car_maker.text, model: _car_model.text, docId: _docid.text);
              if (response.code != 200) {
                Helper.showSnack(context, response.message.toString(), color: tertiaryColor);
              } else {
                Helper.showSnack(context, response.message.toString(), color: fifthColor);
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
                  DocIDField,
                  const SizedBox(height: 25.0),
                  nameField,
                  const SizedBox(height: 25.0),
                  makerField,
                  const SizedBox(height: 35.0),
                  modelField,
                  viewListButton,
                  const SizedBox(height: 45.0),
                  updateButon,
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

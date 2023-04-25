import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Home/widgets/hello_widget.dart';
import 'package:valero/pages/Home/widgets/inspection_widget.dart';
import 'package:valero/pages/Home/widgets/insurance_widget.dart';
import 'package:valero/pages/Home/widgets/maintenance_widget.dart';
import 'package:valero/pages/Home/widgets/note_widget.dart';
import 'package:valero/pages/Home/widgets/vignette_widget.dart';
import 'package:valero/pages/app_bar.dart';

class Home extends StatefulWidget {
  const Home({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar('home'),
      body: getBody(),
    );
  }

  getBody() {
    return Container(
      height: Get.height,
      width: Get.width,
      margin: const EdgeInsets.all(8),
      child: Column(
        children: [
          helloWidget(),
          Column(
            children: [
              SizedBox(
                height: Get.height * 0.03,
              ),
              Row(
                children: [
                  noteWidget(),
                ],
              ),
              Row(
                children: [
                  nextMaintenance(),
                  nextInsurance(),
                ],
              ),
              Row(
                children: [nextInspection(), nextVignette()],
              )
            ],
          ),
        ],
      ),
    );
  }
}

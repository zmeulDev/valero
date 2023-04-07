
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Car/widgets/helloWidget.dart';
import 'package:valero/pages/Car/widgets/nextInspectionWidget.dart';
import 'package:valero/pages/Car/widgets/nextInsuranceWidget.dart';
import 'package:valero/pages/Car/widgets/nextMaintenanceWidget.dart';
import 'package:valero/pages/Car/widgets/nextVignetteWidget.dart';
import 'package:valero/pages/Car/widgets/noteWidget.dart';
import 'package:valero/pages/appBar.dart';

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
                children: [ noteWidget(), ],
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

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/utils/constant.dart';

getAppBar(String screenName) {
  return AppBar(
    leading: Container(
      margin: EdgeInsets.all(8),
      height: Get.height * 0.06,
      width: Get.width * 0.06,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: fourthColor,
      ),
      child: IconButton(
          onPressed: () {},
          icon: const Icon(
            Icons.directions_car_sharp,
            color: primaryColor,
          )),
    ),
    backgroundColor: Colors.transparent,
    elevation: 0.0,
    centerTitle: true,
    title: Text(
      screenName,
      style: styleAppBar,
    ),
  );
}

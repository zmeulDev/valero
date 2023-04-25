import 'package:flutter/material.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';

getAppBar(String screenName) {
  return AppBar(
    leading: Builder(
      builder: (BuildContext context) {
        return const Center(
          child: Text(
            'V',
            style: TextStyle(
                fontFamily: 'Depot',  fontSize: 48),
          ),
        );
      },
    ),

    elevation: 0.0,
    centerTitle: true,
    title: Text(
      screenName,
      style: styleAppBar,
    ),
  );
}

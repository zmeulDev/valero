import 'package:flutter/material.dart';
import 'package:valero/utils/constant.dart';

getAppBar(String screenName) {
  return AppBar(
    leading: Builder(
      builder: (BuildContext context) {
        return const Center(
          child: Text(
            'V',
            style: TextStyle(
                fontFamily: 'Depot', color: tertiaryColor, fontSize: 48),
          ),
        );
      },
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

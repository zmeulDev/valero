import 'package:flutter/material.dart';
import 'package:valero/utils/constant.dart';

getAppBar(String screenName) {
  return AppBar(
    leading: Builder(
      builder: (BuildContext context) {
        return  Center(
          child: Text(
            'V',
            style: TextStyle(
                fontFamily: 'Depot',  fontSize: 48, color: Theme.of(context).colorScheme.primary),
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

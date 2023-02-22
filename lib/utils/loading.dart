import 'package:flutter/material.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:valero/utils/constant.dart';

Widget loading() {
  return SpinKitThreeBounce(
    size: 20.0,
    itemBuilder: (BuildContext context, int index) {
      return DecoratedBox(
        decoration: BoxDecoration(
          color: index.isEven ? tertiaryColor : primaryColor,
        ),
      );
    },
  );
}

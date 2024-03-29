import 'dart:developer';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:valero/utils/color_schemes.g.dart';

class Helper {
  static toScreen(context, screen) {
    Navigator.push(context, MaterialPageRoute(builder: (context) => screen));
  }

  static toReplacementScreen(context, screen) {
    Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => screen));
  }

  static circularProgress(context) {
     Center(
      child: CircularProgressIndicator(
        valueColor: AlwaysStoppedAnimation(darkColorScheme.tertiary),
      ),
    );
  }

  static showLog(message) {
    log("APP SAYS: $message");
  }

  static boxDecoration(Color color, double radius) {
    BoxDecoration(color: color, borderRadius: BorderRadius.all(Radius.circular(radius)));
  }
  
  static errorMsg(msg) {
    Fluttertoast.showToast(
        msg: msg,
        gravity: ToastGravity.TOP,
        backgroundColor: CupertinoColors.destructiveRed,
    );
  }

  static successMsg(msg) {
    Fluttertoast.showToast(
      msg: msg,
      gravity: ToastGravity.TOP,
      backgroundColor: CupertinoColors.activeGreen,
    );
  }

  static warningMsg(msg) {
    Fluttertoast.showToast(
      msg: msg,
      gravity: ToastGravity.TOP,
      backgroundColor: CupertinoColors.activeOrange,
    );
  }

  static infoMsg(msg) {
    Fluttertoast.showToast(
      msg: msg,
      gravity: ToastGravity.TOP,
      backgroundColor: CupertinoColors.activeBlue,
    );
  }
}

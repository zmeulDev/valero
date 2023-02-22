import 'dart:developer';
import 'package:flutter/material.dart';
import 'constant.dart';

class Helper {
  static setHeight(BuildContext context, {height: 1}) {
    return MediaQuery.of(context).size.height * height;
  }

  static setWidth(BuildContext context, {width: 1}) {
    return MediaQuery.of(context).size.width * width;
  }

  static toScreen(context, screen) {
    Navigator.push(context, MaterialPageRoute(builder: (context) => screen));
  }

  static toReplacementScreen(context, screen) {
    Navigator.pushReplacement(
        context, MaterialPageRoute(builder: (context) => screen));
  }

  static showSnack(context, message, {color: tertiaryColor, duration: 4}) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        content: Text(
          message,
          style: TextStyle(fontSize: 14),
        ),
        backgroundColor: color,
        duration: Duration(seconds: duration)));
  }

  static circulProggress(context) {
    const Center(
      child: CircularProgressIndicator(
        valueColor: AlwaysStoppedAnimation(tertiaryColor),
      ),
    );
  }

  static showLog(message) {
    log("APP SAYS: $message");
  }

  static boxDecoration(Color color, double radius) {
    BoxDecoration(
        color: color, borderRadius: BorderRadius.all(Radius.circular(radius)));
  }
}

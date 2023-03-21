import 'dart:math';

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';


const primaryColor = Color(0xFFFFFFFF);
const secondaryColor = Color(0xffedecd8);
const tertiaryColor = Color(0xFF016a41);
const fourthColor = Color(0xFF000000);
const fifthColor = Color(0xFFf8a125);

var styleLogin = GoogleFonts.roboto(
  fontSize: 34.0,
  color: primaryColor,
);

var styleAppBar = GoogleFonts.roboto(
  fontSize: 20.0,
  color: fourthColor,
  fontWeight: FontWeight.bold
);

var style1 = GoogleFonts.roboto(
  fontSize: 26.0,
  color: secondaryColor,
  fontWeight: FontWeight.bold,
  wordSpacing: 1,
  letterSpacing: 0.5,
);
var style2 = GoogleFonts.roboto(
  fontSize: 16.0,
  color: secondaryColor,
    fontWeight: FontWeight.w300
);
var style3 = GoogleFonts.roboto(
  fontSize: 13.0,
  color: primaryColor,
  fontWeight: FontWeight.w300
);

IconData getRandomIcon(){
  final List<IconData> iconData = <IconData>[Icons.call, Icons.school];
  final Random random = Random();
  const String chars = '0123456789ABCDEF';
  int length = 3;
  String hex = '0xe';
  while(length-- > 0) hex += chars[(random.nextInt(16)) | 0];
  return IconData(int.parse(hex), fontFamily: 'MaterialIcons');
}

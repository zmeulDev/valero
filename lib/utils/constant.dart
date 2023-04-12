import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';

const primaryColor = Color(0xFFe9eff9);
const secondaryColor = Color(0xffffffff);
const tertiaryColor = Color(0xFF001d47);
const fourthColor  = Color(0xFF0168ff);
const fifthColor = Color(0xFFf47f30);
const sixthColor = Color(0xFF9563fc);

final f = new DateFormat('dd MM yyyy');

var styleLogin = GoogleFonts.roboto(
  fontSize: 34.0,
  color: secondaryColor,
);

var styleAppBar = const TextStyle(
    fontFamily: 'Pure', color: tertiaryColor, fontSize: 24);

var style1 = const TextStyle(
  fontFamily: 'Pure',
  fontSize: 26.0,
  color: secondaryColor,
  fontWeight: FontWeight.bold,
  wordSpacing: 1,
  letterSpacing: 0.5,
);
var style2 = const TextStyle(
    fontFamily: 'Pure',
    fontSize: 16.0, color: secondaryColor, fontWeight: FontWeight.w300);
var style3 = const TextStyle(
    fontFamily: 'Pure',
    fontSize: 13.0, color: secondaryColor, fontWeight: FontWeight.w300);

final ButtonStyle elevatedButtonStyle =  ElevatedButton.styleFrom(
  backgroundColor: secondaryColor,
  elevation: 0,
  textStyle: style2.copyWith(color: primaryColor),
  shape: RoundedRectangleBorder(
    borderRadius: BorderRadius.circular(12.0),
  ),
);

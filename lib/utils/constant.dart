import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';

const primaryColor = Color(0xFF292942);
const secondaryColor = Color(0xfffaf8f0);
const tertiaryColor = Color(0xFF383856);
const fourthColor = Color(0xFF222325);
const fifthColor = Color(0xFFfd783b);
const sixthColor = Color(0xFFA8A8C7);

final f = new DateFormat('dd MM yyyy');

var styleLogin = GoogleFonts.roboto(
  fontSize: 34.0,
  color: secondaryColor,
);

var styleAppBar = GoogleFonts.roboto(
    fontSize: 20.0, color: secondaryColor, fontWeight: FontWeight.bold);

var style1 = GoogleFonts.roboto(
  fontSize: 26.0,
  color: secondaryColor,
  fontWeight: FontWeight.bold,
  wordSpacing: 1,
  letterSpacing: 0.5,
);
var style2 = GoogleFonts.roboto(
    fontSize: 16.0, color: secondaryColor, fontWeight: FontWeight.w300);
var style3 = GoogleFonts.roboto(
    fontSize: 13.0, color: secondaryColor, fontWeight: FontWeight.w300);

final ButtonStyle elevatedButtonStyle =  ElevatedButton.styleFrom(
  backgroundColor: secondaryColor,
  textStyle: style2.copyWith(color: primaryColor),
  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 15) ,
  shape: RoundedRectangleBorder(
    borderRadius: BorderRadius.circular(12.0),
  ),
);

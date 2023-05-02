import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:valero/utils/color_schemes.g.dart';


final f = DateFormat('dd MM yyyy');

var styleLogin = GoogleFonts.roboto(
  fontSize: 34.0,
);

var styleAppBar = const  TextStyle(
    fontFamily: 'Pure', fontSize: 24);

var style1 =  const TextStyle(
  fontFamily: 'Pure',
  fontSize: 22.0,
  fontWeight: FontWeight.bold,
);
var style2 = const  TextStyle(
    fontFamily: 'Pure',
    fontSize: 16.0,  fontWeight: FontWeight.w300);

var style3 = const   TextStyle(
    fontFamily: 'Pure',
    fontSize: 13.0,  fontWeight: FontWeight.w300);

final ButtonStyle elevatedButtonStyle =  ElevatedButton.styleFrom(
  foregroundColor: darkColorScheme.onSecondaryContainer,
  backgroundColor: darkColorScheme.secondaryContainer,
  padding: const EdgeInsets.all(16.0),
  elevation: 0,
  textStyle: style2,
  shape: RoundedRectangleBorder(
    borderRadius: BorderRadius.circular(12.0),
  ),
);

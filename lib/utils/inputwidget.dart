import 'package:flutter/material.dart';
import 'package:valero/utils/constant.dart';

Widget input(hintText, labelText, keyboardType, suffixIcon,
    TextEditingController controller) {
  return Container(
    child: TextField(
      controller: controller,
      cursorColor: tertiaryColor,
      cursorHeight: 20,
      keyboardType: keyboardType,
      decoration: InputDecoration(
        hintText: hintText,
        labelText: labelText,
        hintStyle: style2.copyWith(color: primaryColor.withOpacity(0.5)),
        labelStyle: style3.copyWith(color: tertiaryColor),
        contentPadding: EdgeInsets.only(left: 8, bottom: 12, right: 5, top: 5),
        suffixIcon: Icon(
          suffixIcon,
          color: primaryColor.withOpacity(0.5),
          size: 20,
        ),
        enabledBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: BorderSide(
            width: 1,
            color: primaryColor,
          ),
        ),
        focusedBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: BorderSide(
            width: 2,
            color: tertiaryColor.withOpacity(0.5),
          ),
        ),
      ),
      style: style2.copyWith(fontWeight: FontWeight.bold),
    ),
  );
}

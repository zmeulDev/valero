import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/utils/constant.dart';

Widget input(hintText, labelText, keyboardType, suffixIcon,
    TextEditingController controller, {readonly = false}) {


  return Container(
    margin: EdgeInsets.all(8),
    height: Get.height * 0.07,
    decoration: BoxDecoration(
      borderRadius: BorderRadius.circular(12),
      color: tertiaryColor,
    ),
    child: TextField(
      controller: controller,
      cursorColor: primaryColor,
      cursorHeight: 20,
      keyboardType: keyboardType,
      readOnly: readonly,
      decoration: InputDecoration(
        hintText: hintText,
        labelText: labelText,
        hintStyle: style3.copyWith(color: primaryColor.withOpacity(0.5)),
        labelStyle: style3.copyWith(color: primaryColor),
        contentPadding: const EdgeInsets.only(left: 10, bottom: 2, right: 4, top: 2),
        suffixIcon: Icon(
          suffixIcon,
          color: primaryColor.withOpacity(0.5),
          size: 20,
        ),
        enabledBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            width: 1,
            color: tertiaryColor,
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

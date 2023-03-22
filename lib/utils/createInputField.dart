import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/utils/constant.dart';

Widget inputField(hintText, labelText, keyboardType, suffixIcon,
    TextEditingController controller, {readonly = false}) {


  return Container(
    margin: const EdgeInsets.all(8),
    height: Get.height * 0.07,
    decoration: BoxDecoration(
      borderRadius: BorderRadius.circular(12),
      color: secondaryColor,
    ),
    child: TextFormField(
      controller: controller,
      cursorColor: tertiaryColor,
      cursorHeight: 20,
      keyboardType: keyboardType,
      readOnly: readonly,
      decoration: InputDecoration(
        hintText: hintText,
        labelText: labelText,
        hintStyle: style2.copyWith(color: fourthColor.withOpacity(0.5)),
        labelStyle: style3.copyWith(color: fourthColor),
        contentPadding: const EdgeInsets.only(left: 10, bottom: 2, right: 4, top: 6),
        suffixIcon: Icon(
          suffixIcon,
          color: tertiaryColor.withOpacity(0.5),
          size: 20,
        ),
        enabledBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            width: 1,
            color: secondaryColor,
          ),
        ),
        focusedBorder: UnderlineInputBorder(
          borderRadius: BorderRadius.circular(10),
          borderSide: BorderSide(
            width: 2,
            color: secondaryColor.withOpacity(0.5),
          ),
        ),
      ),
      style: style2.copyWith(color: tertiaryColor),
    ),
  );
}

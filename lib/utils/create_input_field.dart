import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';

Widget valeroField(hintText, labelText, keyboardType, suffixIcon,
    TextEditingController controller, {readonly = false}) {


  return Container(
    margin: const EdgeInsets.all(8),
    height: Get.height * 0.07,
    decoration: BoxDecoration(
      borderRadius: BorderRadius.circular(12),
      color: lightColorScheme.secondaryContainer
    ),
    child: TextFormField(
      controller: controller,
      cursorHeight: 20,
      keyboardType: keyboardType,
      readOnly: readonly,
      decoration: InputDecoration(
        hintText: hintText,
        labelText: labelText,
        hintStyle: style2.copyWith(color: lightColorScheme.onSurface),
        labelStyle: style3.copyWith(color: lightColorScheme.onSurface),
        contentPadding: const EdgeInsets.only(left: 10, bottom: 2, right: 4, top: 6),
        suffixIcon: Icon(
          suffixIcon,
          size: 20,
        ),
        border: InputBorder.none,
        focusedBorder: InputBorder.none,
        enabledBorder: InputBorder.none,
        errorBorder: InputBorder.none,
        disabledBorder: InputBorder.none,
      ),
      style: style2,
    ),
  );
}

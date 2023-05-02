import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/create_box_card.dart';


todayWidget() {
  return SizedBox(
    width: Get.width * 0.33,
    height: Get.height * 0.12,
    child: CreateBoxCard(
      textColor: darkColorScheme.onSecondary,
      cardColor: darkColorScheme.secondary,
      subTitle: 'Today is:',
      title: f.format(DateTime.now()).toString(),
      paragraph: '',
      image:  const Icon(LineIcons.safari, size: 56, ),
      buttonText: 'buttonText',
    ),
  );
}
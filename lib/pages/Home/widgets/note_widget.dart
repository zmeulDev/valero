import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/create_box_card.dart';


noteWidget() {
  return SizedBox(
    width: Get.width * 0.65,
    height: Get.height * 0.12,
    child: CreateBoxCard(
      textColor: lightColorScheme.onSecondary,
      cardColor: lightColorScheme.secondary,
      subTitle: 'Always',
      title: 'be careful',
      paragraph: 'its better!',
      image:  Icon(LineIcons.safari, size: 56, ),
      buttonText: 'buttonText',
    ),
  );
}
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/utils/create_box_card.dart';


noteWidget(context) {
  return SizedBox(
    width: Get.width * 0.63,
    height: Get.height * 0.12,
    child: CreateBoxCard(
      textColor: Theme.of(context).colorScheme.onSecondary,
      cardColor: Theme.of(context).colorScheme.secondary,
      subTitle: 'Always',
      title: 'be careful',
      paragraph: 'its better!',
      image:  const Icon(LineIcons.safari, size: 56, ),
      buttonText: 'buttonText',
    ),
  );
}
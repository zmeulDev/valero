import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/createBoxCard.dart';


noteWidget() {
  return SizedBox(
    width: Get.width * 0.65,
    height: Get.height * 0.12,
    child: CreateBoxCard(
      subTitle: 'Always',
      title: 'be careful',
      paragraph: 'its better!',
      color: secondaryColor,
      image: SvgPicture.asset(
        'assets/svg/notify.svg',
      ),
      textColor: const Color(0XFF3f67f2),
      buttonText: 'buttonText',
    ),
  );
}
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/utils/constant.dart';

class CreateHorizontalCard extends StatelessWidget {
  const CreateHorizontalCard(
      {Key? key, required this.level, required this.title, required this.duration, required this.color, required this.image, required this.textColor})
      : super(key: key);

  final String level;
  final String title;
  final String duration;
  final Color color;
  final SvgPicture image;
  final Color textColor;

  @override
  Widget build(BuildContext context) {
    return Container(
      height: Get.height * 0.11,
      child: Card(
        color: color,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        child: Stack(
          children: [
            Align(
              alignment: Alignment.center,
              child: Container(
                child: image,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(28, 55, 0, 0),
              child: Text(
                level,
                style: style2,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(25, 24, 0, 0),
              child: Text(
                title,
                style: style3,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(275, 26, 0, 0),
              child: MaterialButton(
                color: secondaryColor,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(18.0),
                ),
                onPressed: () {},
                child: Text("Start", style: style3.copyWith(color: fourthColor)),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

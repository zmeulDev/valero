import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:get/get.dart';
import 'package:valero/utils/constant.dart';

class CreateVerticalCard extends StatelessWidget {
  const CreateVerticalCard(
      { Key? key,
        required this.subTitle,
        required this.title,
        required this.duration,
        required this.color,
        required this.image,
        required this.textColor})
      : super(key: key);

  final String subTitle;
  final String title;
  final String duration;
  final Color color;
  final SvgPicture image;
  final Color textColor;

  @override
  Widget build(BuildContext context) {
    return Container(
        height: Get.height * 0.18,
        child: Padding(
          padding: EdgeInsets.all(5),
          child: Card(
              color: color,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              child: Stack(
                children: [
                  SizedBox(
                    height: Get.height * 0.11,
                    child: image,
                  ),
                  Padding(
                    padding: EdgeInsets.fromLTRB(18, 20, 0, 0),
                    child: Text(
                      subTitle,
                      style: style2,
                    ),
                  ),
                  Padding(
                    padding: EdgeInsets.fromLTRB(15, 40, 0, 0),
                    child: Text(
                      title,
                      style: style1,
                    ),
                  ),
                  Padding(
                    padding: EdgeInsets.fromLTRB(15, 70, 0, 0),
                    child: Text(
                      duration,
                      style: style3,
                    ),
                  ),
                ],
              )),
        ));
  }
}
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/utils/constant.dart';

class CreateBoxCard extends StatefulWidget {
  CreateBoxCard(
      {Key? key,
      required this.subTitle,
      required this.title,
      required this.paragraph,
      required this.color,
      required this.image,
      required this.textColor,
      required this.buttonText,
      this.navigate})
      : super(key: key);

  final String subTitle;
  final String title;
  final String paragraph;
  final Color color;
  final SvgPicture image;
  final Color textColor;
  final String buttonText;
  var navigate;

  @override
  State<CreateBoxCard> createState() => _CreateBoxCardState();
}

class _CreateBoxCardState extends State<CreateBoxCard> {
  navigateTo() {
    return PersistentNavBarNavigator.pushNewScreen(
      context,
      screen: widget.navigate,
      withNavBar: true,
    );
  }

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: Get.height * 0.12,
      width: Get.width * 0.48,
      child: Card(
        color: widget.color,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        child: Stack(
          children: [
            Opacity(
              opacity: 0.2,
              child: Container(
                child: widget.image,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(15, 10, 0, 0),
              child: Text(
                widget.subTitle,
                style: style3.copyWith(color: widget.textColor),
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(18, 21, 0, 0),
              child: Text(
                widget.title,
                style: style1.copyWith(color: widget.textColor),
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(15, 47, 0, 0),
              child: Text(
                widget.paragraph,
                style: style3.copyWith(color: widget.textColor),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

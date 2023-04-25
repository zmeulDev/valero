import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/utils/constant.dart';

class CreateWideCard extends StatefulWidget {
  CreateWideCard(
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
  State<CreateWideCard> createState() => _CreateWideCardState();
}

class _CreateWideCardState extends State<CreateWideCard> {
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
      height: Get.height * 0.11,
      child: Card(
        color: widget.color,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(12),
        ),
        child: Stack(
          children: [
            Align(
              alignment: Alignment.center,
              child: Container(
                child: widget.image,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(22, 20, 0, 0),
              child: Text(
                widget.subTitle,
                style: style3,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(28, 35, 0, 0),
              child: Text(
                widget.title,
                style: style1,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(17, 62, 0, 0),
              child: Text(
                widget.paragraph,
                style: style3,
              ),
            ),
            Padding(
              padding: const EdgeInsets.fromLTRB(285, 24, 0, 0),
              child: MaterialButton(
                color: secondaryColor,
                elevation: 0,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(12.0),
                ),
                onPressed: () => navigateTo(),
                child: Text(widget.buttonText,
                    style: style3.copyWith(color: tertiaryColor)),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

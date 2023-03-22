import 'package:flutter/material.dart';
import 'package:valero/utils/constant.dart';

class CreateHorizontalCard extends StatelessWidget {
  const CreateHorizontalCard(
      {Key? key,
        required this.level,
        required  this.title,
        required this.duration,
        required this.color,
        required this.image,
        required this.textColor})
      : super(key: key);

  final String level;
  final String title;
  final String duration;
  final Color color;
  final Image image;
  final Color textColor;

  @override
  Widget build(BuildContext context) {
    return Container(
        height: 120,
        child: Padding(
          padding: EdgeInsets.all(5),
          child: Card(
              color: color,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(10),
              ),
              child: Stack(
                children: [
                  Align(
                    alignment: Alignment.bottomCenter,
                    child: Container(
                      child: image,
                    ),
                  ),
                  Padding(
                    child: Text(
                      level,
                      style: TextStyle(
                          fontSize: 14,
                          color: textColor,
                          fontFamily: 'MontserratRegular'),
                    ),
                    padding: EdgeInsets.fromLTRB(28, 55, 0, 0),
                  ),
                  Padding(
                    child: Text(
                      title,
                      style: TextStyle(
                          fontSize: 22,
                          color: textColor,
                          fontFamily: 'MontserratBold'),
                    ),
                    padding: EdgeInsets.fromLTRB(25, 24, 0, 0),
                  ),
                  Padding(
                    child: MaterialButton(
                      color: Color(0xffEBEAEC),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18.0),
                      ),
                      onPressed: () {  },
                      child: Text(
                        "Start",
                        style: TextStyle(color: Color(0xffffffff)),
                      ),
                    ),
                    padding: EdgeInsets.fromLTRB(275, 26, 0, 0),
                  ),
                ],
              )),
        ));
  }
}
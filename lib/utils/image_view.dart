import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:photo_view/photo_view.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';

class ImageViewPage extends StatelessWidget {
  final String img;

  const ImageViewPage({Key? key, required this.img}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar(),
      backgroundColor: lightColorScheme.primary,
      extendBodyBehindAppBar: true,
      body: Center(
        child: PhotoView(
          backgroundDecoration:  BoxDecoration(
            color: lightColorScheme.primary,
          ),
          imageProvider: AssetImage("$img"),
        ),
      ),
    );
  }

  getAppBar() {
    return AppBar(
      backgroundColor: lightColorScheme.primary,
      elevation: 0.0,
      leading: Center(
          child: IconButton(
        onPressed: () {
          Get.back();
        },
        icon:  Icon(
          Icons.arrow_back_ios,
          color: lightColorScheme.tertiary,
          size: 20,
        ),
      )),
    );
  }
}

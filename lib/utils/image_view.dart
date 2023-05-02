import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:photo_view/photo_view.dart';
import 'package:valero/utils/color_schemes.g.dart';

class ImageViewPage extends StatelessWidget {
  final String img;

  const ImageViewPage({Key? key, required this.img}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar(),
      backgroundColor: darkColorScheme.primary,
      extendBodyBehindAppBar: true,
      body: Center(
        child: PhotoView(
          backgroundDecoration:  BoxDecoration(
            color: darkColorScheme.primary,
          ),
          imageProvider: AssetImage(img),
        ),
      ),
    );
  }

  getAppBar() {
    return AppBar(
      backgroundColor: darkColorScheme.primary,
      elevation: 0.0,
      leading: Center(
          child: IconButton(
        onPressed: () {
          Get.back();
        },
        icon:  Icon(
          Icons.arrow_back_ios,
          color: darkColorScheme.tertiary,
          size: 20,
        ),
      )),
    );
  }
}

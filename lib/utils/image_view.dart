import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:photo_view/photo_view.dart';

class ImageViewPage extends StatelessWidget {
  final String img;

  const ImageViewPage({Key? key, required this.img}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar(context),
      backgroundColor: Theme.of(context).colorScheme.primary,
      extendBodyBehindAppBar: true,
      body: Center(
        child: PhotoView(
          backgroundDecoration:  BoxDecoration(
            color: Theme.of(context).colorScheme.primary,
          ),
          imageProvider: AssetImage(img),
        ),
      ),
    );
  }

  getAppBar(context) {
    return AppBar(
      backgroundColor: Theme.of(context).colorScheme.primary,
      elevation: 0.0,
      leading: Center(
          child: IconButton(
        onPressed: () {
          Get.back();
        },
        icon:  Icon(
          Icons.arrow_back_ios,
          color: Theme.of(context).colorScheme.tertiary,
          size: 20,
        ),
      )),
    );
  }
}

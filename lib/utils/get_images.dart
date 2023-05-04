import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:valero/utils/color_schemes.g.dart';

// ignore: must_be_immutable
class GetImage extends StatelessWidget {
  String imagePath;
  final double width;
  final double height;
  final BoxFit fit;
  final double radius;
  final bool isAssets;
  final bool isSvg;
  final Color loadingColor;

  GetImage(
      {Key? key, this.imagePath =
          'https://png.pngtree.com/element_our/png/20181206/users-vector-icon-png_260862.jpg',
      required this.width,
      required this.height,
      this.fit = BoxFit.cover,
      this.radius = 0.0,
      this.isAssets = false,
      this.isSvg = false,
      this.loadingColor =  Colors.grey
      }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    if (imagePath.isEmpty) {
      imagePath = 'assets/logo.png';
    }

    return ClipRRect(
      borderRadius: BorderRadius.circular(radius),
      child: isAssets
          ? SizedBox(
              height: height,
              width: width,
              child: Image.asset(
                imagePath,
                color: Theme.of(context).colorScheme.primary,
                width: width,
                height: height,
              ),
            )
          : CachedNetworkImage(
              imageUrl: imagePath,
              imageBuilder: (context, imageProvider) => Container(
                height: height,
                width: width,
                decoration: BoxDecoration(
                  border: Border.all(width: 0, color: Colors.transparent),
                  image: DecorationImage(
                    image: imageProvider,
                    fit: fit,
                  ),
                ),
              ),
              placeholder: (context, url) => SizedBox(
                height: height,
                width: width,
                child: const CircularProgressIndicator(),
              ),
              errorWidget: (context, url, error) =>  const Icon(Icons.error),
            ),
    );
  }
}

import 'package:avatar_view/avatar_view.dart';
import 'package:flutter/cupertino.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';

createAvatarWidget(double radius) {
  return UserModel().avatarUrl != ''
      ? AvatarView(
          radius: radius,
          borderColor: lightColorScheme.tertiary,
          avatarType: AvatarType.CIRCLE,
          backgroundColor: lightColorScheme.tertiary,
          imagePath: UserModel().avatarUrl,
          placeHolder: const Icon(CupertinoIcons.person),
          errorWidget: const Icon(
            CupertinoIcons.person,
          ))
      : ClipOval(
          child: Container(
            height: radius,
            width: radius,
            color: lightColorScheme.secondary,
            child: Icon(
              CupertinoIcons.person_alt_circle,
              size: radius,
            ),
          ),
        );
}

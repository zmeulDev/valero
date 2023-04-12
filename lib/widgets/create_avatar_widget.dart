import 'package:avatar_view/avatar_view.dart';
import 'package:flutter/cupertino.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/utils/constant.dart';

createAvatarWidget(double radius) {
  return UserModel().avatarUrl != ''
      ? AvatarView(
          radius: radius,
          borderColor: fourthColor,
          avatarType: AvatarType.CIRCLE,
          backgroundColor: tertiaryColor,
          imagePath: UserModel().avatarUrl,
          placeHolder: const Icon(CupertinoIcons.person),
          errorWidget: const Icon(
            CupertinoIcons.person,
          ))
      : ClipOval(
          child: Container(
            height: radius,
            width: radius,
            color: secondaryColor,
            child: Icon(
              CupertinoIcons.person_alt_circle,
              size: radius,
            ),
          ),
        );
}

import 'package:avatar_view/avatar_view.dart';
import 'package:flutter/cupertino.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/utils/color_schemes.g.dart';

createAvatarWidget(double radius) {
  return UserModel().avatarUrl != ''
      ? AvatarView(
          radius: radius,
          borderColor: darkColorScheme.surface,
          avatarType: AvatarType.CIRCLE,
          backgroundColor: darkColorScheme.surface,
          imagePath: UserModel().avatarUrl,
          placeHolder: const Icon(LineIcons.user),
          errorWidget: const Icon( LineIcons.user),)
      : ClipOval(
          child: Container(
            height: radius,
            width: radius,
            color: darkColorScheme.surfaceVariant,
            child: Icon(
              LineIcons.user,
              color: darkColorScheme.onSurface,
              size: radius,
            ),
          ),
        );
}

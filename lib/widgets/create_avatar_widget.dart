import 'package:avatar_view/avatar_view.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/models/user_model.dart';

createAvatarWidget(context, double radius) {
  return UserModel().avatarUrl != ''
      ? AvatarView(
          radius: radius,
          borderColor: Theme.of(context).colorScheme.surface,
          avatarType: AvatarType.CIRCLE,
          backgroundColor: Theme.of(context).colorScheme.surface,
          imagePath: UserModel().avatarUrl,
          placeHolder: const Icon(LineIcons.user),
          errorWidget: const Icon( LineIcons.user),)
      : ClipOval(
          child: Container(
            height: radius,
            width: radius,
            color: Theme.of(context).colorScheme.surfaceVariant,
            child: Icon(
              LineIcons.user,
              color: Theme.of(context).colorScheme.onSurface,
              size: radius,
            ),
          ),
        );
}

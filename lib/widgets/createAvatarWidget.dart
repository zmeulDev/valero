import 'package:avatar_view/avatar_view.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/utils/constant.dart';
import 'package:flutter/material.dart';

createAvatarWidget(double radius) {
  return UserModel().avatarUrl != ''
      ? AvatarView(
          radius: radius,
          borderColor: fourthColor,
          avatarType: AvatarType.CIRCLE,
          backgroundColor: tertiaryColor,
          imagePath: UserModel().avatarUrl,
          placeHolder: Icon(Icons.person,),
          errorWidget: Icon(Icons.person,))
      : ClipOval(
          child: Container(
            height: radius,
            width: radius,
            color: secondaryColor,
            child: Icon(
              Icons.person_2,
              size: radius,
            ),
          ),
        );
}


import 'package:flutter_svg/flutter_svg.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/UserProfile/viewProfile.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/createWideCard.dart';

helloWidget() {
  return CreateWideCard(
    subTitle: 'Hi',
    title: UserModel().userName != '' ? UserModel().userName : 'user',
    paragraph: 'welcome back!',
    color: tertiaryColor,
    image: SvgPicture.asset(
      'assets/svg/avatar.svg',
      height: 75,
      width: 75,
    ),
    textColor: primaryColor,
    buttonText: 'Profile',
    navigate: const Profile(),
  );
}
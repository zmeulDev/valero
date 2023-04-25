
import 'package:flutter_svg/flutter_svg.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/UserProfile/view_profile.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/create_wide_card.dart';

helloWidget() {
  return CreateWideCard(
    cardColor: lightColorScheme.primaryContainer,
    textColor: lightColorScheme.onPrimaryContainer,
    subTitle: 'Hi',
    title: UserModel().userName != '' ? UserModel().userName : 'user',
    paragraph: 'welcome back!',
    image: SvgPicture.asset(
      'assets/svg/avatar.svg',
      height: 70,
      width: 70,
    ),
    buttonText: 'Profile',
    navigate: const Profile(),
  );
}
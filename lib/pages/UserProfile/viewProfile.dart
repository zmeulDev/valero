import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Auth/welcome.dart';
import 'package:valero/pages/UserProfile/editProfile.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/pages/imageview.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

class Profile extends StatefulWidget {
  @override
  State<Profile> createState() => _ProfileState();
}

class _ProfileState extends State<Profile> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar('profile'),
      body: ListView(
        children: [
          Container(
            width: double.infinity,
            margin: const EdgeInsets.symmetric(vertical: 5, horizontal: 20),
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(10),
              color: tertiaryColor,
            ),
            child: Padding(
              padding: const EdgeInsets.all(20.0),
              child: Column(
                children: [
                  GestureDetector(
                    onTap: () {
                      Get.to(ImageViewPage(
                          img: UserModel().avatarUrl == ''
                              ? tempUserImg
                              : UserModel().avatarUrl));
                    },
                    child: createAvatarWidget(75),
                  ),
                  const SizedBox(
                    height: 10,
                  ),
                  UserModel().userName != ''
                      ? Text(
                          UserModel().userName,
                          style: style2.copyWith(
                              color: secondaryColor, fontSize: 14),
                        )
                      : Text(
                          ' Name',
                          style: style2.copyWith(
                              color: secondaryColor, fontSize: 14),
                        ),
                  UserModel().email != ''
                      ? Text(
                          UserModel().email,
                          style: style2.copyWith(
                              color: secondaryColor, fontSize: 14),
                        )
                      : Text(
                          'Email',
                          style: style2.copyWith(
                              color: secondaryColor, fontSize: 14),
                        ),
                  const SizedBox(
                    height: 5,
                  ),
                  Text(
                    UserModel().mobilePhone!,
                    style: style2.copyWith(
                        color: secondaryColor.withOpacity(0.7), fontSize: 14),
                  ),
                ],
              ),
            ),
          ),
          //Space
          const SizedBox(
            height: 20,
          ),
          Container(
            height: 44,
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: ElevatedButton(
                onPressed: () {
                  Get.to(const EditProfile())!.then((value) {
                    setState(() {});
                  });
                },
                style: ElevatedButton.styleFrom(
                  foregroundColor: Colors.white, backgroundColor: tertiaryColor,
                ),
                child: const Text('Edit')),
          ),
          const SizedBox(
            height: 20,
          ),
          Container(
            height: 44,
            padding: const EdgeInsets.symmetric(horizontal: 20),
            child: ElevatedButton(
                onPressed: () {
                  AuthServices.signOut().then((value) {
                    Helper.toReplacementScreen(context, ChooseLoginSignup());
                  });
                },
                style: ElevatedButton.styleFrom(
                  foregroundColor: Colors.white, backgroundColor: tertiaryColor,
                ),
                child: const Text('Logout')),
          ),
          //Space

        ],
      ),
    );
  }
}

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Auth/welcome.dart';
import 'package:valero/pages/UserProfile/editProfile.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

class Profile extends StatefulWidget {
  const Profile({Key? key}) : super(key: key);

  @override
  State<Profile> createState() => _ProfileState();
}

class _ProfileState extends State<Profile> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar('profile'),
      body: Column(
        children: [
          Container(
            width: double.infinity,
            margin: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(10),
              color: tertiaryColor,
            ),
            child: Padding(
              padding: const EdgeInsets.all(20.0),
              child: Column(
                children: [
                  createAvatarWidget(125),
                  SizedBox(
                    height: Get.height * 0.05,
                  ),
                  UserModel().userName != ''
                      ? Text(
                          UserModel().userName,
                          style: style2,
                        )
                      : Text(
                          'Your name',
                          style: style2,
                        ),
                  UserModel().email != ''
                      ? Text(
                          UserModel().email,
                          style: style2,
                        )
                      : Text(
                          'Your email',
                          style: style2,
                        ),
                  SizedBox(
                    height: Get.height * 0.02,
                  ),
                  Text(
                    UserModel().mobilePhone!,
                    style: style2.copyWith(color: secondaryColor.withOpacity(0.7)),
                  ),
                ],
              ),
            ),
          ),
          SizedBox(
            height: Get.height * 0.02,
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceEvenly,
            children: [
              ElevatedButton(
                  onPressed: () {
                    Get.to(const EditProfile())!.then((value) {
                      setState(() {});
                    });
                  },
                  style: ElevatedButton.styleFrom(
                      backgroundColor: tertiaryColor,
                      padding: const EdgeInsets.all(13),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                      )),
                  child: const Icon(
                    CupertinoIcons.pencil,
                    size: 30,
                    color: secondaryColor,
                  )),
              ElevatedButton(
                  onPressed: () {
                    AuthServices.signOut().whenComplete(() => Get.to(Welcome()));
                  },
                  style: ElevatedButton.styleFrom(
                      backgroundColor: tertiaryColor,
                      padding: const EdgeInsets.all(13),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                      )),
                  child: const Icon(
                    CupertinoIcons.arrow_right_square,
                    size: 30,
                    color: secondaryColor,
                  )),
            ],
          ),
        ],
      ),
    );
  }
}

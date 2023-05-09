import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Auth/login.dart';
import 'package:valero/pages/UserProfile/edit_profile.dart';
import 'package:valero/pages/app_bar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/widgets/create_avatar_widget.dart';

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
              color: Theme.of(context).colorScheme.primary,
            ),
            child: Padding(
              padding: const EdgeInsets.all(20.0),
              child: Column(
                children: [
                  createAvatarWidget(context, 125),
                  SizedBox(
                    height: Get.height * 0.05,
                  ),
                  UserModel().userName != ''
                      ? Text(
                          UserModel().userName,
                          style: style2.copyWith(color: Theme.of(context).colorScheme.onPrimary),
                        )
                      : Text(
                          'Your name',
                          style: style2.copyWith(color: Theme.of(context).colorScheme.onPrimary),
                        ),
                  UserModel().email != ''
                      ? Text(
                          UserModel().email,
                          style: style2.copyWith(color: Theme.of(context).colorScheme.onPrimary),
                        )
                      : Text(
                          'Your email',
                          style: style2.copyWith(color: Theme.of(context).colorScheme.onPrimary),
                        ),
                  SizedBox(
                    height: Get.height * 0.02,
                  ),
                  Text(
                    UserModel().mobilePhone.toString(),
                    style:
                        style2.copyWith(color: Theme.of(context).colorScheme.onPrimary.withOpacity(0.5)),
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
                      backgroundColor: Theme.of(context).colorScheme.primary,
                      padding: const EdgeInsets.all(13),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                      )),
                  child:  Icon(
                    CupertinoIcons.pencil,
                    size: 30,
                    color: Theme.of(context).colorScheme.onPrimary,
                  )),
              ElevatedButton(
                  onPressed: () {
                    AuthServices.signOut()
                        .whenComplete(() => Get.to(const Login()));
                  },
                  style: ElevatedButton.styleFrom(
                      backgroundColor: Theme.of(context).colorScheme.primary,
                      padding: const EdgeInsets.all(13),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(8),
                      )),
                  child:  Icon(
                    CupertinoIcons.arrow_right_square,
                    size: 30,
                    color: Theme.of(context).colorScheme.onPrimary,
                  )),
            ],
          ),
        ],
      ),
    );
  }
}

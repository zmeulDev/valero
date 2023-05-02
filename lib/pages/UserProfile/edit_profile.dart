import 'dart:io';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/app_bar.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/create_input_field.dart';
import 'package:valero/widgets/create_avatar_widget.dart';

class EditProfile extends StatefulWidget {
  const EditProfile({Key? key}) : super(key: key);

  @override
  _EditProfileState createState() => _EditProfileState();
}

class _EditProfileState extends State<EditProfile> {
  File? _image;
  bool isLoading = false;
  final picker = ImagePicker();
  TextEditingController nameController = TextEditingController();
  TextEditingController phoneNoController = TextEditingController();
  TextEditingController emailController = TextEditingController();
  String? userImg;

  updateData() async {
    setState(() {
      isLoading = true;
    });
    UserModel().userName = nameController.text;
    UserModel().mobilePhone = phoneNoController.text;
    UserModel().email = emailController.text;

    var res = _image == null
        ? await AuthServices.updateUserDatainFirestoreWithoutImage(
            UserModel().uid!)
        : await AuthServices.updateUserDatainFirestore(
            _image!, UserModel().uid!);
    if (res == "Success") {
      setState(() {
        isLoading = false;
      });
      Fluttertoast.cancel();
      Fluttertoast.showToast(
          msg: 'Data Updated Successfully', backgroundColor: darkColorScheme.onError);
      Get.back();
    } else {
      setState(() {
        isLoading = false;
      });
      Fluttertoast.cancel();
      Fluttertoast.showToast(msg: res.toString(), backgroundColor: darkColorScheme.onError);
    }
  }

  @override
  initState() {
    super.initState();
    userImg = UserModel().avatarUrl;
    if (UserModel().mobilePhone != null || UserModel().mobilePhone != "") {
      phoneNoController.text = UserModel().mobilePhone!;
    }
    if (UserModel().userName != "") {
      nameController.text = UserModel().userName;
    }
    if ( UserModel().email != "") {
      emailController.text = UserModel().email;
    }
  }

  Future getImage() async {
    final pickedFile =
        await picker.pickImage(source: ImageSource.gallery, imageQuality: 25);
    if (pickedFile != null) {
      setState(() {
        _image = File(pickedFile.path);
      });
    }
  }

  Widget displayImage() {
    if (_image == null) {
      return Container(
        height: Get.height * 0.15,
        width: Get.width * 0.32,
        decoration:  BoxDecoration(
          shape: BoxShape.circle,
          color: darkColorScheme.secondary,
        ),
        child: createAvatarWidget(125),
      );
    } else {
      return ClipRRect(
        borderRadius: BorderRadius.circular(75),
        child: Image.file(
          _image!,
          height: Get.height * 0.15,
          width: Get.width * 0.32,
          fit: BoxFit.cover,
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar('Edit profile'),
      body: SingleChildScrollView(
        physics: const BouncingScrollPhysics(),
        child: Column(
          children: [
            Stack(
              children: [
                displayImage(),
                Positioned(
                    right: 0,
                    bottom: 0,
                    child: CircleAvatar(
                      backgroundColor: darkColorScheme.secondary,
                      child: IconButton(
                        onPressed: () {
                          getImage();
                        },
                        icon:  Icon(
                          LineIcons.edit,
                          size: 20,
                          color: darkColorScheme.onSecondary,
                        ),
                        splashRadius: 5.0,
                        splashColor: Colors.grey,
                      ),
                    ))
              ],
            ),
            SizedBox(
              height: Get.height * 0.05,
            ),
            valeroField('Choose your name', 'UserName', TextInputType.text,
                LineIcons.user, nameController),
            valeroField('Choose your email', 'Email', TextInputType.emailAddress,
                LineIcons.envelope, emailController),
            valeroField('Phone', 'Phone cannot be changed', TextInputType.phone,
                LineIcons.phone, phoneNoController,
                readonly: true),
          ],
        ),
      ),
      bottomNavigationBar: Container(
        color: darkColorScheme.secondary,
        padding: const EdgeInsets.all(8),
        height: Get.height * 0.07,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: darkColorScheme.primary,
                shape: RoundedRectangleBorder(
                  side:  BorderSide(color: darkColorScheme.primary),
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
              onPressed: isLoading == true
                  ? () {}
                  : () {
                      Get.back();
                    },
              child: Text(
                'Cancel',
                style: style2.copyWith(color: darkColorScheme.tertiary),
              ),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: darkColorScheme.tertiary,
                shadowColor: Colors.transparent,
                shape: RoundedRectangleBorder(
                  side:  BorderSide(color: darkColorScheme.tertiary),
                  borderRadius: BorderRadius.circular(12),
                ),
              ),
              onPressed: () {
                updateData();
              },
              child: isLoading == true
                  ? const Center(
                      child: CircularProgressIndicator(
                      strokeWidth: 3.0,
                      valueColor: AlwaysStoppedAnimation(Colors.white),
                    ))
                  : Text(
                      'Update',
                      style: style2,
                    ),
            ),
          ],
        ),
      ),
    );
  }
}

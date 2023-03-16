import 'dart:io';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';
import 'package:valero/utils/inputwidget.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

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
    //UserModel().profileUrl = ?;
    var res = _image == null
        ? await AuthServices.updateUserDatainFirestoreWithoutImage(UserModel().uid!)
        : await AuthServices.updateUserDatainFirestore(_image!, UserModel().uid!);
    if (res == "Success") {
      setState(() {
        isLoading = false;
      });
      Helper.showSnack(context, "Data Updated Successfully");
      Get.back();
    } else {
      setState(() {
        isLoading = false;
      });
      Helper.showSnack(context, res.toString());
    }
  }

  @override
  initState() {
    super.initState();
    userImg = UserModel().avatarUrl;
    if (UserModel().mobilePhone != null || UserModel().mobilePhone != "") {
      phoneNoController.text = UserModel().mobilePhone!;
    }
    if (UserModel().userName != null || UserModel().userName != "") {
      nameController.text = UserModel().userName;
    }
    if (UserModel().email != null || UserModel().email != "") {
      emailController.text = UserModel().email;
    }
  }

  Future getImage() async {
    final pickedFile = await picker.pickImage(source: ImageSource.gallery, imageQuality: 10);
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
        decoration: const BoxDecoration(
          shape: BoxShape.circle,
          color: tertiaryColor,
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

                      backgroundColor: fourthColor,
                      child: IconButton(
                        onPressed: () {
                          getImage();
                        },
                        icon: const Icon(
                          Icons.edit_outlined,
                          size: 20,
                          color: secondaryColor,
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
            input('Choose your name', 'UserName', TextInputType.text, CupertinoIcons.person, nameController),
            input('Choose your email', 'Email', TextInputType.emailAddress, CupertinoIcons.envelope, emailController),
            input('Phone', 'Phone cannot be changed', TextInputType.phone, CupertinoIcons.phone, phoneNoController, readonly: true),
          ],
        ),
      ),
      bottomNavigationBar: Container(
        color: fourthColor,
        padding: EdgeInsets.all(8),
        height: 65,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: primaryColor,
                shape: RoundedRectangleBorder(
                  side: const BorderSide(color: primaryColor),
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
                style: style2.copyWith(color: fourthColor),
              ),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                primary: tertiaryColor,
                shadowColor: Colors.transparent,
                shape: RoundedRectangleBorder(
                  side: const BorderSide(color: tertiaryColor),
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

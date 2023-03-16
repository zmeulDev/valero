import 'dart:io';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/models/user_model.dart';
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
  bool isLoading = false;
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
        ? await AuthServices.updateUserDatainFirestoreWithoutImage(
            UserModel().uid!)
        : await AuthServices.updateUserDatainFirestore(
            _image!, UserModel().uid!);
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

  Widget displayImage() {
    if (_image == null) {
      return Container(
        height: 150,
        width: 150,
        decoration: BoxDecoration(
          shape: BoxShape.circle,
          color: tertiaryColor,
        ),
        child: createAvatarWidget(75),
      );
    } else {
      return ClipRRect(
        borderRadius: BorderRadius.circular(75),
        child: Image.file(
          _image!,
          fit: BoxFit.cover,
        ),
      );
    }
  }

  File? _image;

  final picker = ImagePicker();

  Future getImage() async {
    final pickedFile =
        await picker.pickImage(source: ImageSource.gallery, imageQuality: 10);
    if (pickedFile != null) {
      setState(() {
        _image = File(pickedFile.path);
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar(),
      body: SingleChildScrollView(
        physics: BouncingScrollPhysics(),
        child: Column(
          children: [
            SizedBox(
              height: 20,
            ),
            Stack(
              children: [
                Container(
                  height: 150,
                  width: 150,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    boxShadow: [
                      BoxShadow(
                        color: primaryColor.withOpacity(0.5),
                        spreadRadius: 1,
                        blurRadius: 1,
                        offset: Offset(1, 1), // changes position of shadow
                      ),
                    ],
                  ),
                  child: displayImage(),
                ),
                Positioned(
                    right: 0,
                    bottom: 0,
                    child: CircleAvatar(
                      backgroundColor: fourthColor,
                      child: IconButton(
                        onPressed: () {
                          getImage();
                        },
                        icon: Icon(
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
              height: 40,
            ),
            Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20.0),
                child: input('Choose your name', 'UserName', TextInputType.text,
                    CupertinoIcons.person, nameController)),
            Padding(
                padding: const EdgeInsets.symmetric(horizontal: 20.0),
                child: input(
                    'Choose your email',
                    'Email',
                    TextInputType.emailAddress,
                    CupertinoIcons.envelope,
                    emailController)),
            Padding(
              padding: const EdgeInsets.only(top: 10, left: 20, right: 20),
              child: TextField(
                controller: phoneNoController,
                readOnly: true,
                decoration: InputDecoration(
                  hintText: 'Phone number',
                  labelText: 'Phone number',
                  hintStyle:
                      style2.copyWith(color: primaryColor.withOpacity(0.5)),
                  labelStyle: style3.copyWith(color: tertiaryColor),
                  contentPadding:
                      EdgeInsets.only(left: 8, bottom: 12, right: 5, top: 5),
                  suffixIcon: Icon(
                    CupertinoIcons.phone,
                    color: primaryColor.withOpacity(0.5),
                    size: 20,
                  ),
                  enabledBorder: UnderlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide(
                      width: 1,
                      color: Colors.grey,
                    ),
                  ),
                  focusedBorder: UnderlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide(
                      width: 2,
                      color: Colors.grey,
                    ),
                  ),
                ),
                style: style2.copyWith(color: Colors.grey),
              ),
            ),
          ],
        ),
      ),
      bottomNavigationBar: Container(
        height: 50,
        width: double.infinity,
        margin: EdgeInsets.only(bottom: 20),
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: Row(
            children: [
              Expanded(
                child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    primary: Colors.transparent,
                    shadowColor: Colors.transparent,
                    shape: RoundedRectangleBorder(
                      side: BorderSide(color: primaryColor),
                      borderRadius: BorderRadius.circular(20),
                    ),
                  ),
                  onPressed: isLoading == true
                      ? () {}
                      : () {
                          Get.back();
                        },
                  child: Text(
                    'Cancel',
                    style: style2.copyWith(fontWeight: FontWeight.bold),
                  ),
                ),
              ),
              SizedBox(
                width: 15,
              ),
              Expanded(
                child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    primary: tertiaryColor,
                    shadowColor: Colors.transparent,
                    shape: RoundedRectangleBorder(
                      side: BorderSide(color: tertiaryColor),
                      borderRadius: BorderRadius.circular(20),
                    ),
                  ),
                  onPressed: () {
                    updateData();
                  },
                  child: isLoading == true
                      ? Center(
                          child: CircularProgressIndicator(
                          strokeWidth: 3.0,
                          valueColor: AlwaysStoppedAnimation(Colors.white),
                        ))
                      : Text(
                          'Save',
                          style: style2.copyWith(
                              fontWeight: FontWeight.bold,
                              color: secondaryColor),
                        ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  getAppBar() {
    return AppBar(
      leading: IconButton(
          onPressed: () {
            Get.back();
          },
          icon: Icon(
            CupertinoIcons.back,
            color: primaryColor,
          )),
      backgroundColor: Colors.transparent,
      elevation: 0.0,
      centerTitle: true,
      title: Text(
        'Edit Profile',
        style: style1.copyWith(fontWeight: FontWeight.w900),
      ),
    );
  }
}

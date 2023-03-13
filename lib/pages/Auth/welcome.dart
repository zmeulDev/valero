import 'package:flutter/material.dart';
import 'package:flutter_custom_clippers/flutter_custom_clippers.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Auth/enterotp.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';

class ChooseLoginSignup extends StatelessWidget {
  ChooseLoginSignup({Key? key}) : super(key: key);
  TextEditingController phoneNoController = TextEditingController();

  @override

  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        resizeToAvoidBottomInset: false,
        backgroundColor: primaryColor,
        body: Column(
        children: [
          Expanded(
            flex: 2,
            child: Container(
              color: primaryColor,
              child: ClipPath(
                clipper: OvalBottomBorderClipper(),
                child: Container(
                  width: Get.width,
                  color: tertiaryColor,
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Opacity(
                        opacity: 0.8,
                        child: Image.asset(
                          'assets/cover.png',
                          width: Get.width * 0.7,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
          SizedBox(
            height: Get.height * 0.03,
          ),
          Expanded(
            child: Container(
              height: Get.height * 0.6,
              width: Get.width * 0.6,
              child: Column(
                children: [
                TextField(
                  controller: phoneNoController,
                  keyboardType: TextInputType.phone,
                  maxLength: 15,
                  decoration: InputDecoration(
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12.0),
                    ),
                    focusedBorder: OutlineInputBorder(
                      borderRadius:  BorderRadius.circular(12.0),
                      borderSide:  BorderSide(color: fourthColor ),
                    ),
                    filled: true,
                    hintText: "Your phone number",
                    fillColor: primaryColor),
              ),
                   SizedBox(
                    height: Get.height * 0.01,
                  ),
                  InkWell(
                    onTap: () {
                      Get.to(() => EnterOTPScreen(phoneNoController.text));
                    },
                    child: Container(
                      height: Get.height * 0.07,
                      width: double.infinity,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(12),
                        color: fourthColor,
                      ),
                      child: Center(
                          child: Text(
                        'Sign in',
                        style: style2,
                      )),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
    ),
      ),
    );
  }
}

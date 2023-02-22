import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Auth/enterotp.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';

class Login extends StatelessWidget {
  TextEditingController phoneNoController = TextEditingController();
  TextEditingController passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    return SafeArea(
      child: Scaffold(
        body: Container(
          margin: const EdgeInsets.only(
            left: 25,
            right: 25,
          ),
          child: Column(
            children: [
              SizedBox(
                height: size.height * 0.04,
              ),
              upperImage(),
              SizedBox(
                height: size.height * 0.02,
              ),
              loginText(context),
              SizedBox(
                height: size.height * 0.02,
              ),
              Expanded(
                flex: 5,
                child: Container(
                  child: Column(
                    children: [
                      TextField(
                        controller: phoneNoController,
                        keyboardType: TextInputType.number,
                        maxLength: 15,
                        decoration: InputDecoration(
                          focusedBorder: const UnderlineInputBorder(
                              borderSide: BorderSide(color: tertiaryColor)),
                          prefixText: ' + ',
                          prefixStyle: style2,
                          hintText: '',
                          labelText: 'Phone number with country prefix',
                          labelStyle: style2.copyWith(color: tertiaryColor),
                          prefixIcon: const Icon(Icons.phone_android,
                              color: tertiaryColor),
                        ),
                      ),
                      SizedBox(
                        height: size.height * 0.01,
                      ),
                      loginArrowButton(() {
                        if (phoneNoController.text.isEmpty) {
                          Helper.showSnack(context,
                              "Please enter your phone number to proceed.");
                        } else {
                          Get.to(() => EnterOTPScreen(phoneNoController.text));
                        }
                      }),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
        resizeToAvoidBottomInset: false,
      ),
    );
  }

  forgetPassword(function) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Align(
        alignment: Alignment.topRight,
        child: InkWell(
          onTap: function,
          child: Text(
            'Forget Password?',
            style: style3.copyWith(color: tertiaryColor),
          ),
          borderRadius: BorderRadius.circular(10),
        ),
      ),
    );
  }

  upperImage() {
    return Expanded(
      flex: 3,
      child: Container(
        decoration: BoxDecoration(
            shape: BoxShape.circle,
            gradient: LinearGradient(colors: [
              tertiaryColor.withOpacity(0.3),
              tertiaryColor.withOpacity(0.6),
            ])),
        child: const Center(
            child: Padding(
          padding: EdgeInsets.all(1.0),
          child: Image(
            image: AssetImage('assets/profile_4.png'),
            fit: BoxFit.fill,
          ),
        )),
      ),
    );
  }

  loginText(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    return Expanded(
      flex: 2,
      child: Container(
        child: Column(
          children: [
            Text(
              'Log in',
              style: style1,
            ),
            SizedBox(
              height: size.height * 0.01,
            ),
            Text(
              'Enter your phone number with country prefix.',
              style: style2,
            ),
            Text(
              'ex: 4 0712 345 678',
              style: style2,
            ),
          ],
        ),
      ),
    );
  }

  loginArrowButton(function) {
    return Expanded(
      child: Container(
          height: 52,
          width: 62,
          child: Center(
            child: ElevatedButton(
                onPressed: function,
                style: ElevatedButton.styleFrom(
                    primary: tertiaryColor,
                    padding: const EdgeInsets.all(13),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(8),
                    )),
                child: const Icon(
                  CupertinoIcons.arrow_right,
                  size: 30,
                  color: secondaryColor,
                )),
          )),
    );
  }
}

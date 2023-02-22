import 'package:flutter/material.dart';
import 'package:flutter_custom_clippers/flutter_custom_clippers.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Auth/login.dart';
import 'package:valero/utils/constant.dart';

class ChooseLoginSignup extends StatelessWidget {
  const ChooseLoginSignup({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: secondaryColor,
      body: Column(
        children: [
          Expanded(
            flex: 2,
            child: Container(
              color: secondaryColor,
              child: ClipPath(
                clipper: OvalBottomBorderClipper(),
                child: Container(
                  height: 600,
                  width: 500,
                  color: tertiaryColor,
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Opacity(
                        opacity: 0.8,
                        child: Image.asset(
                          'assets/cover_4.png',
                          width: 300,
                          height: 300,
                          fit: BoxFit.cover,
                        ),
                      ),
                      Text(
                        'valero',
                        style: style1.copyWith(
                            fontSize: 28, color: secondaryColor),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
          Expanded(
            child: Container(
              margin: EdgeInsets.symmetric(horizontal: 25),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const SizedBox(
                    height: 10,
                  ),
                  InkWell(
                    onTap: () {
                      Get.to(() => Login());
                    },
                    borderRadius: BorderRadius.circular(10),
                    child: Container(
                      height: 50,
                      width: double.infinity,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(10),
                        color: tertiaryColor,
                        //border: Border.all(color: tertiaryColor),
                      ),
                      child: Center(
                          child: Text(
                        'Log in / Sign Up',
                        style: style2.copyWith(color: secondaryColor),
                      )),
                    ),
                  ),
                  const SizedBox(
                    height: 10,
                  ),
                  Container(
                    height: 50,
                    width: double.infinity,
                    child: TextButton(
                        onPressed: () {},
                        style: TextButton.styleFrom(
                            shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10),
                        )),
                        child: Text(
                          'zmeulKit: flutter/firebase OTP login',
                          style: style2.copyWith(color: tertiaryColor),
                        )),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

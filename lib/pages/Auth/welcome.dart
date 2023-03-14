import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_custom_clippers/flutter_custom_clippers.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Auth/enterotp.dart';
import 'package:valero/utils/constant.dart';
import 'package:mobile_number/mobile_number.dart';

class ChooseLoginSignup extends StatefulWidget {
  ChooseLoginSignup({Key? key}) : super(key: key);

  @override
  State<ChooseLoginSignup> createState() => _ChooseLoginSignupState();
}

class _ChooseLoginSignupState extends State<ChooseLoginSignup> {
  String _mobileNumber = '';

  @override
  void initState() {
    super.initState();
    MobileNumber.listenPhonePermission((isPermissionGranted) {
      if (isPermissionGranted) {
        initMobileNumberState();
      } else {}
    });

    initMobileNumberState();
  }

  Future<void> initMobileNumberState() async {
    if (!await MobileNumber.hasPhonePermission) {
      await MobileNumber.requestPhonePermission;
      return;
    }
    try {
      _mobileNumber = (await MobileNumber.mobileNumber)!;
      _mobileNumber = _mobileNumber.substring(_mobileNumber.indexOf('+'), _mobileNumber.length);
    } on PlatformException catch (e) {
      debugPrint("Failed to get mobile number because of '${e.message}'");
    }
    if (!mounted) return;

    setState(() {});
  }

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
                            width: Get.width * 0.8,
                          ),
                        ),
                        Text('valero', style: styleLogin,),
                        Text('car management', style: style2,),
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
              child: SizedBox(
                height: Get.height * 0.6,
                width: Get.width * 0.6,
                child: Column(
                  children: [
                    Container(
                      height: Get.height * 0.07,
                      width: double.infinity,
                      padding: EdgeInsets.all(8),
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(12),
                        color: secondaryColor,
                      ),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          const Icon(
                            Icons.phone,
                            color: tertiaryColor,
                          ),
                          Text(
                            _mobileNumber,
                            style: style2.copyWith(color: fourthColor, fontSize: 20,),
                          )
                        ],
                      ),
                    ),
                    SizedBox(
                      height: Get.height * 0.01,
                    ),
                    InkWell(
                      onTap: () {
                        Get.to(() => EnterOTPScreen(_mobileNumber));
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
                          "Sign in",
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

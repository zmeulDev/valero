import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/pages/Auth/otp.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:mobile_number/mobile_number.dart';

class Login extends StatefulWidget {
  const Login({Key? key}) : super(key: key);

  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
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
      _mobileNumber = _mobileNumber.substring(
          _mobileNumber.indexOf('+'), _mobileNumber.length);
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
        body: Column(
          children: [
            Expanded(
              flex: 2,
              child: SizedBox(
                width: Get.width,
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    SvgPicture.asset(
                      'assets/svg/login.svg',
                      width: Get.width * 0.6,
                    ),
                    SizedBox(
                      height: Get.height * 0.01,
                    ),
                     Text(
                      'V',
                      style: TextStyle(
                        fontFamily: 'Depot',
                        fontSize: 132,
                        color:lightColorScheme.primary,
                      ),
                    ),
                    Text('valero', style: style1.copyWith(color: lightColorScheme.secondary)),
                    Text('car management', style: style2.copyWith(color: lightColorScheme.secondary)),
                  ],
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
                      padding: const EdgeInsets.all(8),
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(12),
                        color: lightColorScheme.secondaryContainer,
                      ),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Icon(
                            Icons.phone,
                            color: lightColorScheme.onPrimaryContainer,
                          ),
                          Text(
                            _mobileNumber,
                            style: style2.copyWith(
                              color: lightColorScheme.onPrimaryContainer,
                              fontSize: 20,
                            ),
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
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(12),
                          color: lightColorScheme.secondaryContainer,
                        ),
                        child: Center(
                          child: Text(
                            "Sign in",
                            style: style2.copyWith(
                              color: lightColorScheme.onPrimaryContainer,
                            ),
                          ),
                        ),
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

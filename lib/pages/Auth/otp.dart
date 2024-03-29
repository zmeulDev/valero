import 'dart:async';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:get/get.dart';
import 'package:pin_code_fields/pin_code_fields.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/pages/navigation_bar.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';

class EnterOTPScreen extends StatefulWidget {
  final String phoneNumber;

  EnterOTPScreen(this.phoneNumber, {Key? key}) : super(key: key);

  @override
  _EnterOTPScreenState createState() => _EnterOTPScreenState();
}

class _EnterOTPScreenState extends State<EnterOTPScreen> {
  TextEditingController otpCodeController = TextEditingController();

  // ignore: close_sinks
  String _verificationCode = "";
  String enteredPin = "";
  bool isLoading = false;
  StreamController<ErrorAnimationType>? errorController;

  bool hasError = false;
  String currentText = "";
  final formKey = GlobalKey<FormState>();

  @override
  void initState() {
    errorController = StreamController<ErrorAnimationType>();
    super.initState();
    _verifyPhone();
  }

  @override
  void dispose() {
    errorController!.close();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        resizeToAvoidBottomInset: false,
        body: Container(
          child: Column(
            children: [
              Expanded(
                flex: 6,
                child: Container(
                  height: Get.height,
                  width: Get.width,
                  child: Column(
                    children: <Widget>[
                      upperImage(),
                      infoText(),
                      otpForm(),
                      arrowButton(() async {
                        // formKey.currentState!.validate();
                        // // conditions for validating
                        var res = await check();
                        if (currentText.length != 6 || currentText.isEmpty || res == false) {
                          errorController!.add(ErrorAnimationType.shake); // Triggering error shake animation
                        } else {}
                      }),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  _verifyPhone() async {
    await FirebaseAuth.instance.verifyPhoneNumber(
        phoneNumber: "${widget.phoneNumber}",
        timeout: const Duration(seconds: 60),
        verificationCompleted: (PhoneAuthCredential credential) async {
          try {
            setState(() {
              isLoading = true;
            });
            await FirebaseAuth.instance.signInWithCredential(credential).then((value) async {
              if (value.user != null) {
                if (value.additionalUserInfo?.isNewUser == true) {
                  await AuthServices.uploadUserDatatoFirestore(
                      uid: value.user!.uid, profileUrl: "", phoneNo: "${widget.phoneNumber}", username: "", email: "");
                  setState(() {
                    isLoading = false;
                  });
                  Helper.toReplacementScreen(context, const Navigation());
                } else if (value.additionalUserInfo?.isNewUser == false) {
                  await FirebaseFirestore.instance.collection("users").doc(value.user?.uid).get().then((userData) async {
                    if (userData.exists) {
                      await AuthServices.setCurrentUserToMap(value.user?.uid);
                      setState(() {
                        isLoading = false;
                      });
                      Fluttertoast.cancel();
                      Fluttertoast.showToast(msg: 'Logged In Successfully');
                      Helper.toReplacementScreen( context, const Navigation());
                    } else {
                      await AuthServices.uploadUserDatatoFirestore(
                          uid: value.user!.uid, profileUrl: "", phoneNo: "+${widget.phoneNumber}", username: "", email: "");
                      setState(() {
                        isLoading = false;
                      });
                      Helper.toReplacementScreen(context, const Navigation());
                    }
                  });
                }
              }
            });
          } on FirebaseAuthException catch (e) {
            Fluttertoast.cancel();
            Fluttertoast.showToast(msg: e.toString());
          }
        },
        verificationFailed: (FirebaseAuthException e) {
          Fluttertoast.cancel();
          Fluttertoast.showToast(msg: e.toString());
        },
        codeSent: (String verificationId, int? resendtoken) {
          setState(() {
            _verificationCode = verificationId;
          });
        },
        codeAutoRetrievalTimeout: (String verificationId) {
          setState(() {
            _verificationCode = verificationId;
          });
        });
  }

  Future<bool> check() async {
    bool? res;
    try {
      setState(() {
        isLoading = true;
      });
      await FirebaseAuth.instance
          .signInWithCredential(PhoneAuthProvider.credential(verificationId: _verificationCode, smsCode: enteredPin))
          .then((value) async {
        if (value.user != null) {
          if (value.additionalUserInfo?.isNewUser == true) {
            await AuthServices.uploadUserDatatoFirestore(
                uid: value.user!.uid, profileUrl: "", phoneNo: "+${widget.phoneNumber}", username: "", email: "");
            setState(() {
              isLoading = false;
            });
            print("Success");
            res = true;
            Helper.toReplacementScreen(context, const Navigation());
          } else if (value.additionalUserInfo?.isNewUser == false) {
            await FirebaseFirestore.instance.collection("users").doc(value.user?.uid).get().then((userData) async {
              if (userData.exists) {
                await AuthServices.setCurrentUserToMap(value.user?.uid);
                setState(() {
                  isLoading = false;
                });
                Fluttertoast.cancel();
                Fluttertoast.showToast(msg: "Logged In Successfully");

                res = true;
                Helper.toReplacementScreen(context, const Navigation());
              } else {
                await AuthServices.uploadUserDatatoFirestore(
                    uid: value.user!.uid, profileUrl: "", phoneNo: "${widget.phoneNumber}", username: "", email: "");
                setState(() {
                  isLoading = false;
                });
                res = true;
                Helper.toReplacementScreen(context, const Navigation());
              }
            });
          }
        } else {
          res = false;
        }
      });
      return res!;
    } catch (e) {
      setState(() {
        isLoading = false;
      });
      // Helper.showSnack(context, e.toString());
      res = false;
      print(e);
      return res!;
    }
  }

  upperImage() {
    return Padding(
        padding: const EdgeInsets.only(top: 20.0),
      child:  SvgPicture.asset('assets/svg/otp.svg', height: Get.height * 0.3,));
  }

  infoText() {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Text(
          'Enter code',
          style: style1,
        ),
        Text(
          'We have send your access code Via SMS for',
          style: style2,
        ),
        Text(
          'mobile number verification.',
          style: style2,
        ),
        TweenAnimationBuilder<Duration>(
            duration: const Duration(minutes: 1),
            tween: Tween(begin: const Duration(minutes: 1), end: Duration.zero),
            onEnd: () {
              print('Please go back and try again.');
            },
            builder: (BuildContext context, Duration value, Widget? child) {
              final minutes = value.inMinutes;
              final seconds = value.inSeconds % 60;
              return Padding(
                  padding: const EdgeInsets.symmetric(vertical: 15),
                  child: Text('Wait for: $minutes:$seconds',
                      textAlign: TextAlign.center, style: style2));
            }),
      ],
    );
  }

  otpForm() {
    return Form(
      key: formKey,
      child: Padding(
          padding: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 40),
          child: PinCodeTextField(
            appContext: context,
            pastedTextStyle:  TextStyle(
              color: darkColorScheme.secondary,
            ),
            length: 6,
            obscureText: false,
            obscuringCharacter: '•',
            textStyle: style1,
            blinkWhenObscuring: true,
            animationType: AnimationType.fade,
            validator: (v) {
              if (v!.length < 5) {
                return null;
              } else {
                return null;
              }
            },
            pinTheme: PinTheme(
              shape: PinCodeFieldShape.underline,
              borderRadius: BorderRadius.circular(12),
              borderWidth: 2,
              fieldWidth: 28,
              activeFillColor: Colors.transparent,
              inactiveColor: darkColorScheme.secondary,
              inactiveFillColor: Colors.transparent,
              selectedColor: darkColorScheme.secondary,
              disabledColor: darkColorScheme.secondary,
            ),
            cursorColor: darkColorScheme.secondary,
            animationDuration: const Duration(milliseconds: 300),
            enableActiveFill: false,
            errorAnimationController: errorController,
            controller: otpCodeController,
            keyboardType: TextInputType.number,

            onCompleted: (val) {
              enteredPin = val;
              print(enteredPin);
            },
            onChanged: (value) {
              print(value);
              setState(() {
                currentText = value;
              });
            },
            beforeTextPaste: (text) {
              print("Allowing to paste $text");
              //if you return true then it will show the paste confirmation dialog. Otherwise if false, then nothing will happen.
              //but you can show anything you want here, like your pop up saying wrong paste format or etc
              return true;
            },
          )),
    );
  }

  arrowButton(function) {
    return Expanded(
      child: Center(
        child: ElevatedButton(
            onPressed: function,
            style: ElevatedButton.styleFrom(
                padding: const EdgeInsets.all(13),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                )),
            child: const  Icon(
              CupertinoIcons.arrow_right,
              size: 30,

            )),
      ),
    );
  }
}

import 'dart:async';
import 'package:flutter/material.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/pages/Auth/welcome.dart';
import 'package:valero/pages/navbar.dart';
import 'package:valero/utils/constant.dart';

class Splash extends StatefulWidget {
  @override
  State<Splash> createState() => _SplashState();
}

class _SplashState extends State<Splash> {
  initUserModel() async {
    var user = await AuthServices.auth.currentUser;
    AuthServices.setCurrentUserToMap(user!.uid);
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.delayed(Duration(seconds: 3),
          () async => await AuthServices.getCurrentUser()),
      builder: (context, AsyncSnapshot snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return MaterialApp(
              debugShowCheckedModeBanner: false, home: SplashScreen());
        } else if (snapshot.hasError || snapshot.data == null) {
          return MaterialApp(
            debugShowCheckedModeBanner: false,
            home: Scaffold(body: ChooseLoginSignup()),
          );
        } else {
          initUserModel();
          return Navigation();
        }
      },
    );
  }
}

class SplashScreen extends StatefulWidget {
  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  initUserModel() async {
    var user = AuthServices.auth.currentUser;
    if (user != null) {
      AuthServices.setCurrentUserToMap(user.uid);
    }
  }

  @override
  void initState() {
    initUserModel();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ChooseLoginSignup(),
    );
  }
}

function() {
  return Container(
    child: Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Image.asset(
            'assets/logo_reverse.png',
            width: 120,
            height: 120,
            fit: BoxFit.cover,
          ),
          Text(
            'zmeulKit',
            style: style1.copyWith(fontSize: 28, color: secondaryColor),
          ),
        ],
      ),
    ),
  );
}

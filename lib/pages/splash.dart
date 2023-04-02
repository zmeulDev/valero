import 'dart:async';
import 'package:flutter/material.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/pages/Auth/login.dart';
import 'package:valero/pages/navbar.dart';
import 'package:valero/utils/constant.dart';

class Splash extends StatefulWidget {
  const Splash({Key? key}) : super(key: key);

  @override
  State<Splash> createState() => _SplashState();
}

class _SplashState extends State<Splash> {
  iniUserModel() async {
    var user = AuthServices.auth.currentUser;
    if (user != null) {
      AuthServices.setCurrentUserToMap(user.uid);
    } else {
      return Container(
          color: tertiaryColor,
          child: Text(
            'Waiting for user data...',
            style: style3,
          ));
    }
  }

  @override
  void initState() {
    super.initState();
    iniUserModel();
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.delayed(const Duration(seconds: 3),
          () async => await AuthServices.getCurrentUser()),
      builder: (context, AsyncSnapshot snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return const MaterialApp(
            home: Login(),
          );
        } else if (snapshot.hasError || snapshot.data == null) {
          return const MaterialApp(
            home: Scaffold(
              body: Login(),
            ),
          );
        } else {
          return const Navigation();
        }
      },
    );
  }
}

/*
 // TODO check if this can be refactor, for now is not used

class SplashScreen extends StatefulWidget {
  const SplashScreen({Key? key}) : super(key: key);

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  initUserModel() async {
    var user = AuthServices.auth.currentUser;
    if (user != null) {
      AuthServices.setCurrentUserToMap(user.uid);
    } else {
      return Container(
          color: tertiaryColor,
          child: Text(
            'Waiting for user data...',
            style: style3,
          ));
    }
  }

  @override
  void initState() {
    super.initState();
    initUserModel();
  }

  @override
  Widget build(BuildContext context) {
    return const Scaffold(
      body: Login(),
    );
  }
}
 */

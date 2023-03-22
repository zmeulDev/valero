import 'dart:async';
import 'package:flutter/material.dart';
import 'package:valero/Services/auth_services.dart';
import 'package:valero/pages/Auth/welcome.dart';
import 'package:valero/pages/navbar.dart';
import 'package:valero/utils/constant.dart';

class Splash extends StatefulWidget {
  const Splash({Key? key}) : super(key: key);

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
      future: Future.delayed(const Duration(seconds: 3), () async => await AuthServices.getCurrentUser()),
      builder: (context, AsyncSnapshot snapshot) {
        if (snapshot.connectionState == ConnectionState.waiting) {
          return MaterialApp(
            debugShowCheckedModeBanner: false,
            home: Welcome(),
          );
        } else if (snapshot.hasError || snapshot.data == null) {
          return MaterialApp(
            debugShowCheckedModeBanner: false,
            home: Scaffold(
              body: Welcome(),
            ),
          );
        } else {
          initUserModel();
          return const Navigation();
        }
      },
    );
  }
}

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
      return Container( color: tertiaryColor, child: Text('Ma incarc', style: style3,));
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
      body: Welcome(),
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
            'assets/logo.png',
            width: 120,
            height: 120,
            fit: BoxFit.cover,
          ),
          Text(
            'valero',
            style: style1.copyWith(fontSize: 28, color: secondaryColor),
          ),
        ],
      ),
    ),
  );
}

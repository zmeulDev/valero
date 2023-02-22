import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:google_nav_bar/google_nav_bar.dart';
import 'package:valero/pages/home.dart';
import 'package:valero/pages/profile/profile.dart';
import 'package:valero/utils/constant.dart';

class NavBar extends StatefulWidget {
  @override
  State<StatefulWidget> createState() {
    return NavigationBar();
  }
}

class NavigationBar extends State<NavBar> {
  int _currentIndex = 0;
  final List<Widget> _children = [
    Home(),
    Home(),
    Home(),
    Profile(),
  ];
  int backPressCounter = 1;
  int backPressTotal = 2;

  Future<bool> onWillPop() {
    if (backPressCounter < 2) {
      Fluttertoast.showToast(msg: "Tap Again To Exit ");
      backPressCounter++;
      Future.delayed(const Duration(seconds: 1, milliseconds: 500), () {
        backPressCounter--;
      });
      return Future.value(false);
    } else {
      SystemNavigator.pop();
      return Future.value(true);
    }
  }

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return WillPopScope(
      onWillPop: onWillPop,
      child: Scaffold(
        body: _children[_currentIndex],
        extendBody: true,
        bottomNavigationBar: Container(
          padding: const EdgeInsets.all(8.0),
          decoration: BoxDecoration(
            color: Colors.white,
            boxShadow: [
              BoxShadow(
                spreadRadius: -10,
                blurRadius: 60,
                color: Colors.black.withOpacity(.20),
                offset: const Offset(0, 15),
              )
            ],
          ),
          child: GNav(
              selectedIndex: _currentIndex,
              onTabChange: onTabTapped,
              haptic: true,
              rippleColor: tertiaryColor,
              hoverColor: tertiaryColor,
              tabBackgroundColor: tertiaryColor,
              color: primaryColor,
              activeColor: secondaryColor,
              gap: 4,
              iconSize: 28,
              padding: const EdgeInsets.symmetric(horizontal: 15, vertical: 10),
              duration: const Duration(milliseconds: 300),
              tabs: const [
                GButton(
                  icon: Icons.home,
                  text: 'Home',
                ),
                GButton(
                  icon: Icons.search,
                  text: 'Find',
                ),
                GButton(
                  icon: Icons.car_crash,
                  text: 'Garage',
                ),
                GButton(
                  icon: Icons.person,
                  text: 'Profile',
                )
              ]),
        ),
      ),
    );
  }

  void onTabTapped(int index) {
    setState(() {
      _currentIndex = index;
    });
  }
}

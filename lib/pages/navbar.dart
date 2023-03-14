import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:google_nav_bar/google_nav_bar.dart';
import 'package:valero/pages/home.dart';
import 'package:valero/pages/profile/profile.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';

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
      Helper.showSnack(context, "Tap Again To Exit");
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
            color: fourthColor,
            boxShadow: [
              BoxShadow(
                spreadRadius: -12,
                blurRadius: 60,
                color: Colors.black.withOpacity(.20),
                offset: const Offset(0, 15),
              )
            ],
          ),
          child: GNav(
              selectedIndex: _currentIndex,
              onTabChange: onTabTapped,
              tabBorderRadius: 12,
              haptic: true,
              rippleColor: fifthColor,
              hoverColor: fifthColor,
              tabBackgroundColor: fourthColor,
              color: primaryColor,
              activeColor: tertiaryColor,
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

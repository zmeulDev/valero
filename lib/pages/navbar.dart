import 'package:flutter/cupertino.dart';
import 'package:flutter/services.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/UserProfile/viewProfile.dart';
import 'package:valero/pages/home.dart';
import 'package:valero/utils/constant.dart';

// TODO chek onWillPop for exit app

class Navigation extends StatefulWidget {
  const Navigation({Key? key}) : super(key: key);

  @override
  State<Navigation> createState() => _NavigationState();
}

class _NavigationState extends State<Navigation> {
  int backPressCounter = 1;
  int backPressTotal = 2;
  late PersistentTabController _controller;

  @override
  void initState() {
    super.initState();
    _controller = PersistentTabController();
  }

  @override
  void dispose() {
    PersistentTabController().dispose();
    super.dispose();
  }

  List<Widget> _buildScreens() {
    return [const Home(), const ViewCar(), const Profile()];
  }

  List<PersistentBottomNavBarItem> _navBarsItems() {
    return [
      PersistentBottomNavBarItem(
          icon: const Icon(CupertinoIcons.home),
          title: ("Home"),
          activeColorPrimary: secondaryColor,
          activeColorSecondary: primaryColor,
          inactiveColorPrimary: secondaryColor,
          inactiveColorSecondary: tertiaryColor,
          iconSize: 22),
      PersistentBottomNavBarItem(
          icon: const Icon(CupertinoIcons.car),
          title: ("Garage"),
          activeColorPrimary: secondaryColor,
          activeColorSecondary: primaryColor,
          inactiveColorPrimary: secondaryColor,
          inactiveColorSecondary: primaryColor,
          iconSize: 22),
      PersistentBottomNavBarItem(
          icon: const Icon(CupertinoIcons.settings),
          title: ("Settings"),
          activeColorPrimary: secondaryColor,
          activeColorSecondary: primaryColor,
          inactiveColorPrimary: secondaryColor,
          inactiveColorSecondary: primaryColor,
          iconSize: 22),
    ];
  }

  @override
  Widget build(BuildContext context) {
    return PersistentTabView(
      context,
      controller: _controller,
      screens: _buildScreens(),
      items: _navBarsItems(),
      navBarHeight: 80,
      backgroundColor: tertiaryColor,
      resizeToAvoidBottomInset: true,
      itemAnimationProperties: const ItemAnimationProperties(
        duration: Duration(milliseconds: 200),
        curve: Curves.easeIn,
      ),
      navBarStyle: NavBarStyle.style10,
      decoration: const NavBarDecoration(
        borderRadius: BorderRadius.only(
            topRight: Radius.circular(12), topLeft: Radius.circular(12)),
      ),
    );
  }
}

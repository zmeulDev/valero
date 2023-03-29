import 'package:cherry_toast/cherry_toast.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/services.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/pages/Car/addCar.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/UserProfile/viewProfile.dart';
import 'package:valero/pages/home.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/helper.dart';

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

  Future<bool> tapToExit() {
    if (backPressCounter < 2) {
      CherryToast.warning(
          title: Text(""),
          displayTitle: false,
          description: const Text("Tap Again To Exit"),
          autoDismiss: true);

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

  List<Widget> _buildScreens() {
    return [Home(), ViewCar(), Profile()];
  }

  List<PersistentBottomNavBarItem> _navBarsItems() {
    return [
      PersistentBottomNavBarItem(
          icon: const Icon(CupertinoIcons.home),
          title: ("Home"),
          activeColorPrimary: tertiaryColor,
          activeColorSecondary: primaryColor,
          inactiveColorPrimary: primaryColor,
          inactiveColorSecondary: primaryColor,
          iconSize: 22),
      PersistentBottomNavBarItem(
          icon: const Icon(CupertinoIcons.car),
          title: ("Garage"),
          activeColorPrimary: tertiaryColor,
          activeColorSecondary: primaryColor,
          inactiveColorPrimary: primaryColor,
          inactiveColorSecondary: primaryColor,
          iconSize: 22),
      PersistentBottomNavBarItem(
          icon: const Icon(CupertinoIcons.settings),
          title: ("Settings"),
          activeColorPrimary: tertiaryColor,
          activeColorSecondary: primaryColor,
          inactiveColorPrimary: primaryColor,
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
      confineInSafeArea: true,
      backgroundColor: fourthColor,
      handleAndroidBackButtonPress: true,
      resizeToAvoidBottomInset: true,
      stateManagement: true,
      hideNavigationBarWhenKeyboardShows: true,
      popAllScreensOnTapOfSelectedTab: true,
      popActionScreens: PopActionScreensType.all,
      itemAnimationProperties: const ItemAnimationProperties(
        duration: Duration(milliseconds: 200),
        curve: Curves.easeIn,
      ),
      screenTransitionAnimation: const ScreenTransitionAnimation(
        animateTabTransition: true,
        curve: Curves.fastOutSlowIn,
        duration: Duration(milliseconds: 200),
      ),
      navBarStyle: NavBarStyle.style10,
    );
  }
}

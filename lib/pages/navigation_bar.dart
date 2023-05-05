import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:line_icons/line_icons.dart';
import 'package:persistent_bottom_nav_bar/persistent_tab_view.dart';
import 'package:valero/pages/Car/view_garage.dart';
import 'package:valero/pages/UserProfile/view_profile.dart';
import 'package:valero/pages/Home/home.dart';
import 'package:valero/utils/color_schemes.g.dart';

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
    return [const Home(), const ViewGarage(), const Profile()];
  }

  List<PersistentBottomNavBarItem> _navBarsItems() {
    return [
      PersistentBottomNavBarItem(
          icon: const Icon(LineIcons.home),
          title: ("Home"),
          activeColorPrimary: Theme.of(context).colorScheme.primary,
          activeColorSecondary: Theme.of(context).colorScheme.onPrimary,
          inactiveColorPrimary: Theme.of(context).colorScheme.onSurface,
          inactiveColorSecondary: Theme.of(context).colorScheme.onSurface,
          iconSize: 24),
      PersistentBottomNavBarItem(
          icon: const Icon(LineIcons.suitcaseRolling),
          title: ("Garage"),
          activeColorPrimary: Theme.of(context).colorScheme.primary,
          activeColorSecondary: Theme.of(context).colorScheme.onPrimary,
          inactiveColorPrimary: Theme.of(context).colorScheme.onSurface,
          inactiveColorSecondary: Theme.of(context).colorScheme.onSurface,
          iconSize: 24),
      PersistentBottomNavBarItem(
          icon: const  Icon(LineIcons.user),
          title: ("Settings"),
          activeColorPrimary: Theme.of(context).colorScheme.primary,
          activeColorSecondary: Theme.of(context).colorScheme.onPrimary,
          inactiveColorPrimary: Theme.of(context).colorScheme.onSurface,
          inactiveColorSecondary: Theme.of(context).colorScheme.onSurface,
          iconSize: 24),
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
      backgroundColor: Theme.of(context).colorScheme.surfaceVariant,
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

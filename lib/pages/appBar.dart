import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:valero/utils/constant.dart';

getAppBar(String screenName) {
  return AppBar(
    leading: Builder(
      builder: (BuildContext context) {
        return Container(
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(12),
            color: tertiaryColor,
          ),
          margin: EdgeInsets.all(8),
          child: IconButton(
            icon: const Icon(CupertinoIcons.arrow_branch, color: secondaryColor,),
            onPressed: () { Scaffold.of(context).openDrawer(); },
            tooltip: MaterialLocalizations.of(context).openAppDrawerTooltip,
          ),
        );
      },
    ),
    backgroundColor: Colors.transparent,
    elevation: 0.0,
    centerTitle: true,
    title: Text(
      screenName,
      style: styleAppBar,
    ),
  );
}

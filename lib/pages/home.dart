import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/createHorizontalCard.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

class Home extends StatefulWidget {
  const Home({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  CollectionReference qrCollection = FirebaseFirestore.instance.collection('codes');

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar('home'),
      body: getBody(),
    );
  }

  getBody() {
    return SingleChildScrollView(
      physics: const BouncingScrollPhysics(),
      child: Container(
        height: Get.height,
        width: Get.width,
        margin: const EdgeInsets.all(8),
        child: Column(
          children: [
            helloContainer(),
            CreateHorizontalCard(
                level: 'level',
                title: 'title',
                duration: 'duration',
                color: fifthColor,
                image: SvgPicture.asset('assets/svg/delorean.svg'),
                textColor: fourthColor),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                carsContainer(),
                carsContainer(),
              ],
            )
          ],
        ),
      ),
    );
  }

  helloContainer() {
    return Container(
      height: Get.height * 0.1,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: tertiaryColor,
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.start,
        children: [
          SizedBox(
            width: Get.width * 0.02,
          ),
          createAvatarWidget(32),
          SizedBox(
            width: Get.width * 0.02,
          ),
          UserModel().userName != ''
              ? Text(
                  'Hello ${UserModel().userName}',
                  style: style2.copyWith(color: secondaryColor, fontSize: 18),
                )
              : Text('Hello!', style: style2.copyWith(color: secondaryColor, fontSize: 18)),
        ],
      ),
    );
  }

  carsContainer() {
    return Container(
      margin: EdgeInsets.only(top: 12),
      height: Get.height * 0.3,
      width: Get.width * 0.4,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: secondaryColor,
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.start,
        children: [
          SizedBox(
            width: Get.width * 0.05,
          ),
          createAvatarWidget(36),
        ],
      ),
    );
  }
}

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Car/viewCar.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/createHorizontalCard.dart';
import 'package:valero/utils/createVerticalCard.dart';
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
              subTitle: 'level',
              title: 'title',
              duration: 'duration',
              color: fifthColor,
              image: SvgPicture.asset('assets/svg/delorean.svg'),
              textColor: fourthColor,
              navigate: ViewCar(),),
            CreateVerticalCard(
              title: 'title',
              duration: 'duration',
              color: tertiaryColor,
              image: SvgPicture.asset('assets/svg/delorean.svg'),
              textColor: tertiaryColor,
              subTitle: 'level',),
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
          createAvatarWidget(36),
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
}

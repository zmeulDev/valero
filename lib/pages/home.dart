import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/UserProfile/viewProfile.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/createBoxCard.dart';
import 'package:valero/utils/createWideCard.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

// TODO move to FeatureBuild instead of StreamBuilder

class Home extends StatefulWidget {
  const Home({Key? key}) : super(key: key);

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
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
    return Container(
      height: Get.height,
      width: Get.width,
      margin: const EdgeInsets.all(8),
      child: Column(
        children: [
          CreateWideCard(
            subTitle: 'Hi',
            title: UserModel().userName != '' ? UserModel().userName : 'user' ,
            paragraph: 'welcome back!',
            color: fifthColor,
            image: SvgPicture.asset('assets/svg/avatar.svg', height: 75, width: 75,),
            textColor: fourthColor,
            buttonText: 'Profile',
            navigate: Profile(),
          ),
          Column(
            children: [
              SizedBox(
                height: Get.height * 0.03,
              ),
              Row(
                children: [
                  nextCard(),
                  nextInsurance(),
                ],
              ),
              Row(
                children: [nextInspection(), nextVignette()],
              )
            ],
          ),
        ],
      ),
    );
  }

  helloContainer() {
    return Container(
      height: Get.height * 0.1,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: sixthColor,
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

  nextCard() {
    return CreateBoxCard(
      subTitle: 'Always',
      title: 'be careful',
      paragraph: 'its better!',
      color: secondaryColor,
      image: SvgPicture.asset(
        'assets/svg/notify.svg',
      ),
      textColor: const Color(0xFFf0554f),
      buttonText: 'buttonText',
    );
  }

  nextInsurance() {
    return SizedBox(
      child: StreamBuilder<QuerySnapshot<Map<String, dynamic>>>(
        stream: FirebaseFirestore.instance
            .collection('cars')
            .where('userId', isEqualTo: UserModel().uid.toString())
            .where('insurance', isLessThanOrEqualTo: '31 03 2023')
            .orderBy('insurance', descending: true)
            .snapshots(),
        builder: (_, snapshot) {
          if (snapshot.hasError) return Text('Error = ${snapshot.error}');
          if (snapshot.data?.size == 0) {
            return const Text('no data for you');
          }
          if (snapshot.hasData) {
            final car = snapshot.data!.docs.first;
            return CreateBoxCard(
              subTitle: 'Next Insurance',
              title: car['insurance'].toString().isNotEmpty ? car['insurance'] : 'Not set',
              paragraph: car['insurance'].toString().isNotEmpty ? car['plates'] : 'no data set',
              color: secondaryColor,
              image: SvgPicture.asset(
                'assets/svg/insurance.svg',
                alignment: Alignment.bottomRight,
              ),
              textColor: car['insurance'].toString() == '31 03 2023' ?  tertiaryColor : const Color(0xFFf0554f),
              buttonText: 'buttonText',
            );
          }

          return const Center(child: CircularProgressIndicator());
        },
      ),
    );
  }

  nextInspection() {
    return SizedBox(
      child: StreamBuilder<QuerySnapshot<Map<String, dynamic>>>(
        stream: FirebaseFirestore.instance
            .collection('cars')
            .where('userId', isEqualTo: UserModel().uid.toString())
            .where('inspection', isLessThanOrEqualTo: '45')
            .snapshots(),
        builder: (_, snapshot) {
          if (snapshot.hasError) return Text('Error = ${snapshot.error}');
          if (snapshot.data?.size == 0) {
            return const Text('no data for you');
          }
          if (snapshot.hasData) {
            final car = snapshot.data!.docs.first;
            return CreateBoxCard(
              subTitle: 'Next inspection',
              title: car['inspection'].toString().isNotEmpty ? car['inspection'] : 'Not set',
              paragraph: car['inspection'].toString().isNotEmpty ? car['plates'] : 'no data set',
              color: secondaryColor,
              image: SvgPicture.asset(
                'assets/svg/inspection.svg',
                alignment: Alignment.bottomRight,
              ),
              textColor: car['inspection'].toString() == '31 03 2023' ?  tertiaryColor : const Color(0xFFf0554f),
              buttonText: 'buttonText',
            );
          }

          return const Center(child: CircularProgressIndicator());
        },
      ),
    );
  }

  nextVignette() {
    return SizedBox(
      child: StreamBuilder<QuerySnapshot<Map<String, dynamic>>>(
        stream: FirebaseFirestore.instance
            .collection('cars')
            .where('userId', isEqualTo: UserModel().uid.toString())
            .where('vignette', isLessThanOrEqualTo: '45')
            .snapshots(),
        builder: (_, snapshot) {
          if (snapshot.hasError) return Text('Error = ${snapshot.error}');
          if (snapshot.data?.size == 0) {
            return const Text('no data for you');
          }
          if (snapshot.hasData) {
            var car = snapshot.data!.docs.first;

            return CreateBoxCard(
              subTitle: 'Next vignette',
              title: car['vignette'].toString().isNotEmpty ? car['vignette'] : 'Not set',
              paragraph: car['vignette'].toString().isNotEmpty ? car['plates'] : 'no data set',
              color: secondaryColor,
              image: SvgPicture.asset(
                'assets/svg/vignette.svg',
                alignment: Alignment.bottomRight,
              ),
              textColor: car['vignette'].toString() == '31 03 2023' ?  tertiaryColor : const Color(0xFFf0554f),
              buttonText: 'buttonText',
            );
          }

          return const Center(child: CircularProgressIndicator());
        },
      ),
    );
  }
}

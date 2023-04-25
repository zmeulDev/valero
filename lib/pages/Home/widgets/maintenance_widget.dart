import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:line_icons/line_icons.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/create_box_card.dart';


nextMaintenance() {
  return SizedBox(
    width: Get.width * 0.48,
    height: Get.height * 0.12,
    child: StreamBuilder<QuerySnapshot<Map<String, dynamic>>>(
      stream: FirebaseFirestore.instance
          .collection('cars')
          .where('userId', isEqualTo: UserModel().uid.toString())
          .snapshots(),
      builder: (_, snapshot) {
        if (snapshot.hasError) return Text('Error = ${snapshot.error}');
        if (snapshot.data?.size == 0) {
          return const Text('no data');
        }
        if (snapshot.hasData) {
          final car = snapshot.data!.docs.first;
          return CreateBoxCard(
            textColor: DateTime.now().isAfter(car['maintenance'].toDate())
                ? lightColorScheme.onErrorContainer
                : lightColorScheme.onSecondary,
            cardColor: DateTime.now().isAfter(car['maintenance'].toDate())
                ? lightColorScheme.errorContainer
                : lightColorScheme.secondary,
            subTitle: 'Maintenance',
            title: car['maintenance'].toString().isNotEmpty
                ? f.format(car['maintenance'].toDate())
                : 'Not set',
            paragraph: car['maintenance'].toString().isNotEmpty
                ? car['plates']
                : 'no data set',

            image: Icon(LineIcons.wrench, size: 82,),

            buttonText: 'buttonText',
          );
        }

        return const Center(child: CircularProgressIndicator());
      },
    ),
  );
}
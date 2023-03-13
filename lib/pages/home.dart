import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:flutter/material.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/appBar.dart';
import 'package:valero/utils/constant.dart';
import 'package:valero/utils/getImages.dart';
import 'package:valero/utils/loading.dart';
import 'package:valero/widgets/createAvatarWidget.dart';

class Home extends StatefulWidget {
  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  CollectionReference qrCollection =
      FirebaseFirestore.instance.collection('codes');

  @override
  void initState() {
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: getAppBar('tkyo'),
      body: getBody(),
    );
  }

  getBody() {
    return SingleChildScrollView(
      physics: const BouncingScrollPhysics(),
      child: Column(
        children: [
          Container(
            margin: const EdgeInsets.symmetric(horizontal: 20),
            child: Column(
              children: [
                userContainer(),
                Row(
                  children: [
                    const Text('data'),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  userContainer() {
    Size size = MediaQuery.of(context).size;
    return Container(
      width: double.infinity,
      margin: const EdgeInsets.symmetric(vertical: 5),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(10),
        color: tertiaryColor,
      ),
      child: Padding(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Row(
              children: [
                createAvatarWidget(25),
                const SizedBox(
                  width: 15,
                ),
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    UserModel().userName != ''
                        ? Text(
                            UserModel().userName,
                            style: style2.copyWith(
                                color: secondaryColor, fontSize: 18),
                          )
                        : Text('Hello!',
                            style: style2.copyWith(
                                color: secondaryColor, fontSize: 18)),
                  ],
                ),
              ],
            ),
            const SizedBox(
              height: 20,
            ),
            StreamBuilder(
                stream: qrCollection
                    .where('uid', isEqualTo: UserModel().uid)
                    .where('isMain', isEqualTo: '1')
                    .limit(1)
                    .snapshots(),
                builder: (context, AsyncSnapshot snapshot) {
                  if (!snapshot.hasData) {
                    return Center(
                      child: loading(),
                    );
                  } else {
                    List<DocumentSnapshot> list = snapshot.data.docs;
                    if (list.isEmpty) {
                      return Container(
                        height: size.height * 0.3,
                        child: Image.asset('assets/logo.png'),
                      );
                    } else {
                      return Container(
                        height: size.height * 0.35,
                        child: ListView.builder(
                          scrollDirection: Axis.horizontal,
                          shrinkWrap: true,
                          itemCount: list.length,
                          itemBuilder: (BuildContext context, int index) =>
                              Container(
                            padding: const EdgeInsets.all(10),
                            decoration: BoxDecoration(
                                color: secondaryColor,
                                borderRadius: BorderRadius.circular(15)),
                            child: GetImage(
                              imagePath: list[index]['qrUrl'],
                              width: 250,
                              height: 250,
                            ),
                          ),
                        ),
                      );
                    }
                  }
                }),
          ],
        ),
      ),
    );
  }
}

import 'package:firebase_core/firebase_core.dart';
import 'package:get/get.dart';
import 'package:valero/utils/color_schemes.g.dart';
import 'firebase_options.dart';
import 'package:flutter/material.dart';
import 'package:valero/pages/splash.dart';

// https://undraw.co/search


Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp(
    options: DefaultFirebaseOptions.currentPlatform,
  ).then((_) {
    runApp(MyApp());
  });
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      theme: ThemeData(useMaterial3: true, colorScheme: lightColorScheme),
      darkTheme: ThemeData(useMaterial3: true, colorScheme: darkColorScheme),
      home: const Splash(),
    );
  }
}

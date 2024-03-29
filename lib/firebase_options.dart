// File generated by FlutterFire CLI.
// ignore_for_file: lines_longer_than_80_chars, avoid_classes_with_only_static_members
import 'package:firebase_core/firebase_core.dart' show FirebaseOptions;
import 'package:flutter/foundation.dart'
    show defaultTargetPlatform, kIsWeb, TargetPlatform;

/// Default [FirebaseOptions] for use with your Firebase apps.
///
/// Example:
/// ```dart
/// import 'firebase_options.dart';
/// // ...
/// await Firebase.initializeApp(
///   options: DefaultFirebaseOptions.currentPlatform,
/// );
/// ```
class DefaultFirebaseOptions {
  static FirebaseOptions get currentPlatform {
    if (kIsWeb) {
      return web;
    }
    switch (defaultTargetPlatform) {
      case TargetPlatform.android:
        return android;
      case TargetPlatform.iOS:
        return ios;
      case TargetPlatform.macOS:
        return macos;
      case TargetPlatform.windows:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for windows - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      case TargetPlatform.linux:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for linux - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      default:
        throw UnsupportedError(
          'DefaultFirebaseOptions are not supported for this platform.',
        );
    }
  }

  static const FirebaseOptions web = FirebaseOptions(
    apiKey: 'AIzaSyD0jbxbG0dT-FTdK3L_a5sGbTqcjJyx2k4',
    appId: '1:708706699887:web:b756706aaa0f616e08db9a',
    messagingSenderId: '708706699887',
    projectId: 'valero-ca265',
    authDomain: 'valero-ca265.firebaseapp.com',
    storageBucket: 'valero-ca265.appspot.com',
  );

  static const FirebaseOptions android = FirebaseOptions(
    apiKey: 'AIzaSyCGZ3GIYL1VDPUvNktRrr0jto8Ck01rVek',
    appId: '1:708706699887:android:d1c4e0e2c68bb11508db9a',
    messagingSenderId: '708706699887',
    projectId: 'valero-ca265',
    storageBucket: 'valero-ca265.appspot.com',
  );

  static const FirebaseOptions ios = FirebaseOptions(
    apiKey: 'AIzaSyAQ54fa2h2I8UjU19c47K0ydk0BKgWPRcY',
    appId: '1:708706699887:ios:b3a2cbeaa4b6946f08db9a',
    messagingSenderId: '708706699887',
    projectId: 'valero-ca265',
    storageBucket: 'valero-ca265.appspot.com',
    androidClientId: '708706699887-lhrudu8bokg4f6mjdsu72a6rjqn8qpvg.apps.googleusercontent.com',
    iosClientId: '708706699887-ks0i8t2779gqqjg485eg3pepir0lkbea.apps.googleusercontent.com',
    iosBundleId: 'com.valero.valero',
  );

  static const FirebaseOptions macos = FirebaseOptions(
    apiKey: 'AIzaSyAQ54fa2h2I8UjU19c47K0ydk0BKgWPRcY',
    appId: '1:708706699887:ios:b3a2cbeaa4b6946f08db9a',
    messagingSenderId: '708706699887',
    projectId: 'valero-ca265',
    storageBucket: 'valero-ca265.appspot.com',
    androidClientId: '708706699887-lhrudu8bokg4f6mjdsu72a6rjqn8qpvg.apps.googleusercontent.com',
    iosClientId: '708706699887-ks0i8t2779gqqjg485eg3pepir0lkbea.apps.googleusercontent.com',
    iosBundleId: 'com.valero.valero',
  );
}

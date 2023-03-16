import 'dart:io';
import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_storage/firebase_storage.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/pages/Auth/welcome.dart';

class AuthServices {
  static final auth = FirebaseAuth.instance;
  static final firestoreRef = FirebaseFirestore.instance;
  static final userRef = firestoreRef.collection("users");
  static final qrCodeRef = firestoreRef.collection("codes");
  static final _firebaseStorage = FirebaseStorage.instance.ref();

  static Future<User?> getCurrentUser() async {
    User currentUser;
    if (auth.currentUser != null) {
      currentUser = auth.currentUser!;
      return currentUser;
    }
  }

  static Future<Map<String, dynamic>> getUserDetails(userId) async {
    DocumentSnapshot _userData = await userRef.doc(userId).get();
    Object? data = _userData.data();
    return data as Map<String, dynamic>;
  }

  static Future<void> uploadUserDatatoFirestore({
    String? uid,
    String? profileUrl,
    String? phoneNo,
    String? username,
    @required String? email,
  }) async {
    try {
      UserModel().uid = uid;
      UserModel().avatarUrl = profileUrl ?? '';
      UserModel().mobilePhone = phoneNo;
      UserModel().userName = username ?? '';
      UserModel().email = email ?? '';
      await userRef.doc(uid).set(UserModel().toJson());
    } catch (e) {
      print(e);
    }
  }

  static Future<void> setCurrentUserToMap(userId) async {
    var userMap = await getUserDetails(userId);
    UserModel().uid = userId;
    UserModel().avatarUrl = userMap['avatarUrl'];
    UserModel().mobilePhone = userMap['mobilePhone'];
    UserModel().userName = userMap['userName'];
    UserModel().email = userMap['email'];
  }

  static Future<String> updateUserDatainFirestore(File imageFile, String userId) async {
    String res;
    try {
      UserModel().avatarUrl = await uploadImageToStorage(imageFile, userId);
      await userRef.doc(UserModel().uid).update(UserModel().toJson());
      res = "Success";
    } catch (e) {
      res = e.toString();
    }
    return res;
  }

  static Future<String> updateUserDatainFirestoreWithoutImage(String userId) async {
    String res;
    try {
      await userRef.doc(UserModel().uid).update(UserModel().toJson());
      res = "Success";
    } catch (e) {
      res = e.toString();
    }
    return res;
  }

  static Future<String> uploadImageToStorage(File imageFile, String userId) async {
    var url;

    try {
      Reference storageReference = _firebaseStorage.child("user/profile/${userId}");
      UploadTask storageUploadTask = storageReference.putFile(imageFile);
      url = await (await storageUploadTask.whenComplete(() => true)).ref.getDownloadURL();
      return url;
    } catch (e) {
      // Helper.showSnack(, e.toString());
      print(e.toString());
    }
    return url;
  }

  //SignOut
  static Future<bool> signOut() async {
    bool result;
    try {
      await auth.signOut();
      result = true;
    } catch (e) {
      result = false;
    }
    return result;
  }

  static Future<void> deleteQr(doc) async {
    return qrCodeRef.doc(doc).delete();
  }

  static Future<void> favQr(doc, String isFav) async {
    return qrCodeRef.doc(doc).update(
      {'isFav': '$isFav'},
    );
  }

  static Future<void> mainQr(doc, String isMain) async {
    return qrCodeRef.doc(doc).update(
      {'isMain': '$isMain'},
    );
  }

  static Future<void> deleteQrImage(String ref) async {
    await FirebaseStorage.instance.refFromURL(ref).delete();
  }
}

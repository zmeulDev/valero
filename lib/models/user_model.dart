import 'dart:convert';

String userModelToJson(UserModel data) => json.encode(data.toJson());

class UserModel {
  String? phoneNo;
  String username = '';
  String? uid;
  String profileUrl = '';
  String email = '';

  static final UserModel userModel = UserModel._internal();

  factory UserModel() {
    return userModel;
  }

  UserModel._internal();

  Map<String, dynamic> toJson() => {
        "phoneNo": phoneNo,
        "profileurl": profileUrl,
        "username": username,
        "uid": uid,
        "email": email
      };
}

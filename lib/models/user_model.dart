import 'dart:convert';

String userModelToJson(UserModel data) => json.encode(data.toJson());

class UserModel {
  String? mobilePhone;
  String userName = '';
  String? uid;
  String avatarUrl = '';
  String email = '';

  static final UserModel userModel = UserModel._internal();

  factory UserModel() {
    return userModel;
  }

  UserModel._internal();

  Map<String, dynamic> toJson() => {
        "mobilePhone": mobilePhone,
        "avatarUrl": avatarUrl,
        "userName": userName,
        "uid": uid,
        "email": email
      };
}

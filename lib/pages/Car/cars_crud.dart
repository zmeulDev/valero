

import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:valero/models/user_model.dart';
import 'package:valero/services/response.dart';


final FirebaseFirestore _firestore = FirebaseFirestore.instance;
final CollectionReference _carCollection = _firestore.collection('cars');

class CarsCrud {

  static Future<Response> addCar({
    required String vin,
    required String userId,
    String? plates = '',
    String? maker = '',
    String? model = '',
    String? year = '',
    String? fuel = '',
    String? inspection = '',
    String? insurance = '',
    String? vignette = '',
    String? note = '',
  }) async {

    Response response = Response();
    DocumentReference documentReferencer =
    _carCollection.doc();

    Map<String, dynamic> data = <String, dynamic>{
      "userId":userId,
      "vin":vin,
      "plates":plates,
      "maker":maker,
      "model":model,
      "year":year,
      "fuel":fuel,
      "inspection":inspection,
      "insurance":insurance,
      "vignette":vignette,
      "note":note,
    };

    var result = await documentReferencer
        .set(data)
        .whenComplete(() {
      response.code = 200;
      response.message = "Successfully added.";
    })
        .catchError((e) {
      response.code = 500;
      response.message = e;
    });

    return response;
  }


  static Stream<QuerySnapshot> readCar() {
    Query<Object?> notesItemCollection =
        _carCollection.where('userId', isEqualTo: UserModel().uid.toString());

    return notesItemCollection.snapshots();
  }

  static Future<Response> updateCar({
    required String userId,
    required String vin,
    required String plates,
    required String maker,
    required String model,
    required String year,
    required String fuel,
    required String inspection,
    required String insurance,
    required String vignette,
    required String note,
    required String docId,
  }) async {
    Response response = Response();
    DocumentReference documentReferencer =
    _carCollection.doc(docId);

    Map<String, dynamic> data = <String, dynamic>{
      "userId":userId,
      "vin":vin,
      "plates":plates,
      "maker":maker,
      "model":model,
      "year":year,
      "fuel":fuel,
      "inspection":inspection,
      "insurance":insurance,
      "vignette":vignette,
      "note":note,
    };

    await documentReferencer
        .update(data)
        .whenComplete(() {
      response.code = 200;
      response.message = "Successfully updated.";
    })
        .catchError((e) {
      response.code = 500;
      response.message = e;
    });

    return response;
  }

  static Future<Response> deleteCar({
    required String docId,
  }) async {
    Response response = Response();
    DocumentReference documentReferencer =
    _carCollection.doc(docId);

    await documentReferencer
        .delete()
        .whenComplete((){
      response.code = 200;
      response.message = "Successfully Deleted.";
    })
        .catchError((e) {
      response.code = 500;
      response.message = e;
    });

    return response;
  }

}
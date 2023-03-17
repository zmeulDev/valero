import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:valero/services/response.dart';


final FirebaseFirestore _firestore = FirebaseFirestore.instance;
final CollectionReference _Collection = _firestore.collection('cars');

class CarsCrud {

  static Future<Response> addCar({
    required String name,
     String? maker = '',
     String? model = '',
  }) async {

    Response response = Response();
    DocumentReference documentReferencer =
    _Collection.doc();

    Map<String, dynamic> data = <String, dynamic>{
      "name": name,
      "maker": maker,
      "model" : model
    };

    var result = await documentReferencer
        .set(data)
        .whenComplete(() {
      response.code = 200;
      response.message = "Sucessfully added.";
    })
        .catchError((e) {
      response.code = 500;
      response.message = e;
    });

    return response;
  }


  static Stream<QuerySnapshot> readCar() {
    CollectionReference notesItemCollection =
        _Collection;

    return notesItemCollection.snapshots();
  }

  static Future<Response> updateCar({
    required String name,
    required String maker,
    required String model,
    required String docId,
  }) async {
    Response response = Response();
    DocumentReference documentReferencer =
    _Collection.doc(docId);

    Map<String, dynamic> data = <String, dynamic>{
      "name": name,
      "maker": maker,
      "model" : model
    };

    await documentReferencer
        .update(data)
        .whenComplete(() {
      response.code = 200;
      response.message = "Sucessfully updated.";
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
    _Collection.doc(docId);

    await documentReferencer
        .delete()
        .whenComplete((){
      response.code = 200;
      response.message = "Sucessfully Deleted.";
    })
        .catchError((e) {
      response.code = 500;
      response.message = e;
    });

    return response;
  }

}
import mysql.connector
from flask import Flask, request, jsonify
import base64
from PIL import Image
import io
import traceback
import face_recognition
app=Flask(__name__)
@app.route('/detect-face', methods=['POST'])
def hello():
    try:
        #encoded_photo = request.files['image1']
        decoded_mobile=request.get_json()
        #decoded_bytes = base64.b64decode(encoded_photo)
        mobile= decoded_mobile.get('id')
        image1 =face_recognition.load_image_file("my_photo\captured_photo.jpg")
 #face_recognition.load_image_file(io.BytesIO(decoded_bytes))
        image2=face_recognition.load_image_file("uploads/"+fetch_data(mobile))
        
        # Detect faces in images
        face_locations1 = face_recognition.face_locations(image1)
        face_locations2 = face_recognition.face_locations(image2)
        print(face_locations1,"\n",face_locations2)
        # If no faces are found in any of the images, return False
        if len(face_locations1) == 0 or len(face_locations2) == 0:
            print(-1)
            return jsonify({"message": "0"}), 200

        # Extract face encodings
        face_encodings1 = face_recognition.face_encodings(image1, face_locations1)
        face_encodings2 = face_recognition.face_encodings(image2, face_locations2)

        # Compare face encodings
        for encoding1 in face_encodings1:
            for encoding2 in face_encodings2:
                # Compare encodings using a threshold (e.g., 0.6 for cosine similarity)
                similarity = face_recognition.face_distance([encoding1], encoding2)
                if similarity < 0.6:  # Adjust the threshold as needed
                    print(1)
                    return  jsonify({"message": "1"}),200  # Faces match
        print(0)
        return jsonify({"message": "0"}),200 

    except Exception as e:
        traceback.print_exc()
        return jsonify({"error": str(e)}), 500
def fetch_data(id):
    """Fetch data from the database and print it."""
    connection = connect_to_database()
    if connection is not None and connection.is_connected():
        cursor = connection.cursor()
        cursor.execute(f"SELECT photo FROM users WHERE mobile={id}")
        
        # Fetch all rows from the last executed statement
        image = cursor.fetchall()
        cursor.close()
        connection.close()
        print(image)
        return image[0][0] if image else None
    else:
        print("Failed to connect to the database")
def connect_to_database():
    try:
        # Connect to the database
        connection = mysql.connector.connect(
            host='localhost',  # usually localhost when using XAMPP
            user='root',       # default user for XAMPP MySQL
            password='',       # default password for XAMPP MySQL is empty
            database='voting' # your database name
        )

        return connection
    except mysql.connector.Error as e:
        print(f"Error connecting to MySQL: {e}")

if __name__ == '__main__':
    app.run(debug=True)
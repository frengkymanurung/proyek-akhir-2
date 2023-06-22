#include <ArduinoWiFiServer.h>
#include <BearSSLHelpers.h>
#include <CertStoreBearSSL.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiAP.h>
#include <ESP8266WiFiGeneric.h>
#include <ESP8266WiFiGratuitous.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266WiFiSTA.h>
#include <ESP8266WiFiScan.h>
#include <ESP8266WiFiType.h>
#include <WiFiClient.h>
#include <WiFiClientSecure.h>
#include <WiFiClientSecureBearSSL.h>
#include <WiFiServer.h>
#include <WiFiServerSecure.h>
#include <WiFiServerSecureBearSSL.h>
#include <WiFiUdp.h>

#include <ESP8266WiFi.h>
// di bagian ini menconectkan ke jaringan
const char* ssid = "Hey";
const char* password = "mintaterus";
// untuk port server dan kita menggunakan port server 80
WiFiServer server(80);
// unutk menyimpan permintaan server http
String header;
// variabel bantuan utk menyimpan status keluaran saat ini
String output3State = "off";
// untuk pin inputan
const int output3 = D3;
//untuk tombol
const int buttonPin = D2;
int buttonState = 0;
void setup() {
Serial.begin(115200);
// unutk keluaran
pinMode(output3, OUTPUT);
//untuk tombol
pinMode(buttonPin, INPUT);
// membuat hasil output LOW
digitalWrite(output3, LOW);
// terhubung ke wifi dengan ssdi dan pass
Serial.print("Connecting to ");
Serial.println(ssid);
WiFi.begin(ssid, password);
Serial.println(WiFi.status());
while (WiFi.status() != WL_CONNECTED) {
delay(500);
Serial.print(".");
}
// membuat alamat local dan mulai web server
Serial.println("");
Serial.println("WiFi connected.");
Serial.println("IP address: ");
Serial.println(WiFi.localIP());
server.begin();
}
void loop(){
WiFiClient client = server.available(); // melihat client yg masuk
buttonState = digitalRead(buttonPin);
// check if the pushbutton is pressed.
// if it is, the buttonState is HIGH:
if (client) { // jika client yg terhubung,
Serial.println("New Client."); // cetak pesan di port serial
String currentLine = ""; // membuat  String untuk menyimpan data yang masuk dari klien
while (client.connected()) { // loop  sementara klien terhubung
if (client.available()) { // jika ada byte untuk dibaca dari klien,
char c = client.read(); // baca byte,lalu
Serial.write(c); // cetaklahmonitor serialnya
header += c;
if (c == '\n') { // jika byteadalah karakter baris baru
// jika baris saat ini kosong, Anda mendapat duakarakter baris baru berturut-turut.
// itulah akhir dari permintaan HTTP klien, jadikirim respons:
if (currentLine.length () == 0) {
// Header HTTP selalu dimulai dengan kode respons (mis. HTTP / 1.1 200 OK)
// dan tipe konten agar klien tahu apa yangakan terjadi, kemudian baris kosong:
client.println("HTTP/1.1 200 OK");
client.println("Content-type:text/html");
client.println("Connection: close");
client.println();
// menyalakan dan mematikan GPIO
if (header.indexOf("GET /3/on") >= 0) {
Serial.println("GPIO 3 on");
output3State = "on";
digitalWrite(output3, HIGH);
} else if (header.indexOf("GET /3/off") >= 0) {
Serial.println("GPIO 3 off");
output3State = "off";
digitalWrite(output3, LOW);
//bagian tombol
if (buttonState == HIGH) {
// turn LED on:
digitalWrite(output3, HIGH);
delay(1000);
}
else {
  //turn LED off:
digitalWrite(output3 , LOW);
}
}if(header.indexOf("GET ")>= 0){
//$url = URL ASAL REQUEST
//$headers = ["Status: ". status = ouput3state]
//$ch = curl_int()
//curl_setopt($ch,CURLOPT_URL,$url)
//curl_setopt($ch,CURLOPT_HTTPHeader,$headers)
//$response = curl_exec($ch)
//}
}
// Tampilkan halaman web HTML
client.println("<!DOCTYPE html><html>");
client.println("<head><meta name=\"viewport\"content=\"width=device-width, initial-scale=1\">");
client.println("<link rel=\"icon\"href=\"data:,\">");
// CSS untuk menata tombol on / off
// Jangan ragu untuk mengubah warna latar dan atribut ukuran font agar sesuai dengan preferensi Anda
client.println("<style>html { font-family:Helvetica; display: inline-block; margin: 0px auto; textaligncenter;}");
client.println(".button { background-color:#195B6A; border: none; color: white; padding: 16px 40px;");
client.println("text-decoration: none; fontsize:30px; margin: 2px; cursor: pointer;}");
client.println(".button2 {background-color:#77878A;}</style></head>");

client.println("<style>html { font-family:Helvetica; display: inline-block; margin: 0px auto; textaligncenter;}");
client.println(".button { background-color:#195B6A; border: none; color: white; padding: 16px 40px;");
client.println("text-decoration: none; fontsize:30px; margin: 2px; cursor: pointer;}");
client.println(".button2 {background-color:#77878A;}</style></head>");
// Tajuk Halaman Web
client.println("<body><h1>PA 2</h1>");
// Tampilkan status saat ini, dan tombol ON / OFF untuk Pin 3
client.println("<p>GPIO 3 - State " +
output3State + "</p>");
// Jika output3 State mati, ini akan menampilkan tombol ON
if (output3State=="off") {
client.println("<p><a href=\"/3/on\"><button class=\"button\">ON</button></a></p>");
} else {
client.println("<p><a href=\"/3/off\"><button class=\"button button2\">OFF</button></a></p>");
}

client.println("</body></html>");
// Respons HTTP berakhir dengan baris kosong lain
client.println();
// Keluar dari loop sementara
break;
} else { // jika Anda mendapat baris baru, maka bersihkan currentLine
currentLine = "";
}
} else if (c != '\r') { // jika Anda mendapatkan hal lain selain karakter carriage return,
currentLine += c; // tambahkan ke akhir currentLine
}
}
}
// Bersihkan variabel tajuk
header = "";
// tutup koneksi
client.stop();
Serial.println("Client disconnected.");
Serial.println("");
}
}
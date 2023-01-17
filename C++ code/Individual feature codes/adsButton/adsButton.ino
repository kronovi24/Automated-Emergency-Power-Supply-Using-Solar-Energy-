#include <SPI.h>
#include <Wire.h>
#include <Adafruit_ADS1015.h>

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
const char* ssid = "TARATITATWIFI";
const char* password = "taratitat1234";

///ads1115 variables/////
////voltage and ampheres reading////
Adafruit_ADS1115 ads2(0x49);
int16_t adc0, adc1, adc2 , adc3;

int del = 0;
int del2 = 0;
int del3 = 0;
int del4 = 0;

int dcState = 0;

//Your Domain name with URL path or IP address with path
String PostControlServer = "http://mobilesolarmonitoring.scienceontheweb.net/control.php";

String dc_button = "OFF";
String ac_button = "OFF";
String panel_button = "OFF";
String auto_button = "OFF";

int check = 0;

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  ads2.begin();
}

void loop() {
  // put your main code here, to run repeatedly:
  adc0 = ads2.readADC_SingleEnded(0);
  adc1 = ads2.readADC_SingleEnded(1);
  adc2 = ads2.readADC_SingleEnded(2);
  adc3 = ads2.readADC_SingleEnded(3);

  ///check wifi connection
  while (check == 0) {
    if (WiFi.status() != WL_CONNECTED) {
      Serial.println("Connecting...");
    }
    else {
      Serial.println("");
      Serial.print("Connected to WiFi network with IP Address: ");
      Serial.println(WiFi.localIP());
      check = 1;

    }
  }
  //////////////////////
  // button 1
  if (adc0 > 1000) {
    while (del == 0) {
      if (dc_button == "OFF") {
        dc_button = "ON";
        del = 1;
      }
      else {
        dc_button = "OFF";
        del = 1;
      }
      Serial.println(dc_button);
      postControl();
    }
  }
  else {
    del = 0;
  }
///////////////////////////////////
  // button 2
  if (adc1 > 1000) {
    while (del2 == 0) {
      if (ac_button == "OFF") {
        ac_button = "ON";
        del2 = 1;
      }
      else {
        ac_button = "OFF";
        del2 = 1;
      }
      Serial.println(ac_button);
      postControl();
    }
  }
  else {
    del2 = 0;
  }
  ////////////////////////////////////
  // button 3
  if (adc2 > 1000) {
    while (del3 == 0) {
      if (panel_button == "OFF") {
        panel_button = "ON";
        del3 = 1;
      }
      else {
        panel_button = "OFF";
        del3 = 1;
      }
      Serial.println(panel_button);
      postControl();
    }
  }
  else {
    del3 = 0;
  }
  ////////////////////////////////////
  // button 4
  if (adc3 > 1000) {
    while (del4 == 0) {
      if (auto_button == "OFF") {
        auto_button = "ON";
        del4 = 1;
      }
      else {
        auto_button = "OFF";
        del4 = 1;
      }
      Serial.println(auto_button);
      postControl();
    }
  }
  else {
    del4 = 0;
  }
  ////////////////////////////////////
  
}

void postControl() {
  //Start na pag send nan data sa database
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    // Your Domain name with URL path or IP address with path
    http.begin(client, PostControlServer);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare your HTTP POST request data
    String httpRequestData = "dc_button=" + dc_button + "&ac_button=" + ac_button + "&panel_button=" + panel_button + "&auto_button=" + auto_button;
    Serial.println(httpRequestData);

    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);

    if (httpResponseCode > 0) {
      Serial.println(httpResponseCode);
    }
    else {
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }

}
String httpGETRequest(const char* serverName) {
  WiFiClient client;
  HTTPClient http;

  // Your IP address with path or Domain name with URL path
  http.begin(client, serverName);

  // Send HTTP POST request
  int httpResponseCode = http.GET();

  String payload = "{}";

  if (httpResponseCode > 0) {
    Serial.println(httpResponseCode);
    payload = http.getString();
  }
  else {
    Serial.println(httpResponseCode);
  }
  // Free resources
  http.end();

  return payload;
}

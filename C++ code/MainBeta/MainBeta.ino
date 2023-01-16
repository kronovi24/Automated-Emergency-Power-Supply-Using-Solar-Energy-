#include <SPI.h>
#include <Wire.h>
#include <Adafruit_ADS1015.h>

////oled 128x32 imports ssd1306 gamay na oled
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#define SCREEN_WIDTH1 128 // OLED display width, in pixels
#define SCREEN_HEIGHT1 32 // OLED display height, in pixels
// Declaration for an SSD1306 display connected to I2C (SDA, SCL pins)
Adafruit_SSD1306 display(SCREEN_WIDTH1, SCREEN_HEIGHT1, &Wire, -1);

/// oled sh1106 dako na oled
#include <Adafruit_SH110X.h>
#define i2c_Address 0x3d //initialize with the I2C addr 0x3C Typically eBay OLED's
#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 64 // OLED display height, in pixels
#define OLED_RESET -1   //   QT-PY / XIAO
Adafruit_SH1106G display2 = Adafruit_SH1106G(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);


///get data imports
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <Arduino_JSON.h>
#include <ArduinoJson.h>
const char* ssid = "OPPO A92";
const char* password = "wayakokabayo24";
String jsonBuffer;


///button setuup and variables
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
String controlID = "OFF";

int16_t value0, value1, value2 , value3;

int check = 0;


//post data imports
String panel_voltage = "0";
String panel_amps = "0";
String battery_voltage = "0";
String battery_amps = "0";
String wattage = "0";
String temperature = "0";

//Your Domain name with URL path or IP address with path
String postServer = "http://mobilesolarmonitoring.scienceontheweb.net/index.php";


///ads1115 variables/////
////voltage and ampheres reading////
Adafruit_ADS1115 ads(0x48);
Adafruit_ADS1115 ads2(0x49);
int16_t adc0, adc1, adc2 , adc3;

//current sensor variables
double acsIN = 0;
double acsIN2 = 0;

double batt_amps = 0;
double pan_amps = 0;


//Voltage reading
float analogIN = 0 ;
float analogIN2 = 0;

int calib = 9;
float batt_voltage = 0;
float pan_voltage = 0;
float Radjust = 0.043421905;

//millis delay
unsigned long timerDelay = 1000;
unsigned long lastTime = 0;

int dc_relay = D0;
int panel_relay = D5;
int ac_relay = D6;
int low_voltage = D7;

int connectp = 1;
int noData = 1;

int watt = 0;
int pan_watt = 0;


///battery percentage constants
float max_volts = 12.6;
float min_volts = 10.7;
float max_x = 1.9;
float cur = 0;
float yarn = 0;
int percent = 0;

///Ac detection constants
const int sensor = A0;
int set1 = 0;
int set2 = 0;
int set3 = 0;
float final_set = 0;
String ac_detect = "awitize";

void setup()
{

  /////
  pinMode(dc_relay, OUTPUT);
  pinMode(panel_relay, OUTPUT);
  pinMode(ac_relay, OUTPUT);
  pinMode(low_voltage , OUTPUT);


  Serial.begin(115200);
  WiFi.begin(ssid, password);
  Serial.println("Connecting");

  display.begin(SSD1306_SWITCHCAPVCC, 0x3c);
  display2.begin(i2c_Address, true); // Address 0x3C default

  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 10);
  // Display static text
  display.println("Welcome!!!");
  display.display();

  //                                                                ADS1015  ADS1115
  //                                                                -------  -------
  // ads.setGain(GAIN_TWOTHIRDS);  // 2/3x gain +/- 6.144V  1 bit = 3mV      0.1875mV (default)
  ads.begin();
  ads2.begin();

}

void loop()
{
  if ((millis() - lastTime) > timerDelay) {
    ///every second loop without machine delay

    ///check wifi connection
    if (connectp == 1) {
      if (WiFi.status() != WL_CONNECTED) {
        Serial.println("Connecting...");
      }
      else {
        Serial.println("");
        Serial.print("Connected to WiFi network with IP Address: ");
        Serial.println(WiFi.localIP());
        connectp = 0;
      }
    }
    /////
    if (noData == 1) {
      initialGetData();
      Serial.println("noData" + String(noData));
    }
    else {
      GetData();
    }

    getCurrent();
    getVoltage();
    getAC();
    battery_calc();
    ssdDisplay();
    postData();

    /////////////////////////////////////////
    lastTime = millis();
  }

  /////// loop without delay
  buttonControl();

  //dc relay
  if (dc_button == "ON") {
    digitalWrite(dc_relay, HIGH);
  }
  else {
    digitalWrite(dc_relay, LOW);
  }
  ///ac relay
  if (ac_button == "ON") {
    digitalWrite(ac_relay, HIGH);
  }
  else {
    digitalWrite(ac_relay, LOW);
  }

  ///panel relay
  if (panel_button == "ON") {
    digitalWrite(panel_relay, HIGH);
  }
  else {
    digitalWrite(panel_relay, LOW);
  }

  ///low voltage relay diconnect ///
  if (batt_voltage < 10.7) {
    digitalWrite(low_voltage, LOW);
  }
  else {
    digitalWrite(low_voltage, HIGH);
  }

  if (auto_button == "ON") {
    if (ac_detect == "false") {
      dc_button = "ON";
      postControl();
    }
    else if (ac_detect == "true") {

      dc_button = "OFF";
      postControl();
    }
  }
}


void buttonControl() {
  // read analog signal
  value0 = ads2.readADC_SingleEnded(0);
  value1 = ads2.readADC_SingleEnded(1);
  value2 = ads2.readADC_SingleEnded(2);
  value3 = ads2.readADC_SingleEnded(3);

  // button 1
  if (value0 > 1000) {
    while (del == 0) {
      if (dc_button == "OFF") {
        dc_button = "ON";
        del = 1;
      }
      else {
        dc_button = "OFF";
        del = 1;
      }
      postControl();
    }
  }
  else {
    del = 0;
  }
  ///////////////////////////////////
  // button 2
  if (value1 > 1000) {
    while (del2 == 0) {
      if (ac_button == "OFF") {
        ac_button = "ON";
        del2 = 1;
      }
      else {
        ac_button = "OFF";
        del2 = 1;
      }
      postControl();
    }
  }
  else {
    del2 = 0;
  }
  ////////////////////////////////////
  // button 3
  if (value2 > 1000) {
    while (del3 == 0) {
      if (panel_button == "OFF") {
        panel_button = "ON";
        del3 = 1;
      }
      else {
        panel_button = "OFF";
        del3 = 1;
      }
      postControl();
    }
  }
  else {
    del3 = 0;
  }
  ////////////////////////////////////
  // button 4
  if (value3 > 1000) {
    while (del4 == 0) {
      if (auto_button == "OFF") {
        auto_button = "ON";
        del4 = 1;
      }
      else {
        auto_button = "OFF";
        del4 = 1;
      }
      postControl();
    }
  }
  else {
    del4 = 0;
  }
  ////////////////////////////////////

}

void getCurrent() {
  adc1 = ads.readADC_SingleEnded(1);
  adc3 = ads.readADC_SingleEnded(3);

  acsIN = ((adc1) * 0.1875) / 1000;
  batt_amps = (acsIN - 2.51) / 0.066;
  if (batt_amps < 0.01) {
    batt_amps = 0;
  }

  acsIN2 = ((adc3) * 0.1875) / 1000;
  pan_amps = (acsIN2 - 2.51) / 0.066;
  if (pan_amps < 0.01) {
    pan_amps = 0;
  }

  panel_amps = String(pan_amps, 2);
  battery_amps = String(batt_amps, 2);

  watt = batt_amps * batt_voltage;
  pan_watt = pan_amps * pan_voltage;
  wattage = String(watt, 2);

}

void getVoltage() {
  /// battery voltage reading
  adc0 = ads.readADC_SingleEnded(0);
  analogIN = ((adc0) * 0.1875) / 1000;
  batt_voltage = (analogIN / Radjust);
  battery_voltage = String(batt_voltage, 2);

  adc2 = ads.readADC_SingleEnded(2);
  analogIN2 = ((adc2) * 0.1875) / 1000;
  pan_voltage = (analogIN2 / Radjust);
  panel_voltage = String(pan_voltage, 2);


}

void initialGetData() {
  if (WiFi.status() == WL_CONNECTED) {
    String serverPath = "http://mobilesolarmonitoring.scienceontheweb.net/lastcontrol.php";
    jsonBuffer = httpGETRequest(serverPath.c_str());
    Serial.println(jsonBuffer);

    // Stream& input;
    StaticJsonDocument<192> doc;
    DeserializationError error = deserializeJson(doc, jsonBuffer);
    if (error) {
      Serial.print(F("deserializeJson() failed: "));
      Serial.println(error.f_str());
      noData = 1;
      return;
    }

    JsonObject root_0 = doc[0];
    const char* root_0_ID = root_0["ID"]; // "23"
    const char* root_0_dc_button = root_0["dc_button"]; // "ON"
    const char* root_0_ac_button = root_0["ac_button"]; // "OFF"
    const char* root_0_panel_button = root_0["panel_button"]; // "OFF"
    const char* root_0_auto_button = root_0["auto_button"]; // "OFF"

    controlID = String(root_0_ID);
    dc_button = String(root_0_dc_button);
    ac_button = String(root_0_ac_button);
    panel_button = String(root_0_panel_button);
    auto_button = String(root_0_auto_button);
    //Serial.println(dc_button);
    noData = 0;

  }
  else {
    Serial.println("WiFi Disconnected");
    noData = 1;
  }
}

void GetData() {
  if (WiFi.status() == WL_CONNECTED) {
    String serverPath = "http://mobilesolarmonitoring.scienceontheweb.net/lastcontrol.php";
    jsonBuffer = httpGETRequest(serverPath.c_str());
    Serial.println(jsonBuffer);

    // Stream& input;
    StaticJsonDocument<192> doc;
    DeserializationError error = deserializeJson(doc, jsonBuffer);
    if (error) {
      Serial.print(F("deserializeJson() failed: "));
      Serial.println(error.f_str());
      return;
    }

    JsonObject root_0 = doc[0];
    const char* root_0_ID = root_0["ID"]; // "23"
    const char* root_0_dc_button = root_0["dc_button"]; // "ON"
    const char* root_0_ac_button = root_0["ac_button"]; // "OFF"
    const char* root_0_panel_button = root_0["panel_button"]; // "OFF"
    const char* root_0_auto_button = root_0["auto_button"]; // "OFF"
    if (String(root_0_ID) != controlID) {
      dc_button = String(root_0_dc_button);
      ac_button = String(root_0_ac_button);
      panel_button = String(root_0_panel_button);
      auto_button = String(root_0_auto_button);
      //Serial.println(dc_button);
    }
  }
  else {
    Serial.println("WiFi Disconnected");
  }
}


void postData() {
  //Start na pag send nan data sa database
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;

    // Your Domain name with URL path or IP address with path
    http.begin(client, postServer);

    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    // Prepare your HTTP POST request data
    String httpRequestData = "panel_voltage=" + panel_voltage + "&panel_amps=" + panel_amps + "&battery_voltage=" +
                             battery_voltage + "&battery_amps=" + battery_amps + "&wattage=" + wattage  + "&ac_detect=" + ac_detect ;
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

void ssdDisplay() {
  display.clearDisplay();
  display2.clearDisplay();

  display2.setTextSize(1);
  display2.setTextColor(WHITE);
  display2.setCursor(0, 1);
  // Display static text
  display2.print("Battery Voltage:");
  display2.print(battery_voltage);
  display2.print("v");

  display2.setCursor(0, 10);
  // Display static text
  display2.print("Battery Amps:");
  display2.print(battery_amps);
  display2.print("amps");

  // Display static text
  display2.setCursor(0, 20);
  display2.print("Wattage:");
  display2.print(watt);
  display2.print("Watts");
  display2.display();

  // Display static text
  display2.setCursor(0, 30);
  display2.print("Battery Percent:");
  display2.print(percent);
  display2.print("%");
  display2.display();

  ///// panel side lcd
  float final_watts  = (pan_amps * batt_voltage);
  display.setCursor(0, 1);
  display.print("Amps:");
  display.print(pan_amps);
  display.print("amps");

  display.setCursor(0, 10);
  display.print("Watts:");
  display.print(final_watts);
  display.print("watts");

  display.setCursor(0, 20);
  display.print(auto_button + " " + ac_detect + " " + String(final_set));


  display.display();

}
void getAC() {
  // put your main code here, to run repeatedly:
  set1 = analogRead(sensor);
  set2 = analogRead(sensor);
  set3 = analogRead(sensor);
  final_set = (set1 + set2 + set3) / 3;
  //Serial.println(final_set);
  if (final_set >= 820 && final_set <= 825) {
    ac_detect = "false";
  }
  else {
    ac_detect = "true";
  }
}



void battery_calc() {

  cur = batt_voltage - min_volts;
  percent = (cur / max_x) * 100;
}

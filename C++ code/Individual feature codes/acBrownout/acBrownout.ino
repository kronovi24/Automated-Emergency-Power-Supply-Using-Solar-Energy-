const int sensor = A0;

int value = 0;
int value1 = 0;
int value2 = 0;
float finalv = 0;
void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
  value = analogRead(sensor);
  value1 = analogRead(sensor);
  value2 = analogRead(sensor);
  finalv = (value + value1 + value2) / 3;
  Serial.println(finalv);
  if (finalv > 561 || finalv < 559) {
    Serial.println("AC DETECTED");
  }
  else {
    Serial.println("NO AC DETECTED");
  }
  delay(1000);
}

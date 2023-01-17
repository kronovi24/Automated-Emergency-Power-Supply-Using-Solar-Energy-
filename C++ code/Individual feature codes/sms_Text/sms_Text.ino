int x = 1;
void setup()
{
  //Begin nodemcu serial-0 channel
  Serial.begin(9600);
}
void loop()
{ while(x==1){
  Serial.write("AT");  //Start Configuring GSM Module
  delay(1000);         //One second delay
  Serial.println();
  Serial.write("AT");  //Start Configuring GSM Module
  delay(1000);         //One second delay
  
  Serial.println();
  Serial.println("AT+CMGF=1");  // Set GSM in text mode
  delay(1000);                  // One second delay
  Serial.print("AT+CMGS=");     // Enter the receiver number
  Serial.print("\"+639385411239\"");
  Serial.println();
  delay(1000);
  Serial.print("We are under attack sire"); // SMS body - Sms Text
  delay(1000);
  Serial.println();
  Serial.write((char)26);                //CTRL+Z Command to send text and end session                       //Just send the text ones and halt
  Serial.println();
  x = 2;
}
}

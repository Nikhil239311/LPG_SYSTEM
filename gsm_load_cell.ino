#include "HX711.h"
#include <SoftwareSerial.h>
SoftwareSerial mySerial(10,11);//rx,tx

#define calibration_factor 108326 //This value is obtained using the SparkFun_HX711_Calibration sketch

#define LOADCELL_DOUT_PIN  3
#define LOADCELL_SCK_PIN  2

HX711 scale;

void setup() {
  Serial.begin(9600);
   mySerial.begin(9600);   // Setting the baud rate of GSM Module  
  
  delay(100);
  

  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);
  scale.set_scale(calibration_factor); //This value is obtained by using the SparkFun_HX711_Calibration sketch
  scale.tare(); //Assuming there is no weight on the scale at start up, reset the scale to 0

  Serial.println("Readings:");
}

void loop() {
  Serial.print("Reading: ");
  
  Serial.print(scale.get_units(),4); //scale.get_units() returns a float
  //Serial.print(weight);
  Serial.print(" kg"); //You can change this to kg but you'll need to refactor the calibration_factor
  Serial.println();
  
  if ((scale.get_units()) < 1.0){
    SendMessage();
    Serial.println("LOW GAS..");
    
  }
}

 void SendMessage()
{
  mySerial.println("AT+CMGF=1");    //Sets the GSM Module in Text Mode
  delay(1000);  // Delay of 1000 milli seconds or 1 second
  mySerial.println("AT+CMGS=\"+917020260914\"\r"); // Replace x with mobile number
  delay(1000);
  mySerial.println("LOW GAS..");// The SMS text you want to send
  delay(100);
   mySerial.println((char)26);// ASCII code of CTRL+Z
  delay(1000);
}

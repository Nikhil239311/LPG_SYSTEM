#include "HX711.h"
#include <SoftwareSerial.h>
#include<Servo.h>
SoftwareSerial mySerial(10,11);//rx,tx

#define calibration_factor 110350 //This value is obtained using the SparkFun_HX711_Calibration sketch

#define LOADCELL_DOUT_PIN  3
#define LOADCELL_SCK_PIN  2
Servo myservo;
HX711 scale;

const int DO_Pin=12;

const int buzzerPin = 8; // Digital pin for buzzer


void setup() {
  
  Serial.begin(9600);
   mySerial.begin(9600);   // Setting the baud rate of GSM Module  
  Serial.println("Start:");
  delay(100);
  
  myservo.attach(9);
  myservo.write(0);
  delay(200);
  pinMode(buzzerPin, OUTPUT);

  pinMode(DO_Pin, INPUT); // Configure D8 pin as a digital input pin
    
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

    int threshold= analogRead(A0);
    Serial.print("threshold_value: ");
    Serial.print(threshold);                      //prints the threshold_value reached as either LOW or HIGH (above or underneath)
    delay(100);
    
    if (threshold > 500) {
      
        myservo.write(90);
    
        
        delay(200);
        digitalWrite(buzzerPin, HIGH); // Turn on the buzzer
        delay(200); // Buzzer on time
        digitalWrite(buzzerPin, LOW);  // Turn off the buzzer
        
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

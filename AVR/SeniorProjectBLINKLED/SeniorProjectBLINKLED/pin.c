//pin.c
//this file contains useful functions for pin manipulation
/************************************************************************/
/*                    Pin Manipulation                                  */
/************************************************************************/
#include "pin.h"

//_BV is bit value
//it makes 	PORTB |= (1 << PB6);
// the same as 	PORTB |= _BV(6);

//Set pin as an output
void pin_output(struct Pin pin)
{
	*(pin.Reg) |= _BV(pin.No);
}

//Set pin as input
void pin_input(struct Pin pin)
{
	*(pin.Reg) &= ~(_BV(pin.No));
}

//Set pin level High
void pin_high(struct Pin pin)
{
	*(pin.Port) |= _BV(pin.No);
}

//Set pin level low
void pin_low(struct Pin pin)
{
	// PORTD &= ~(1 << n); equivalent to ~(_BV(n));
	//PORTD &= ~(1 << n);
	*(pin.Port) &= ~( 1 << (pin.No));
}

//Toggle pin level.
void pin_toggle(struct Pin pin)
{
	*(pin.Port) ^= _BV(pin.No);
}

//Returns boolean true if high| false if low;
uint8_t pin_read(struct Pin pin)
{
	//printf("%d \r\n",pin_read(pin7));
	//_delay_ms(100);
	//Button setup http://arduino.cc/en/tutorial/button
	uint8_t value = (*(pin.InputPin) & _BV(pin.No));
	return value;
}

/************************************************************************/
/*                      End Pin Manipulation                            */
/************************************************************************/



/************************************************************************/
/*                      OCR Pins Setup                                  */
/************************************************************************/

//set up struct for OCR pins
void init_OCR_pins()
{
	pinOCR1A.No = PD5;
	pinOCR1A.Port = &PORTD;
	pinOCR1A.Reg = &DDRD;
	pinOCR1A.OCReg = &OCR1A;
	
	pinOCR1B.No = PE2;
	pinOCR1B.Port = &PORTE;
	pinOCR1B.Reg = &DDRE;
	pinOCR1B.OCReg = &OCR1B;
	
	/*
	
	//Make a pin struct for LED
	struct Pin pin6;
	pinUnlockedLS.No = DDA6;
	pinUnlockedLS.Port = &PORTA;
	pinUnlockedLS.Reg = &DDRA;
	pinUnlockedLS.InputPin = &PINA;
	pin_input(pinUnlockedLS);
		*/
	
}

//Define Pins for limit switch.
void init_LOCK_pins()
{
		
		//set up struct for limit switch pins PD2 and PD3
		pinLockedLS.InputPin = &PIND;
		pinLockedLS.No = PD2;
		pinLockedLS.Port = &PORTD;
		pinLockedLS.Reg = &DDRD;
		
		
		pinUnlockedLS.InputPin = &PIND;
		pinUnlockedLS.No = PD3;
		pinUnlockedLS.Port = &PORTD;
		pinUnlockedLS.Reg = &DDRD;
		
		//turn on internal pull-up resistor for the switch */
		pin_high(pinUnlockedLS);
		pin_high(pinLockedLS);
		//DDRC = 0xFF;
		//PORTC = 0x01;
		
		//pin_input(pinLockedLS);
		//pin_input(pinUnlockedLS);
	
}


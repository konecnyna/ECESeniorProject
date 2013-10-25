/************************************************************************/
/*                    Pin Manipulation                                  */
/************************************************************************/
#include "pin.h"

void pin_output(struct Pin pin)
{
	//Set pin as an output
	*(pin.Reg) |= _BV(pin.No);
}

void pin_input(struct Pin pin)
{
	//Set pin as input
	*(pin.Reg) &= ~(_BV(pin.No));
}

void pin_high(struct Pin pin)
{
	//Set pin level High
	*(pin.Port) |= _BV(pin.No);
}

void pin_low(struct Pin pin)
{
	//Set pin level low
	// PORTD &= ~(1 << n); equivalent to ~(_BV(n));
	//PORTD &= ~(1 << n);
	*(pin.Port) &= ~( 1 << (pin.No));
}

void pin_toggle(struct Pin pin)
{
	//Toggle pin level.
	*(pin.Port) ^= _BV(pin.No);
}


uint8_t pin_read(struct Pin pin)
{
	//printf("%d \r\n",pin_read(pin7));
	//_delay_ms(100);
	//Button setup http://arduino.cc/en/tutorial/button
	//Returns boolean true if high| false if low;
	uint8_t value = (*(pin.InputPin) & _BV(pin.No));
	return value;
}

/************************************************************************/
/*                      End Pin Manipulation                            */
/************************************************************************/



/************************************************************************/
/*                      OCR Pins Setup                                  */
/************************************************************************/

void init_OCR_pins()
{
	//OCR pins
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

void init_LOCK_pins()
{
		//Define Pins for limit switch.

		pinLockedLS.InputPin = 0;
		pinLockedLS.No = PD2;
		pinLockedLS.Port = &PORTD;
		pinLockedLS.Reg = &DDRD;
		
		
		pinUnlockedLS.InputPin = 0;
		pinUnlockedLS.No = PD3;
		pinUnlockedLS.Port = &PORTD;
		pinUnlockedLS.Reg = &DDRD;
		
		DDRC = 0xFF;
		PORTC = 0x01;
	
}


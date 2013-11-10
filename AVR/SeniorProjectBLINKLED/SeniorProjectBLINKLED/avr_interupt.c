#include "avr_interupt.h"
#include "pin.h"
/************************************************************************/
/*             Intertups                                                */
/* Setup: connect 5v to one side of button | wire to pd2/3 and resistor */
/* to ground.
/************************************************************************/
void init_hardware_interupt()
{
	//http://www.avr-tutorials.com/interrupts/avr-external-interrupt-c-programming
	//http://www.instructables.com/id/Foot-Tap-Amplifier/step8/Build-and-program-the-circuit-for-the-chiseling-un/
	//https://github.com/Robopoly/mini-arches/blob/master/int_ext.c
	//Pd2 and pd3 are interupts


	init_LOCK_pins();
	
	//Enable Interupt
	
	//GICR = 1<<INT0;
	
	//Rising Edge
	//GICR |= (1<<INT0) + (1<<INT1); //Enable interupt reg
	//MCUCR = 1<<ISC01 | 1<<ISC00; //Trigger on rising edge
	//DDRD &= ~(1<<PD2); //this was 1<<2 should be fine.
	
	//Rising Edge
	MCUCR |= (1<<ISC00);
	MCUCR &= ~(1<<ISC01);
	
	GICR |= (1<<INT0);
	DDRD &= ~(1<<PD2);
	
	
	MCUCR |= (1 << ISC10);
	GICR |= (1 << INT1);
	DDRD &= ~(1<<PD3);
	
	//Global interupts
	sei();

}

void init_software_interupt(double time)
{
	//http://www.engblaze.com/microcontroller-tutorial-avr-and-arduino-timer-interrupts/
	// 1 Second = 7812
	// Calc: Desiredtime/( (1/F)/1024 )
	// 1 / (1/( (8*10^6)/1024) ) = 7812 ~ 1 second
	
	//Clock/prescaller => 8MHz / 1024 = 7


	OCR1A = time;
	TCCR1A = 0;
	TCCR1B = 0;
	TCCR1B |= (1 << WGM12);
	TCCR1B |= (1<<CS10);
	TCCR1B |= (1<<CS12);
	TIMSK |= (1 << OCIE1A);
	sei();

}



//Timer Interupt
int seconds = 0;
ISR(TIMER1_COMPA_vect){
	//OCR1A = (dutyCycle/100.0)*255.0;
	seconds++;
	printf("in timer overflow: %d seconds have passed\r\n",seconds);
	in_progress = FALSE;
	//_delay_ms(100);
}



//Hardware Interupt
//Async task
int i = 0;
ISR(INT0_vect)
{
	pin_low(pinOCR1A);
	//PD2 and PD3 are external interupts.
	in_progress = FALSE;
	printf("In locked HW interrupt %d, In_progress = %d\r\n", i, in_progress);
	return 0;
}
ISR(INT1_vect)
{
	pin_low(pinOCR1B);
	in_progress = FALSE;
	printf("in unlock HW interrupt %d\r\n", i);
	return 0;
}
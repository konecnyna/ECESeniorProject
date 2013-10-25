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
	//Pd2 and pd3 are interupts


	//FIX: This does not work for other PD3....
	//pin_input(pinLockedLS);
	//pin_input(pinUnlockedLS);
	//PORTD = 1<<PD2;

	//PORTD = 1<<PD3; //fix this
	init_LOCK_pins();
	
	//Enable Interupt
	GICR = 1<<INT0;
	//GICR = 1<<INT1;
	MCUCR = 1<<ISC01 | 1<<ISC00;
	sei();

}

//Ever time PWM overflows do this
//Todo: This doesn't work fix it
/*

//Get this to be a interupt for serial
ISR(TIMER0_OVF_vect){
	OCR1A = (dutyCycle/100.0)*255.0;
}
*/


void init_software_interupt(double time)
{
	//http://www.engblaze.com/microcontroller-tutorial-avr-and-arduino-timer-interrupts/
	// 1 Second = 7812
	// Calc: Desiredtime/( (1/F)/1024 )
	// 1 / (1/( (8*10^6)/1024) ) = 7812 ~ 1 second

	OCR0 = time;
	TCCR1A = 0;
	TCCR1B = 0;
	TCCR1B |= (1 << WGM12);
	TCCR1B |= (1<<CS10);
	TCCR1B |= (1<<CS12);



	//http://www.avrfreaks.net/index.php?name=PNphpBB2&file=viewtopic&t=47000
	///TCCR0 = _BV(CS02) | _BV(CS00);
	///TIMSK = _BV(TOIE0);


	TIMSK |= (1 << OCIE1A);
	//TCCR0 |= (1 << CS10);

}



//Timer Interupt
int seconds = 0;
ISR(TIMER1_COMPA_vect){
	//OCR1A = (dutyCycle/100.0)*255.0;
	seconds++;
	printf("in timer overflow: %d seconds have passed\r\n", seconds);
	//_delay_ms(100);
}

//Hardware Interupt
//Async task
int i = 0;
ISR(INT0_vect)
{
	//PD2 and PD3 are external interupts.
	_delay_ms(DEBOUNCE_TIME);
	in_progress = FALSE;
	i++;
	printf("In locked HW interrupt %d, In_progress = %d\r\n", i, in_progress);
}
ISR(INT1_vect)
{
	printf("in unlock HW interrupt");
}
//avr_interrupt.c
//this file has the init functions for interrupts on the AVR

#include "avr_interupt.h"
#include "pin.h"
/************************************************************************/
/*             Intertups                                                */
/* Setup: connect 5v to one side of button | wire to pd2/3 and resistor */
/* to ground.                                                           */
/************************************************************************/

//This function is not used, but would have initiallized hardware interrupts
void init_hardware_interupt()
{
	//http://www.avr-tutorials.com/interrupts/avr-external-interrupt-c-programming
	//http://www.instructables.com/id/Foot-Tap-Amplifier/step8/Build-and-program-the-circuit-for-the-chiseling-un/
	//https://github.com/Robopoly/mini-arches/blob/master/int_ext.c
	//Pd2 and pd3 are interupts


	init_LOCK_pins();	//initiallizes the switch pins
	
	//Enable Interupt
	
	//GICR = 1<<INT0;
	
	//Rising Edge
	//GICR |= (1<<INT0) + (1<<INT1); //Enable interupt reg
	//MCUCR = 1<<ISC01 | 1<<ISC00; //Trigger on rising edge
	//DDRD &= ~(1<<PD2); //this was 1<<2 should be fine.
	
	//Rising Edge
	MCUCR |= (1<<ISC00);	//MCU control register, set interrupt sense control to 01
	MCUCR &= ~(1<<ISC01);	//This means any logical change to INT0 generates an interrupt
	
	GICR |= (1<<INT0);	//general interrupt control register, enable INT0 bit for interrupts
	DDRD &= ~(1<<PD2);	//INT0 uses PD2 on port D for interrupts, so PD2 is set low.
	
	
	MCUCR |= (1 << ISC10);	//set interrupt sense control to 01 for any logical change
				//on INT1 to generate and interrupt
	GICR |= (1 << INT1);	//enable INT1 bit for interrupts
	DDRD &= ~(1<<PD3);	//INT1 uses PD3 on port D, so PDC is set low
	
	//Global interupts
	sei();			//initializes global interrupts

}

//This function initiallizes software interrupts
void init_software_interupt(double time)
{
	//http://www.engblaze.com/microcontroller-tutorial-avr-and-arduino-timer-interrupts/
	// 1 Second = 7812
	// Calc: Desiredtime/( (1/F)/1024 )
	// 1 / (1/( (8*10^6)/1024) ) = 7812 ~ 1 second
	
	//Clock/prescaller => 8MHz / 1024 = 7


	OCR1A = time;			//set output compare register A to the time input
	TCCR1A = 0;			//timer/counter1 control register a set to "normal"
					//counter mode of operation
	
	TCCR1B = 0;			//timer/counter1 control register a set to "normal
					//counter mode of operation
	
	TCCR1B |= (1 << WGM12);		//enables CTC mode of operation on TCCR1B
					//this clears the timer after every compare
	
	TCCR1B |= (1<<CS10);		//these next two choose clock select to be
	TCCR1B |= (1<<CS12);		//clock/1024 for equation above

	TIMSK |= (1 << OCIE1A);		//timer/counter interrupt mask register set to enable
					//timer/counter1 compare A Match

	sei();				//globally initializes interrupts

}



//Software Timer Interupt

ISR(TIMER1_COMPA_vect){
	//Turn off motor if overflown/overflowed?.
	in_progress = FALSE;
	
}



//Hardware Interupt service routines, not used
//Async task
int i = 0;
ISR(INT0_vect)	//not used
{
	pin_low(pinOCR1A);
	//PD2 and PD3 are external interupts.
	in_progress = FALSE;
	printf("In locked HW interrupt %d, In_progress = %d\r\n", i, in_progress);
}
ISR(INT1_vect)	//not used
{
	pin_low(pinOCR1B);
	in_progress = FALSE;
	printf("in unlock HW interrupt %d\r\n", i);
}

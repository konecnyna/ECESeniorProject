/*
 * SeniorProjectBLINKLED.c
 *
 * Created: 9/24/2013 5:25:34 PM
 * Author: Nick Konecny and Devan Houlihan
 * More info: http://www.micahcarrick.com/tutorials/avr-microcontroller-tutorial/getting-started.html
 * Compiler stuff
 * avrdude -p m88 -P usb -c avrispmkii -Uflash:w:BlinkLED.hex
 * https://sites.google.com/site/qeewiki/books/avr-guide/digital-inputs
 */ 

//NOTE: Turned off optimization. Project->Properties->ToolChain->Optimzation
#include "utils.h"
struct Pin pin6,pin7;


void init_stuff();
int main(void)
{
	
	init_stuff();	
	printf("Starting main loop....\r\n");
	
	//Interrupts
	//init_hardware_interupt();
	//init_software_interupt(CLOCK_SECOND);
	
	//For USART Recieve
	FILE *fp;
	fp=stdin; 
	FILE *fpr;
	fpr=stdin;
	
	
	//start_pin_pwm('a',30);
		
	
	while(1)
	{	
		
		printf("no active functions running...\r\n");
		_delay_ms(1000);
		
	
		//Limit switch
		//limitswitch_test(pinLockedLS);
		
		
		//printf("waiting for interrupt...%d %d\r\n", TCNT0,TCNT1);
		//_delay_ms(100);
		
		//if(USART_Receive(fp) == 'a')printf("Got an A bitch!");
		
		/*
		int position;
		position = get_lock_position();
		if(position == LOCKED)
		{
			printf("door is locked MF\r\n");
		}
		else if(position == UNLOCKED)
		{
			printf("door is unlocked\r\n");	
		}
		else if( position == errSensorError)
		{
			printf("Sensor error...");
		}
		_delay_ms(100);
		*/
		
		//PWM
		//don't foret to init pin with -> start_pin_pwm('a',40);
		//pwm_manual(pinOCR1A, fpr);
		//pwm_toggle();	
	
		
		
	}//end while
	return 0;
	
}//end main



void init_stuff()
{
	//Init
	USART_Init(USART_BAUDRATE);
	init_hbridge();
	init_OCR_pins();
	//Done
}

//Ever time PWM overflows do this
//Todo: This doesn't work fix it
/*

//Get this to be a interupt for serial
ISR(TIMER0_OVF_vect){
	OCR1A = (dutyCycle/100.0)*255.0;
}
*/

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

#include "defines.h"
#include "PWM.h"
#include "pin.h"
#include "usart.h"
#include "avr_interupt.h"

struct Pin pin6,pin7;



void init_stuff();
void testing_stuff();


int main(void)
{
	
	init_stuff();	
	printf("Starting main loop....\r\n");
	
	
	//For USART Recieve
	FILE *fp;
	fp=stdin; 
	FILE *fpr;
	fpr=stdin;
	
	
	
	//unlock_door();
	//start_pin_pwm(pinOCR1A, 10);
	//pwm_manual(pinOCR1A, fpr);
	//testing_stuff();
	char c = 'a';
	
	
	//pin_high(pinOCR1A);
	//pin_low(pinOCR1B);
	//pin_high(pinOCR1B);
	//DDRD |= (1 << PD5);
	//DDRE &= ~(1 << PE2);	
	while(c != 'q')
	{
		//Try serial Communcation
		printf("q to quit:");
			
			
		//printf("Waiting for input\r\n");
		//_delay_ms(500);
		c = USART_Receive(fpr);
		
		
	}
	DDRD &= ~( 1 << PD5);
	DDRE &= ~( 1 << PE2);
	
	
	while(1)
	{	
		
		printf("no active functions running...\r\n");
		_delay_ms(1000);
		//testing_stuff();


		
		
	}//end while
	return 0;
	
}//end main


void testing_stuff(){
		//pin_high(pinOCR1B);

		//pin_low(pinOCR1A);
		
		//_delay_ms(1000);
				
		in_progress = TRUE;
				
		//Loop until limit switch
		///while(in_progress == TRUE)
		//;
		//Loop until limit switch
		while(in_progress == TRUE)
		{
			printf("in while...\r\n");
			_delay_ms(1000);
		}
				
		//pin_low(pinOCR1A);
		//pin_low(pinOCR1B);
		
		
		
		
		
		
		
		//pin_low(pinOCR1A);
		//pin_low(pinOCR1B);
		
}

void init_stuff()
{
	USART_Init(USART_BAUDRATE);
	init_hbridge();
	//init_hardware_interupt();
		
}


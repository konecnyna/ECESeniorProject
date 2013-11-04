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
#define F_CPU 8000000
#include "defines.h"
#include "PWM.h"
#include "pin.h"
#include "usart.h"
#include "avr_interupt.h"

//struct Pin pin6,pin7;
void init_stuff();
void testing_stuff();

void wait_for_cmd();


int main(void)
{
	
	init_stuff();	
	printf("Starting main loop....Waiting  seconds to start\r\n");
	_delay_ms(5000);
	

	FILE *fpr;
	fpr=stdin;

	while(1)
	{	
		wait_for_cmd(fpr);
	}//end while
	return 0;
	
}//end main


void wait_for_cmd(FILE *fpr){
	char cmd;
	
	while(1)
	{
		cmd = USART_Receive(fpr);
		switch(cmd){
			case 'u':
				printf("Code: %d\n\r", unlock_door());		
				break;
			
			case 'l':
				printf("Code: %d\n\r", lock_door());
				break;
			
			case 's': 
				printf("Code: %d\n\r",get_lock_position());
				break;
			
			case 'r':
				printf("Code: %d\n\r",reset_lock());
				break;
				
			default : printf("Code: %d\n\r", errInvalidCMD);
			break;
		}
	}
}


void init_stuff()
{
	USART_Init(USART_BAUDRATE);
	init_hbridge();
	init_LOCK_pins();
	//init_hardware_interupt();
		
}


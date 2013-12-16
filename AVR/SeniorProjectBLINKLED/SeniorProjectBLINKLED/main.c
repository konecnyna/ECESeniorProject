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
//main.c
//this file contains the main function that runs on the AVR

#include "defines.h"
#include "PWM.h"
#include "pin.h"
#include "usart.h"
#include "avr_interupt.h"

//struct Pin pin6,pin7;
void init_stuff();
void stress_test();

void wait_for_cmd();

int lock_count = 0;
int unlock_count = 0;
int main(void)
{
	
	init_stuff();		//initializes everything	
	printf("Starting main loop....Waiting  seconds to start\r\n");
	_delay_ms(5000);	//panic delay
	

	FILE *fpr;
	fpr=stdin;
	init_software_interupt(CLOCK_SECOND*2);	//init software interrupt 
	//Lock task ~5470cycles Unlock takes ~4690cycles Clock_SECOND 7812 so thats good time out.
	stress_test();
	while(1)
	{	
		//wait_for_cmd(fpr);
		//_delay_ms(3000);
		//printf("Something went wrong... Lock_cnt:%d, Unlock_cnt: %d\n\r",lock_count,unlock_count);
	
	}//end while
	return 0;
	
}//end main

//this function waits for a command through serial and responds accordingly
void wait_for_cmd(FILE *fpr){
	char cmd;
	
	while(1)
	{
		cmd = USART_Receive(fpr);	//receive command from pi
		switch(cmd){			//return code to the pi
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

//this function was used to stress test our project
void stress_test()
{
	int response = ERROR;

	while(1)
	{
		_delay_ms(5000);
		response = lock_door();
		
		printf("Lock %d\n\r",response);
		if(response != SUCCESS)break;
		lock_count++;
		
		_delay_ms(5000);
		response = unlock_door();
		printf("Unlock %d\n\r",response);
		if(response != SUCCESS)break;
		unlock_count++;
		

		
		printf("Lockcount:%d, Unlockcount:%d\n\r",lock_count,unlock_count);
	}
	
}

//this function calls all the init functions required
void init_stuff()
{
	USART_Init(USART_BAUDRATE);
	init_hbridge();
	init_LOCK_pins();
	//init_hardware_interupt();
		
}


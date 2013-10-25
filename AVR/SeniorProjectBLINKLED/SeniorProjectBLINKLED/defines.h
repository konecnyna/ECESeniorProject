#ifndef utils_h
#define utils_h

#include "pin.h"

#include <avr/io.h>
#include <avr/interrupt.h>
#include <util/delay.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <errno.h>
#include <avr/sfr_defs.h> //Debounce -> is_bit_clear

	
//System defines
#define F_CPU 8000000// Clock Speed
#define USART_BAUDRATE 51  //9600 prescaled from below FIX THIS
//#define BAUD_PRESCALE ( (F_CPU / (USART_BAUDRATE * 16)) - 1 )
#define CLOCK_SECOND 7812       /* The amount of cycles it takes for a second to pass. More in interupts*/
	

//Boolean
#define FALSE 0
#define TRUE 1
	
//Helpers
#define ERROR -1
#define SUCCESS 2
#define LOCKED 3
#define UNLOCKED 4
	
//Error Codes.
#define errDoorIsAlreadyLock 50
#define errDoorIsAlreadyUnlocked 51
#define errDoorUnlockInProgress 60
#define errOperationDidNotComplete 70
#define errSensorError 80
	

//Debounce	
#define LOCK_INPUT_TIME 250     /* Debounce time to wait after a button press */
#define DEBOUNCE_TIME 50        /* time to wait while "de-bouncing" button */



//For interupt
extern int in_progress;
	

#endif

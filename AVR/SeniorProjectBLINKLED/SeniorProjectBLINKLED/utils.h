#ifndef utils_h
#define utils_h

#ifdef __cplusplus
extern "C" {
	#endif
	
	//System defines
	#define F_CPU 8000000// Clock Speed
	#define USART_BAUDRATE 51  //9600 prescaled from below FIX THIS
	//#define BAUD_PRESCALE ( (F_CPU / (USART_BAUDRATE * 16)) - 1 )
	#define CLOCK_SECOND 7812       /* The amount of cycles it takes for a second to pass. More in interupts*/
	
	
	//Helpers
	#define ERROR -1
	#define SUCCESS 1
	#define LOCKED 2
	#define UNLOCKED 3
	
	
	//Error Codes.
	#define errDoorIsAlreadyLock 50
	#define errDoorIsAlreadyUnlocked 51
	#define errDoorUnlockInProgress 60
	#define errOperationDidNotComplete 70
	#define errSensorError 80
	

	//Debounce	
	#define LOCK_INPUT_TIME 250     /* Debounce time to wait after a button press */
	#define DEBOUNCE_TIME 50        /* time to wait while "de-bouncing" button */

	
	#include <avr/io.h>
	#include <avr/interrupt.h>
	#include <util/delay.h>
	#include <stdio.h>
	#include <string.h>
	#include <stdlib.h>
	#include <errno.h>
	#include <avr/sfr_defs.h> //Debounce -> is_bit_clear
	
	struct Pin pinOCR1A, pinOCR1B, pinLockedLS, pinUnlockedLS;
	
	//Pin struct to hold Register and Pin number
	typedef struct Pin{
		//Pin Number i.e. DDA6
		uint8_t No;
			
		//ARE THESE DEREFENCED!!! i.e. -> &PORTA
		//Pin Port i.e. PORTA
		volatile uint8_t* Port;
		//Pin Register i.e DDRA
		volatile uint8_t* Reg;
		//Input pints
		volatile uint8_t* InputPin;
		//Output compare reg
		volatile uint8_t* OCReg;
	};
	
	//Init
	void init_hbridge();
	void init_OCR_pins();
	
	//PWM
	void pwm_manual(struct Pin pin, FILE *fpr);
	void pwm_toggle();
	void start_pin_pwm(char pin, int dutyCycle);
	void pwm_set_duty_cycle(int dutyCycle,	volatile uint8_t* Reg);
	
	//USART Commutation
	void USART_Init( unsigned int baud );
	int USART_Transmit( unsigned char data, FILE *fp);
	void USART_Transmit_String( char* txData );
	int USART_Receive( FILE *fp );
	void USART_Flush( void );
	

	
	//Input Output
	void pin_input(Pin);
	void pin_output(Pin);
	void pin_high(Pin);
	void pin_low(Pin);
	void pin_toggle(Pin);
	uint8_t pin_read(Pin);
	
	//Limit switch
	void limitswitch_test(Pin);
	int limitswitch_raed(Pin);
	
	//Main functions
	int lockdoor();
	int unlock_door();
	int get_lock_position();
	
	
	//Interupts
	void init_hardware_interupt();
	void init_software_interupt(double time);
	
	
	#ifdef __cplusplus
}
#endif

#endif

#include "utils.h"

void init_hbridge() 
{
	// According to Bruce and experience
	// Hbrige pins must be set low on both sides otherwise it will smoke hdbrige
	// So must set OCA1 (PD5) and OCB1 (PE2) low.
	//Set hbridge NMos and PMos to low
	
	//Set Low
	pin_low(pinOCR1A);
	pin_low(pinOCR1B);
	//PORTD &= ~(1 << PD5);
	//PORTE &= ~(1 << PE2);
	
	// Set as output
	
	DDRD = (1 << PD5);
	DDRE = (1 << PE2);
	
		
	//If h-bridge is overheating use this
	//PORTD |= (1 << PD5);
	//PORTE |= (1 << PE2);
}

void init_OCR_pins()
{
	//OCR pins
	pinOCR1A.No = PD5;
	pinOCR1A.Port = &PORTD;
	//pinOCR1A.InputPin = &OCR1A;
	pinOCR1A.Reg = &DDRD;
	pinOCR1A.OCReg = &OCR1A;
	
	pinOCR1B.No = PE2;
	pinOCR1B.Port = &PORTE;
	//pinOCR1B.InputPin = 0;
	pinOCR1B.OCReg = &OCR1B;
	pinOCR1B.Reg = &DDRE;
	
	
	//Define Limitswitch structs.
	
	//Make a pin struct for LED
	//struct Pin pin7;
	
	pinLockedLS.InputPin = 0;
	pinLockedLS.No = PD2;
	pinLockedLS.Port = &PORTD;
	pinLockedLS.Reg = &DDRD;
	pinLockedLS.OCReg=0;
	
	
	pinUnlockedLS.InputPin = 0;
	pinUnlockedLS.No = PD3;
	pinUnlockedLS.Port = &PORTD;
	pinUnlockedLS.Reg = &DDRD;
	
	
	/*
	pinLockedLS.No = DDA7;
	pinLockedLS.Port = &PORTA;
	pinLockedLS.Reg = &DDRA;
	pinLockedLS.InputPin = &PINA;
	pin_input(pinLockedLS);
	
	//Make a pin struct for LED
	//struct Pin pin6;
	pinUnlockedLS.No = DDA6;
	pinUnlockedLS.Port = &PORTA;
	pinUnlockedLS.Reg = &DDRA;
	pinUnlockedLS.InputPin = &PINA;
	pin_input(pinUnlockedLS);
		*/
	
}




//**********************************************//
// USART Commucation Functions                  //
//**********************************************//
// http://forum.josephn.net/viewtopic.php?f=19&t=75
//http://www.josephn.net/avr/usart_and_eeprom_on_avr_atmega8515


//Taken from datasheet pg141
//http://www.atmel.com/images/doc2512.pdf
static FILE serial_stream = FDEV_SETUP_STREAM (USART_Transmit, USART_Receive, _FDEV_SETUP_RW);
void USART_Init( unsigned int baud )
{
	cli();
	UBRRH = (unsigned char)(baud>>8);
	UBRRL = (unsigned char)baud;
	
	/* Enable receiver and transmitter */
	UCSRB = (1<<RXEN)|(1<<TXEN);
	
	/* Set frame format: 8data, 1stop bit */
	//UCSRC = (1<<URSEL)|(3<<UCSZ0);
	
	/* Set frame format: 8data, 2stop bit */
	UCSRC = (1<<URSEL)|(1<<USBS)|(3<<UCSZ0);
	
	stdin=&serial_stream;
	stdout=&serial_stream;
	
	//Enable Serial Interupt
	sei();
}

//Taken from datasheet pg142
//http://www.atmel.com/images/doc2512.pdf
int USART_Transmit( unsigned char data, FILE * fp)
{
	/* Wait for empty transmit buffer */
	while ( !( UCSRA & (1<<UDRE)) )
	;
	/* Put data into buffer, sends the data */
	UDR = data;
	
	return 0;
}

void USART_Transmit_String( char* txData )
{
	char success = 0;
	int i = 0;
	while (*txData) {
		//USART_Transmit(*txData);
		txData++;
	}

}

int USART_Receive( FILE * fp )
{
	/* Wait for data to be received */
	while ( !(UCSRA & (1<<RXC)) )
	;
	/* Get and return received data from buffer */
	return UDR;
}

void USART_Flush( void )
{
	unsigned char dummy;
	while ( UCSRA & (1<<RXC) ) dummy = UDR;
}
/************************************************************************/
/*    End of USART Commucation Functions                                */
/************************************************************************/



/************************************************************************/
/*                    Pin Manipulation                                  */
/************************************************************************/
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
	*(pin.Port) &= ~(_BV(pin.No));
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
/*                          PWM Functions                               */
/************************************************************************/
void pwm_manual(struct Pin pin, FILE *fpr)
{
	//don't foret to init pin with -> start_pin_pwm('a',40);
	int pwm = 25;
	
	while(1)
	{
		//Try serial Communcation
		printf("Press a to increase PWM, s to decrease pwm:");
			
			
		printf("Waiting for input\r\n");
		//_delay_ms(500);
		char c;
		c = USART_Receive(fpr);
		if(c == 'a')
		{
			if(pwm > 0)
			{
				pwm--;
			}
			pwm_set_duty_cycle(pwm,pin.OCReg) ;
			printf("PWM Down: %d\r\n", pwm);
		}
		else if(c == 's')
		{
			if(pwm < 100)
			{
				pwm++;
			}
			pwm_set_duty_cycle(pwm,pin.OCReg);
			printf("PWM Up: %d\r\n", pwm);
		}
	}
}

void pwm_toggle()
{
	while(1)
	{
		printf("Start OCR1B\r\n");
		start_pin_pwm('b',30);
		_delay_ms(60000);
		
		printf("Start OCR1A\r\n");
		start_pin_pwm('a',30);
		_delay_ms(60000);
	}
}

void start_pin_pwm(char pin, int dutyCycle)
{
	
	if(pin == 'a')
	{
		// So must set OCA1 (PD5) and OCB1 (PE2) low.
		// Set OCR1A as output
		DDRD |= (1 << PD5);
		
		//Make sure OCR1B is low! 
		PORTE &= ~(1 << PE2);
		
		//Timer COntrol Register TCCR1A/B. Pg 91
		// pg 119 COM1A1 Connected
		// WGMBits - Fast PWM 8bit Top 0x00FF (255) | Set WGM12 and 10 for fast pwm 8-bit
		// Set on match, clear on TOP
		TCCR1A  = ((1 << COM1A1) | (1 << COM1A0));
		// Phase + Frequency Correct PWM, Fcpu speed
		TCCR1B  = ((1 << CS10) | (1 << WGM13));
		
		//Set the voltages level Duty=30 ~= 3.43V
		pwm_set_duty_cycle(dutyCycle, &OCR1A);
		
		//Set cutoff for PWM i.e. max
		ICR1  = 255;
		
		//Delay to make sure everything is where it should be.
		_delay_ms(500);		
	}
	else if(pin == 'b')
	{
		DDRE |= (1 << PE2);
		PORTD &= ~(1 << PD5);
		
		//Only change COM1A1 -> COM1B1.		
		TCCR1A  = ((1 << COM1B1) | (1 << COM1B0));
		TCCR1B  = ((1 << CS10) | (1 << WGM13));
				
		pwm_set_duty_cycle(dutyCycle, &OCR1B);
		ICR1  = 255;
		_delay_ms(500);	
	}
	
	
	
}

void pwm_set_duty_cycle(int dutyCycle, 	volatile uint8_t* Reg)
{
	*(Reg)  = (dutyCycle/100.0)*255.0;
}


/************************************************************************/
/*                Limit switch logic                                    */
/*          Connect green to VCC and red with a resistor to Pin         */
/*         http://www.instructables.com/file/F04ZYTFGKS0TZKZ            */
/************************************************************************/

void limitswitch_test(struct Pin pin){
	//Push Button code
	int count = 0;
	while(1)
	{	
		printf("%d \r\n",pin_read(pin));
		_delay_ms(100);
		
		
		if(limitswitch_read(pin))
		{
			printf("Limitswitch is pressed %d!\r\n", count);
			count++;
			_delay_ms(1000);
			//fordebounce
			_delay_ms(LOCK_INPUT_TIME);
		}
		
		_delay_ms(100);
	}
}


int limitswitch_read(struct Pin pin)
{
	//Returns true if press false otherwise
	/* the button is pressed when BUTTON_BIT is clear */
	if (bit_is_clear(*(pin.InputPin), pin.No))
	{
		_delay_ms(DEBOUNCE_TIME);
		if (bit_is_clear(*(pin.InputPin), pin.No)) return 0;
	}
	return 1;
}


/************************************************************************/
/*               Lock and Unlock Functions                              */
/************************************************************************/

int get_lock_position()
{
	if(limitswitch_read(pinLockedLS))
	{
		return LOCKED;
	}
	else if (limitswitch_read(pinUnlockedLS))
	{
		return UNLOCKED;
	}else
	{
		return errSensorError;
	}
	
}



int lock_door()
{
	//Check position of door.
	if(get_lock_position() == LOCKED)
	{
		//Lock door
		start_pin_pwm('a',30);
		_delay_ms(100);
		if(get_lock_position()== UNLOCKED)
		{
			return SUCCESS;
		}
		else
		{
			return ERROR;
		}	
	}
	else
	{
		printf("Error: Door is already locked.");
		return errDoorIsAlreadyLock;
	}
	
	
}

int unlock_door()
{
	//Check position of door.
	if(get_lock_position() == UNLOCKED)
	{
		//UnLock door
		//Negative voltage B
		start_pin_pwm('b',30);
		_delay_ms(100);
		
		if(get_lock_position()== LOCKED)
		{
			return SUCCESS;
		}
		else
		{
			return ERROR;
		}
	}
	else
	{
		printf("Error: Door is already unlocked.");
		return errDoorIsAlreadyUnlocked;
	}	
}



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
	pin_input(pinLockedLS);
	//pin_input(pinUnlockedLS);
	PORTD = 1<<PD2;
	
	//PORTD = 1<<PD3; //fix this
		
		
	//Enable Interupt
	GICR = 1<<INT0;
	//GICR = 1<<INT1;
	MCUCR = 1<<ISC01 | 1<<ISC00;
	
}

void init_software_interupt(double time)
{
	//http://www.engblaze.com/microcontroller-tutorial-avr-and-arduino-timer-interrupts/
	// 1 Second = 7812
	// Calc: Desiredtime/( (1/F)/1024 )
	// 1 / (1/( (8*10^6)/1024) ) = 7812 ~ 1 second
	
	OCR1A = time;
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
ISR(INT0_vect)
{
	//PD2 and PD3 are external interupts.
	printf("In locked HW interrupt %d\r\n", TCNT0);
}
ISR(INT1_vect)
{
	printf("in unlock HW interrupt");
}
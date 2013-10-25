/*
 * PWM.c
 *
 * Created: 10/21/2013 8:16:53 PM
 *  Author: Nick
 */ 


/************************************************************************/
/*                          PWM Functions                               */
/************************************************************************/
#include "PWM.h"

void pwm_manual(struct Pin pin, FILE *fpr)
{
	//don't foret to init pin with -> start_pin_pwm('a',40);
	int pwm = 25;
	char c;
	pin_low(pinOCR1B);
	
	while(c != 'q')
	{
		//Try serial Communcation
		printf("Press a to increase PWM, s to decrease pwm, q to quit:");
			
			
		printf("Waiting for input\r\n");
		//_delay_ms(500);
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
		//start_pin_pwm(',30);
		_delay_ms(60000);
		
		printf("Start OCR1A\r\n");
		//start_pin_pwm('a',30);
		_delay_ms(60000);
	}
}

void start_pin_pwm(struct Pin pin, int dutyCycle)
{

	//THrow an error if ocr1a pins arent setup
		

	TCCR1A  = ((1 << COM1A1) | (1 << COM1A0));
	// Phase + Frequency Correct PWM, Fcpu speed
	TCCR1B  = ((1 << CS10) | (1 << WGM13));
		
	//Set the voltages level Duty=30 ~= 3.43V
	//pwm_set_duty_cycle(dutyCycle, pin.OCReg);
	
	//pin_high(pinOCR1B);
	pin_low(pinOCR1B);
	pin_low(pinOCR1A);

		
	//Set cutoff for PWM i.e. max
	ICR1  = 255;
		
	//Delay to make sure everything is where it should be.
	_delay_ms(500);		
	
	
	
}

void pwm_set_duty_cycle(int dutyCycle, 	volatile uint8_t* Reg)
{
	*(Reg)  = (dutyCycle/100.0)*255.0;
}

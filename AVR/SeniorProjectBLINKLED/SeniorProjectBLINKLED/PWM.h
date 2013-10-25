#ifndef PWM_h
#define PWM_h

#include "defines.h"

#ifdef __cplusplus
extern "C" {
	#endif
	


	//PWM
	void pwm_manual(struct Pin pin, FILE *fpr);
	void pwm_toggle();
	void start_pin_pwm(struct Pin pin, int dutyCycle);
	void pwm_set_duty_cycle(int dutyCycle,	volatile uint8_t* Reg);
	
		
	#ifdef __cplusplus
}
#endif

#endif
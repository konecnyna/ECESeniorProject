#ifndef avr_interupt_h
#define avr_interupt_h

#include "defines.h"
#include "motor.h"
#ifdef __cplusplus
extern "C" {
	#endif
	

	
	//Interupts
	void init_hardware_interupt();
	void init_software_interupt(double time);

	
	#ifdef __cplusplus
}
#endif

#endif
#ifndef pin_h
#define pin_h

#include "defines.h"
#include "stdint.h"

#ifdef __cplusplus
extern "C" {
	#endif
	
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
	
	
	//Input Output
	void pin_input(struct Pin);
	void pin_output(struct Pin);
	void pin_high(struct Pin);
	void pin_low(struct Pin);
	void pin_toggle(struct Pin);
	uint8_t pin_read(struct Pin);


	//Init pins
	void init_OCR_pins();
	void init_LOCK_pins();
	
	#ifdef __cplusplus
}
#endif

#endif
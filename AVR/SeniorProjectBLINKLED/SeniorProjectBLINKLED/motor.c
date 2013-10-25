#include "motor.h"
#include "defines.h"
/************************************************************************/
/*                Limit switch logic                                    */
/*          Connect green to VCC and red with a resistor to Pin         */
/*         http://www.instructables.com/file/F04ZYTFGKS0TZKZ            */
/************************************************************************/

void limitswitch_test(struct Pin pin){
	int count = 0;
	while(1)
	{
		//printf("%d \r\n",pin_read(pin));
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
	//check both limit switches at once
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
		pin_high(pinOCR1A);
		pin_low(pinOCR1B);
				
		in_progress = TRUE;
		
		//Loop until limit switch
		while(in_progress == TRUE)
		;
		
		pin_low(pinOCR1A);
		pin_low(pinOCR1B);
		
		if(get_lock_position()== UNLOCKED)
		{
			return SUCCESS;
		}
		else
		{
			return ERROR;
		}
	}//Change so you check fur both stuff
	else
	{
		printf("Error: Door is already locked.");
		return errDoorIsAlreadyLock;
	}
	
	
}

int unlock_door()
{
	//Check position of door.
	//if(get_lock_position() == UNLOCKED)
	if(UNLOCKED == UNLOCKED)
	{
		//UnLock door
		pin_high(pinOCR1B);
		pin_low(pinOCR1A);
		
		in_progress = TRUE;
				
		//Loop until limit switch
		while(in_progress == TRUE)
		;
		
		pin_low(pinOCR1A);
		pin_low(pinOCR1B);
	
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




void init_hbridge()
{
	// According to Bruce and experience
	// Hbrige pins must be set low on both sides otherwise it will smoke hdbrige
	// So must set OCA1 (PD5) and OCB1 (PE2) low.
	//Set hbridge NMos and PMos to low
	

	init_OCR_pins();
	//Set Low
	pin_low(pinOCR1A);
	pin_low(pinOCR1B);
	
	pin_output(pinOCR1A);
	pin_output(pinOCR1B);
	

}
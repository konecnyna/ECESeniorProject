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



//Hook green wire to ground
//Hook red to pin.
//When pin is floating its high otherwise ground dat bitch.
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
	if(limitswitch_read(pinLockedLS) && limitswitch_read(pinUnlockedLS) == 0)
	{
		return LOCKED;
	}
	else if (limitswitch_read(pinUnlockedLS) && limitswitch_read(pinLockedLS)==0)
	{
		return UNLOCKED;
	}else
	{
		return errSensorError;
	}
	
}


int reset_lock(){
		//Check position of door.
		if(get_lock_position() == errSensorError)
		{
			//Lock door
			pin_high(pinOCR1B);
			pin_low(pinOCR1A);
			
			in_progress = TRUE;
			while(in_progress == TRUE){
				//printf("inlockloop\r\n");
				if(limitswitch_read(pinLockedLS) > 0){
					in_progress = FALSE;
				}
			}
			

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
		}//Change so you check fur both stuff
		else
		{
			//printf("Error: Door is already locked.");
			return get_lock_position();
		}
}

int lock_door()
{
	//Check position of door.
	if(get_lock_position() == UNLOCKED)
	{
		
		//Lock door
		pin_high(pinOCR1B);
		pin_low(pinOCR1A);
				
		in_progress = TRUE;
		while(in_progress == TRUE){
			//printf("inlockloop\r\n");
			if(limitswitch_read(pinLockedLS) > 0){
				in_progress = FALSE;
			}
		}
				
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
	}else if(get_lock_position() == errSensorError){
		return errSensorError;
	}//Change so you check fur both stuff
	else
	{
		//printf("Error: Door is already locked.");
		return errDoorIsAlreadyLock;
	}
	
	
}

int unlock_door()
{
	if(get_lock_position()  == LOCKED)
	{
		
		in_progress = TRUE;
		pin_high(pinOCR1A);
		pin_low(pinOCR1B);
		while(in_progress == TRUE){
			//printf("inunlockloop\r\n");
			if(limitswitch_read(pinUnlockedLS) > 0){
				in_progress = FALSE;
			}
		}
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
	}else if(get_lock_position() == errSensorError){
		return errSensorError;
	}
	else
	{
		return errDoorIsAlreadyUnlocked;
	}
}


int door_status()
{
	//printf("Statuscase - Code: %d\n\r",get_lock_position());
	//printf("Unlock: %d||Loc: %d\n\r",limitswitch_read(pinUnlockedLS), limitswitch_read(pinLockedLS));
	return get_lock_position();
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
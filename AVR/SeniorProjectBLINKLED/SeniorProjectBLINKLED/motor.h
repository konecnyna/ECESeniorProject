//motor.h
//header file for motor.c
#ifndef motor_h
#define motor_h



#ifdef __cplusplus
extern "C" {
	#endif
	
	//Define for while

	//Init
	void init_hbridge();
	
	//Limit switch
	void limitswitch_test(Pin);
	int limitswitch_read(Pin);
	
	//Main functions
	int lockdoor();
	int reset_lock();
	int unlock_door();
	int door_status();
	int get_lock_position();
	
	#ifdef __cplusplus
}
#endif

#endif

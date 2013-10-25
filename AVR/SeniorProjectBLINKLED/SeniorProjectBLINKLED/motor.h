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
	int limitswitch_raed(Pin);
	
	//Main functions
	int lockdoor();
	int unlock_door();
	int get_lock_position();
	
	#ifdef __cplusplus
}
#endif

#endif